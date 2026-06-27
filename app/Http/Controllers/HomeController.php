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
        ]);

        return redirect()->back()->with('success', 'Thank you for contacting MLG Finedge. One of our senior loan advisors will review your request and get in touch with you shortly.');
    }
}
