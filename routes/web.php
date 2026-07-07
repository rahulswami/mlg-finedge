<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

// Public Pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/services/{slug}', [HomeController::class, 'servicesShow'])->name('services.show');
Route::get('/compare-loans', [HomeController::class, 'compare'])->name('compare');
Route::get('/testimonials', [HomeController::class, 'testimonials'])->name('testimonials');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [HomeController::class, 'blogShow'])->name('blog.show');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact/submit', [HomeController::class, 'contactSubmit'])->name('contact.submit');

// Admin CMS Auth
Route::get('/admin/login', [AdminController::class, 'loginForm'])->name('login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Admin CMS Dashboard (Protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/parameters', [AdminController::class, 'updateParameters'])->name('admin.parameters.update');
    
    Route::post('/admin/slides', [AdminController::class, 'storeSlide'])->name('admin.slides.store');
    Route::post('/admin/slides/{id}/update', [AdminController::class, 'updateSlide'])->name('admin.slides.update');
    Route::post('/admin/slides/{id}/delete', [AdminController::class, 'deleteSlide'])->name('admin.slides.delete');
    
    Route::post('/admin/testimonials', [AdminController::class, 'storeTestimonial'])->name('admin.testimonials.store');
    Route::post('/admin/testimonials/{id}/update', [AdminController::class, 'updateTestimonial'])->name('admin.testimonials.update');
    Route::post('/admin/testimonials/{id}/delete', [AdminController::class, 'deleteTestimonial'])->name('admin.testimonials.delete');

    // Blogs CRUD
    Route::post('/admin/blogs', [AdminController::class, 'storeBlog'])->name('admin.blogs.store');
    Route::post('/admin/blogs/{id}/update', [AdminController::class, 'updateBlog'])->name('admin.blogs.update');
    Route::post('/admin/blogs/{id}/delete', [AdminController::class, 'deleteBlog'])->name('admin.blogs.delete');

    // Services CRUD
    Route::post('/admin/services', [AdminController::class, 'storeService'])->name('admin.services.store');
    Route::post('/admin/services/{id}/update', [AdminController::class, 'updateService'])->name('admin.services.update');
    Route::post('/admin/services/{id}/delete', [AdminController::class, 'deleteService'])->name('admin.services.delete');

    // Banks CRUD
    Route::post('/admin/banks', [AdminController::class, 'storeBank'])->name('admin.banks.store');
    Route::post('/admin/banks/{id}/update', [AdminController::class, 'updateBank'])->name('admin.banks.update');
    Route::post('/admin/banks/{id}/delete', [AdminController::class, 'deleteBank'])->name('admin.banks.delete');

    // Page Content Update
    Route::post('/admin/page-contents', [AdminController::class, 'updatePageContents'])->name('admin.page-contents.update');

    // Media Manager Upload
    Route::post('/admin/media-upload', [AdminController::class, 'uploadMedia'])->name('admin.media.upload');

    // Sync database content
    Route::post('/admin/sync-database', [AdminController::class, 'syncDatabase'])->name('admin.sync-database');

    // Leads Management
    Route::post('/admin/leads/{id}/update', [AdminController::class, 'updateLead'])->name('admin.leads.update');
    Route::post('/admin/leads/{id}/delete', [AdminController::class, 'deleteLead'])->name('admin.leads.delete');

    // AI Content Generation
    Route::post('/admin/ai/generate-blog', [AdminController::class, 'aiGenerateBlog'])->name('admin.ai.blog');
    Route::post('/admin/ai/generate-service', [AdminController::class, 'aiGenerateService'])->name('admin.ai.service');
    Route::post('/admin/ai/generate-image', [AdminController::class, 'aiGenerateImage'])->name('admin.ai.image');

    // Cloudflare Analytics
    Route::post('/admin/cloudflare/analytics', [AdminController::class, 'getCloudflareAnalytics'])->name('admin.cloudflare.analytics');
});
