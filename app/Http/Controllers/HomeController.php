<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\HomeSlide;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $slides = HomeSlide::orderBy('sort_order')->orderBy('id')->get();
        $testimonials = Testimonial::orderBy('sort_order')->orderBy('id')->get();
        return view('index', compact('slides', 'testimonials'));
    }

    public function about()
    {
        return view('about');
    }

    public function services()
    {
        $services = \App\Models\Service::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();
        return view('services', compact('services'));
    }

    public function servicesShow($slug)
    {
        $service = \App\Models\Service::where('slug', $slug)->where('is_active', true)->first();
        if ($service) {
            return view('services.show', compact('service'));
        }
        abort(404);
    }

    public function compare()
    {
        $banks = \App\Models\ComparisonBank::orderBy('sort_order')->orderBy('id')->get();
        return view('compare-loans', compact('banks'));
    }

    public function testimonials()
    {
        $testimonials = Testimonial::orderBy('sort_order')->orderBy('id')->get();
        return view('testimonials', compact('testimonials'));
    }

    public function faq()
    {
        $services = \App\Models\Service::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();
        return view('faq', compact('services'));
    }

    public function blog()
    {
        $blogs = \App\Models\Blog::orderBy('published_at', 'desc')->orderBy('id', 'desc')->get();
        return view('blog.index', compact('blogs'));
    }

    public function blogShow($slug)
    {
        $blog = \App\Models\Blog::where('slug', $slug)->first();
        if ($blog) {
            return view('blog.show', compact('blog'));
        }
        if (view()->exists("blog.{$slug}")) {
            return view("blog.{$slug}");
        }
        abort(404);
    }

    public function contact()
    {
        return view('contact');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'email' => 'nullable|email|max:255',
        ]);

        $siteSettings = \App\Models\SiteParameter::all()->pluck('value', 'id')->toArray();
        
        // 1. Google reCAPTCHA Verification (if enabled)
        if (!empty($siteSettings['recaptcha_enabled']) && $siteSettings['recaptcha_enabled'] == '1') {
            $recaptchaResponse = $request->input('g-recaptcha-response');
            $secretKey = $siteSettings['recaptcha_secret_key'] ?? '';
            
            if (empty($recaptchaResponse)) {
                return redirect()->back()->withInput()->with('error', 'Please complete the Google reCAPTCHA verification to submit the form.');
            }
            
            $verifyResponse = \Illuminate\Support\Facades\Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secretKey,
                'response' => $recaptchaResponse,
                'remoteip' => $request->ip()
            ]);
            
            if (!$verifyResponse->successful() || !$verifyResponse->json('success')) {
                return redirect()->back()->withInput()->with('error', 'Google reCAPTCHA verification failed. Please try again.');
            }
        }

        // 2. Build detailed compilation message
        $compiledMessage = '';
        if ($request->filled('loan_type')) {
            $compiledMessage .= 'Loan Type: ' . ucwords($request->loan_type) . "\n";
        }
        if ($request->filled('amount')) {
            $compiledMessage .= 'Expected Amount: ₹' . number_format($request->amount) . "\n";
        }
        if ($request->filled('service')) {
            $compiledMessage .= 'Service: ' . str_replace('-', ' ', ucwords($request->service)) . "\n";
        }
        if ($request->filled('message')) {
            $compiledMessage .= 'Details: ' . $request->message . "\n";
        }

        // 3. Save Lead to MySQL
        try {
            // Auto-create leads table if it doesn't exist (for live server compatibility)
            if (!\Illuminate\Support\Facades\Schema::hasTable('leads')) {
                \Illuminate\Support\Facades\Schema::create('leads', function (\Illuminate\Database\Schema\Blueprint $table) {
                    $table->id();
                    $table->string('name');
                    $table->string('phone');
                    $table->string('email')->nullable();
                    $table->text('message')->nullable();
                    $table->string('source')->default('Contact Form');
                    $table->string('status')->default('New');
                    $table->text('notes')->nullable();
                    $table->timestamps();
                });
                \Illuminate\Support\Facades\Log::info('Leads table auto-created on live server.');
            }

            \App\Models\Lead::create([
                'name'    => $request->name,
                'phone'   => $request->phone,
                'email'   => $request->email,
                'message' => $compiledMessage ?: 'Requesting a quick callback/consultation.',
                'source'  => $request->input('source', 'Contact Form'),
                'status'  => 'New',
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Lead save failed: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ':' . $e->getLine());
        }

        return redirect()->route('thank-you');
    }

    public function thankYou()
    {
        return view('thank-you');
    }
}
