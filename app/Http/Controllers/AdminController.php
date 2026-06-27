<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SiteParameter;
use App\Models\HomeSlide;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function loginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function dashboard()
    {
        $parameters = SiteParameter::all()->groupBy('category');
        $slides = HomeSlide::orderBy('sort_order')->orderBy('id')->get();
        $testimonials = Testimonial::orderBy('sort_order')->orderBy('id')->get();
        $blogs = \App\Models\Blog::orderBy('published_at', 'desc')->orderBy('id', 'desc')->get();
        
        // Scan public storage for media files
        $mediaFiles = [];
        try {
            $files = Storage::disk('public')->allFiles();
            foreach ($files as $file) {
                if (!str_starts_with(basename($file), '.')) {
                    $mediaFiles[] = [
                        'path' => $file,
                        'url' => asset('storage/' . $file),
                        'name' => basename($file),
                        'size' => Storage::disk('public')->size($file),
                        'time' => Storage::disk('public')->lastModified($file)
                    ];
                }
            }
            usort($mediaFiles, function($a, $b) {
                return $b['time'] <=> $a['time'];
            });
        } catch (\Exception $e) {
            // Silently fail
        }

        // Fetch all page contents to let user edit them
        $pageContents = \App\Models\PageContent::all();

        $services = \App\Models\Service::orderBy('sort_order')->orderBy('id')->get();
        $banks = \App\Models\ComparisonBank::orderBy('sort_order')->orderBy('id')->get();
        
        return view('admin.dashboard', compact('parameters', 'slides', 'testimonials', 'blogs', 'mediaFiles', 'pageContents', 'services', 'banks'));
    }

    public function updateParameters(Request $request)
    {
        $data = $request->except(['_token', 'logo', 'favicon']);
        
        foreach ($data as $key => $value) {
            $param = SiteParameter::find($key);
            if ($param) {
                $param->update(['value' => $value]);
            } else {
                SiteParameter::create([
                    'id' => $key,
                    'value' => $value,
                    'label' => ucwords(str_replace('_', ' ', $key)),
                    'category' => $this->getParameterCategory($key),
                ]);
            }
        }

        // Handle custom logo upload and conversion to WebP (keep SVG intact)
        if ($request->hasFile('logo')) {
            $logoPath = $this->uploadAndConvertToWebP($request->file('logo'), 'branding');
            if ($logoPath) {
                // Delete old logo file if exists
                $oldLogo = SiteParameter::find('logo_path');
                if ($oldLogo && $oldLogo->value) {
                    Storage::disk('public')->delete($oldLogo->value);
                }
                
                SiteParameter::updateOrCreate(
                    ['id' => 'logo_path'],
                    ['value' => $logoPath, 'label' => 'Custom Logo Image (WebP)', 'category' => 'branding']
                );
            }
        }

        // Handle custom favicon upload
        if ($request->hasFile('favicon')) {
            $faviconPath = $this->uploadAndConvertToWebP($request->file('favicon'), 'branding');
            if ($faviconPath) {
                $oldFav = SiteParameter::find('favicon_path');
                if ($oldFav && $oldFav->value) {
                    Storage::disk('public')->delete($oldFav->value);
                }
                
                SiteParameter::updateOrCreate(
                    ['id' => 'favicon_path'],
                    ['value' => $faviconPath, 'label' => 'Custom Favicon Image (WebP)', 'category' => 'branding']
                );
            }
        }

        return redirect()->back()->with('success', 'Parameters and branding updated successfully!');
    }

    /* Homepage Slides CRUD */
    public function storeSlide(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:5000',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadAndConvertToWebP($request->file('image'), 'slider');
        }

        HomeSlide::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'sort_order' => $request->sort_order ?? 0,
            'image_path' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Slide added successfully!');
    }

    public function updateSlide(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:5000',
        ]);

        $slide = HomeSlide::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($slide->image_path) {
                Storage::disk('public')->delete($slide->image_path);
            }
            $slide->image_path = $this->uploadAndConvertToWebP($request->file('image'), 'slider');
        }

        $slide->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->back()->with('success', 'Slide updated successfully!');
    }

    public function deleteSlide($id)
    {
        $slide = HomeSlide::findOrFail($id);
        if ($slide->image_path) {
            Storage::disk('public')->delete($slide->image_path);
        }
        $slide->delete();

        return redirect()->back()->with('success', 'Slide deleted successfully!');
    }

    /* Testimonials CRUD */
    public function storeTestimonial(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'avatar' => 'nullable|image|max:2000',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $this->uploadAndConvertToWebP($request->file('avatar'), 'testimonials');
        }

        Testimonial::create([
            'name' => $request->name,
            'role' => $request->role,
            'content' => $request->content,
            'rating' => $request->rating,
            'sort_order' => $request->sort_order ?? 0,
            'avatar_path' => $avatarPath,
        ]);

        return redirect()->back()->with('success', 'Testimonial added successfully!');
    }

    public function updateTestimonial(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'avatar' => 'nullable|image|max:2000',
        ]);

        $testimonial = Testimonial::findOrFail($id);

        if ($request->hasFile('avatar')) {
            if ($testimonial->avatar_path) {
                Storage::disk('public')->delete($testimonial->avatar_path);
            }
            $testimonial->avatar_path = $this->uploadAndConvertToWebP($request->file('avatar'), 'testimonials');
        }

        $testimonial->update([
            'name' => $request->name,
            'role' => $request->role,
            'content' => $request->content,
            'rating' => $request->rating,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->back()->with('success', 'Testimonial updated successfully!');
    }

    public function deleteTestimonial($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        if ($testimonial->avatar_path) {
            Storage::disk('public')->delete($testimonial->avatar_path);
        }
        $testimonial->delete();

        return redirect()->back()->with('success', 'Testimonial deleted successfully!');
    }

    /* Blogs CRUD */
    public function storeBlog(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'summary' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|max:5000',
            'slug' => 'nullable|string|max:255|unique:blogs,slug',
        ]);

        $slug = $request->slug ?: \Illuminate\Support\Str::slug($request->title);
        $count = \App\Models\Blog::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . time();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadAndConvertToWebP($request->file('image'), 'blog');
        }

        \App\Models\Blog::create([
            'title' => $request->title,
            'slug' => $slug,
            'category' => $request->category,
            'summary' => $request->summary,
            'content' => $request->content,
            'image_path' => $imagePath,
            'published_at' => $request->published_at ? \Carbon\Carbon::parse($request->published_at) : now(),
        ]);

        return redirect()->back()->with('success', 'Blog post created successfully!');
    }

    public function updateBlog(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'summary' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|max:5000',
            'slug' => 'required|string|max:255|unique:blogs,slug,' . $id,
        ]);

        $blog = \App\Models\Blog::findOrFail($id);

        $imagePath = $blog->image_path;
        if ($request->hasFile('image')) {
            if ($blog->image_path) {
                Storage::disk('public')->delete($blog->image_path);
            }
            $imagePath = $this->uploadAndConvertToWebP($request->file('image'), 'blog');
        }

        $blog->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'category' => $request->category,
            'summary' => $request->summary,
            'content' => $request->content,
            'image_path' => $imagePath,
            'published_at' => $request->published_at ? \Carbon\Carbon::parse($request->published_at) : $blog->published_at,
        ]);

        return redirect()->back()->with('success', 'Blog post updated successfully!');
    }

    public function deleteBlog($id)
    {
        $blog = \App\Models\Blog::findOrFail($id);
        if ($blog->image_path) {
            Storage::disk('public')->delete($blog->image_path);
        }
        $blog->delete();

        return redirect()->back()->with('success', 'Blog post deleted successfully!');
    }

    /* Page Content Updates */
    public function updatePageContents(Request $request)
    {
        $contents = $request->input('contents', []);
        
        foreach ($contents as $page => $sections) {
            if (is_array($sections)) {
                foreach ($sections as $section => $keys) {
                    if (is_array($keys)) {
                        foreach ($keys as $key => $value) {
                            \App\Models\PageContent::updateOrCreate(
                                ['page' => $page, 'section' => $section, 'key' => $key],
                                ['value' => $value]
                            );
                        }
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Page contents updated successfully!');
    }

    /* Media Upload Manager */
    public function uploadMedia(Request $request)
    {
        $request->validate([
            'file' => 'required|file|image|max:10000',
        ]);

        if ($request->hasFile('file')) {
            $path = $this->uploadAndConvertToWebP($request->file('file'), 'uploads');
            if ($path) {
                $url = asset('storage/' . $path);
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'url' => $url,
                        'name' => basename($path),
                    ]);
                }
                return redirect()->back()->with('success', 'File uploaded and optimized to WebP successfully! URL: ' . $url);
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => false, 'message' => 'Upload failed.'], 400);
        }
        return redirect()->back()->with('error', 'Upload failed.');
    }

    /* Helper function for uploading and optimizing images to WebP format */
    private function uploadAndConvertToWebP($file, $folder)
    {
        if (!$file) return null;
        
        $extension = $file->getClientOriginalExtension();
        
        // If SVG, save directly to preserve vector paths
        if (strtolower($extension) === 'svg') {
            return $file->store($folder, 'public');
        }
        
        $filePath = $file->getRealPath();
        $image = null;
        
        switch (strtolower($extension)) {
            case 'jpeg':
            case 'jpg':
                $image = imagecreatefromjpeg($filePath);
                break;
            case 'png':
                $image = imagecreatefrompng($filePath);
                if ($image) {
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                }
                break;
            case 'gif':
                $image = imagecreatefromgif($filePath);
                if ($image) imagepalettetotruecolor($image);
                break;
            case 'webp':
                $image = imagecreatefromwebp($filePath);
                break;
            default:
                return $file->store($folder, 'public');
        }
        
        if (!$image) {
            return $file->store($folder, 'public');
        }
        
        // Generate WebP filename
        $filename = uniqid() . '.webp';
        $fullPath = $folder . '/' . $filename;
        
        // Save using Laravel Storage with webp compression quality (80%)
        ob_start();
        imagewebp($image, null, 80);
        $webpData = ob_get_clean();
        imagedestroy($image);
        
        Storage::disk('public')->put($fullPath, $webpData);
        
        return $fullPath;
    }

    /* Services CRUD */
    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug',
            'hero_category' => 'nullable|string|max:255',
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'nullable|string',
            'rate_value' => 'nullable|string|max:255',
            'max_loan' => 'nullable|string|max:255',
            'tenure' => 'nullable|string|max:255',
            'intro_title' => 'nullable|string|max:255',
            'intro_content' => 'nullable|string',
            'eligibility_criteria' => 'nullable|string',
            'documents_required' => 'nullable|string',
            'tips_title' => 'nullable|string|max:255',
            'tips_content' => 'nullable|string',
            'badge' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['service_name']);
        }

        // Handle FAQs
        $faqs = [];
        $questions = $request->input('faq_questions', []);
        $answers = $request->input('faq_answers', []);
        if (is_array($questions)) {
            foreach ($questions as $i => $q) {
                if (!empty($q) && !empty($answers[$i])) {
                    $faqs[] = ['question' => $q, 'answer' => $answers[$i]];
                }
            }
        }
        $validated['faqs'] = $faqs;
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        \App\Models\Service::create($validated);

        return redirect()->back()->with('success', 'Service page created successfully!');
    }

    public function updateService(Request $request, $id)
    {
        $service = \App\Models\Service::findOrFail($id);

        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:services,slug,' . $id,
            'hero_category' => 'nullable|string|max:255',
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'nullable|string',
            'rate_value' => 'nullable|string|max:255',
            'max_loan' => 'nullable|string|max:255',
            'tenure' => 'nullable|string|max:255',
            'intro_title' => 'nullable|string|max:255',
            'intro_content' => 'nullable|string',
            'eligibility_criteria' => 'nullable|string',
            'documents_required' => 'nullable|string',
            'tips_title' => 'nullable|string|max:255',
            'tips_content' => 'nullable|string',
            'badge' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $faqs = [];
        $questions = $request->input('faq_questions', []);
        $answers = $request->input('faq_answers', []);
        if (is_array($questions)) {
            foreach ($questions as $i => $q) {
                if (!empty($q) && !empty($answers[$i])) {
                    $faqs[] = ['question' => $q, 'answer' => $answers[$i]];
                }
            }
        }
        $validated['faqs'] = $faqs;
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $service->update($validated);

        return redirect()->back()->with('success', 'Service page updated successfully!');
    }

    public function deleteService($id)
    {
        $service = \App\Models\Service::findOrFail($id);
        $service->delete();

        return redirect()->back()->with('success', 'Service page deleted successfully!');
    }

    /* Comparison Banks CRUD */
    public function storeBank(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'home_rate' => 'required|numeric',
            'personal_rate' => 'required|numeric',
            'business_rate' => 'required|numeric',
            'fee_percent' => 'required|numeric',
            'sector' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        \App\Models\ComparisonBank::create($validated);

        return redirect()->back()->with('success', 'Comparison bank added successfully!');
    }

    public function updateBank(Request $request, $id)
    {
        $bank = \App\Models\ComparisonBank::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'home_rate' => 'required|numeric',
            'personal_rate' => 'required|numeric',
            'business_rate' => 'required|numeric',
            'fee_percent' => 'required|numeric',
            'sector' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $bank->update($validated);

        return redirect()->back()->with('success', 'Comparison bank updated successfully!');
    }

    public function deleteBank($id)
    {
        $bank = \App\Models\ComparisonBank::findOrFail($id);
        $bank->delete();

        return redirect()->back()->with('success', 'Comparison bank deleted successfully!');
    }

    private function getParameterCategory($key)
    {
        if (str_contains($key, 'rate')) return 'rates';
        if (in_array($key, ['phone', 'email', 'address', 'whatsapp_number'])) return 'contact';
        if (in_array($key, ['site_name', 'site_tagline', 'google_tag_id', 'header_scripts'])) return 'general';
        if (str_contains($key, 'bg') || str_contains($key, 'color') || str_contains($key, 'styling')) return 'styling';
        return 'other';
    }
}
