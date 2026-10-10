<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\HomeSlide;
use App\Models\LandingPage;
use App\Models\PageSeo;
use App\Models\Service;
use App\Models\SiteParameter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SeoManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'email' => 'admin@mlgfinedge.com',
            'password' => bcrypt('password'),
        ]);

        // Seed default site parameters
        SiteParameter::updateOrCreate(['id' => 'seo_title_suffix'], ['label' => 'Title Suffix', 'category' => 'SEO', 'value' => ' | MLG Finedge Jaipur']);
        SiteParameter::updateOrCreate(['id' => 'seo_default_description'], ['label' => 'Default Description', 'category' => 'SEO', 'value' => 'MLG Finedge Default Description']);
        SiteParameter::updateOrCreate(['id' => 'seo_default_robots'], ['label' => 'Robots', 'category' => 'SEO', 'value' => 'index, follow']);
        SiteParameter::updateOrCreate(['id' => 'seo_twitter_handle'], ['label' => 'Twitter Handle', 'category' => 'SEO', 'value' => '@mlgfinedge']);
        SiteParameter::updateOrCreate(['id' => 'seo_google_verification'], ['label' => 'Google Verification', 'category' => 'SEO', 'value' => 'google-test-token-123']);
        SiteParameter::updateOrCreate(['id' => 'seo_global_schema'], ['label' => 'Global Schema', 'category' => 'SEO', 'value' => '<script type="application/ld+json">{"@context":"https://schema.org","@type":"Organization","name":"MLG Finedge"}</script>']);

        // Seed Home Page SEO
        PageSeo::updateOrCreate(
            ['page_key' => 'home'],
            [
                'page_name' => 'Home Page',
                'meta_title' => 'Best Loan Provider in Jaipur | MLG Finedge',
                'meta_description' => 'Fastest loan approvals in Jaipur.',
                'meta_keywords' => 'loan jaipur, best advisor',
                'h1_tag' => 'Premier Loan Consultancy In Jaipur',
                'hero_image_alt' => 'MLG Finedge Home Hero Banner',
                'canonical_url' => 'https://mlgfinedge.com',
                'meta_robots' => 'index, follow',
                'schema_markup' => '<script type="application/ld+json">{"@context":"https://schema.org","@type":"FinancialService","name":"MLG Finedge"}</script>',
            ]
        );

        \Illuminate\Support\Facades\View::share('site', SiteParameter::all()->pluck('value', 'id')->toArray());
        \Illuminate\Support\Facades\View::share('pageSeos', PageSeo::all()->keyBy('page_key'));
    }

    public function test_admin_dashboard_renders_cleanly(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('SEO Optimizer');
        $response->assertSee('Loan Services SEO Optimizer');
    }

    public function test_public_homepage_renders_dynamic_seo_h1_and_schema(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Assert Title, Meta Description, Verification, OG Tags & JSON-LD Schema
        $response->assertSee('Best Loan Provider in Jaipur | MLG Finedge', false);
        $response->assertSee('Fastest loan approvals in Jaipur.', false);
        $response->assertSee('google-test-token-123', false);
        $response->assertSee('twitter:site', false);
        $response->assertSee('Premier Loan Consultancy In Jaipur', false);
        $response->assertSee('"@type":"FinancialService"', false);
    }

    public function test_admin_can_update_global_seo_settings(): void
    {
        $response = $this->actingAs($this->adminUser)->post(route('admin.seo.global.update'), [
            'seo_title_suffix' => ' | Top Loan Consultant',
            'seo_default_description' => 'Updated Global Meta Description',
            'seo_default_keywords' => 'loans, credit, jaipur',
            'seo_twitter_handle' => '@mlgnew',
            'seo_default_robots' => 'index, follow',
            'seo_google_verification' => 'g-verify-999',
            'seo_bing_verification' => 'b-verify-888',
            'seo_global_schema' => '<script type="application/ld+json">{"@type":"LocalBusiness","name":"MLG Finedge"}</script>',
        ]);

        $response->assertRedirect();
        $this->assertEquals('| Top Loan Consultant', SiteParameter::where('id', 'seo_title_suffix')->value('value'));
        $this->assertEquals('g-verify-999', SiteParameter::where('id', 'seo_google_verification')->value('value'));
    }

    public function test_admin_can_update_page_seo_and_h1(): void
    {
        $response = $this->actingAs($this->adminUser)->post(route('admin.seo.page.update', 'home'), [
            'meta_title' => 'Custom Updated Title',
            'meta_description' => 'Custom Updated Description for Google SERP',
            'meta_keywords' => 'keyword1, keyword2',
            'h1_tag' => 'Custom Main Heading For Home',
            'image_alt' => 'Custom Home Hero Alt Text',
            'canonical_url' => 'https://mlgfinedge.com/home',
            'meta_robots' => 'index, follow',
            'schema_markup' => '<script type="application/ld+json">{"@context":"https://schema.org","@type":"WebSite"}</script>',
        ]);

        $response->assertRedirect();

        $page = PageSeo::where('page_key', 'home')->first();
        $this->assertEquals('Custom Updated Title', $page->meta_title);
        $this->assertEquals('Custom Main Heading For Home', $page->h1_tag);
        $this->assertEquals('Custom Home Hero Alt Text', $page->image_alt);
    }

    public function test_admin_can_update_service_seo_and_h1(): void
    {
        $service = Service::create([
            'service_name' => 'Home Loan Test',
            'slug' => 'home-loan-test',
            'icon' => 'home',
            'badge' => 'Lowest Rates',
            'hero_title' => 'Default Home Loan Hero',
            'hero_subtitle' => 'Affordable rates for your dream home',
            'rate_value' => '8.5%',
            'max_loan' => '5 Cr',
            'tenure' => '30 Years',
            'summary' => 'Service summary',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->adminUser)->post(route('admin.seo.service.update', $service->id), [
            'meta_title' => 'Best Home Loan In Jaipur | Low Rates',
            'meta_description' => 'Apply for easy home loans with instant approval.',
            'meta_keywords' => 'home loan jaipur, low roi',
            'h1_tag' => 'Instant Approval Home Loans In Jaipur',
            'image_alt' => 'Home Loan Advice Image Alt',
            'canonical_url' => 'https://mlgfinedge.com/services/home-loan-test',
            'meta_robots' => 'index, follow',
            'schema_markup' => '<script type="application/ld+json">{"@type":"FinancialProduct","name":"Home Loan Test"}</script>',
        ]);

        $response->assertRedirect();

        $service->refresh();
        $this->assertEquals('Best Home Loan In Jaipur | Low Rates', $service->meta_title);
        $this->assertEquals('Instant Approval Home Loans In Jaipur', $service->h1_tag);
        $this->assertEquals('Home Loan Advice Image Alt', $service->image_alt);

        // Check public service page view
        $viewResponse = $this->get(route('services.show', $service->slug));
        $viewResponse->assertStatus(200);
        $viewResponse->assertSee('Instant Approval Home Loans In Jaipur');
        $viewResponse->assertSee('Best Home Loan In Jaipur | Low Rates');
    }

    public function test_admin_can_update_blog_seo_and_h1(): void
    {
        $blog = Blog::create([
            'title' => '5 Tips to Improve Credit Score',
            'slug' => '5-tips-to-improve-credit-score',
            'category' => 'CIBIL & Credit',
            'summary' => 'Learn how to boost credit score.',
            'content' => '<p>Article content details here.</p>',
            'published_at' => now(),
        ]);

        $response = $this->actingAs($this->adminUser)->post(route('admin.seo.blog.update', $blog->id), [
            'meta_title' => 'Proven 5 Tips to Boost Credit Score Fast | MLG Finedge',
            'meta_description' => 'Step by step guide to reach 750+ CIBIL score.',
            'meta_keywords' => 'cibil score, credit tips',
            'h1_tag' => 'Master Your Credit Score: 5 Proven Strategies',
            'image_alt' => 'CIBIL Improvement Infographic',
            'canonical_url' => 'https://mlgfinedge.com/blog/5-tips-to-improve-credit-score',
            'meta_robots' => 'index, follow',
            'schema_markup' => '<script type="application/ld+json">{"@type":"BlogPosting","headline":"Credit Tips"}</script>',
        ]);

        $response->assertRedirect();

        $blog->refresh();
        $this->assertEquals('Proven 5 Tips to Boost Credit Score Fast | MLG Finedge', $blog->meta_title);
        $this->assertEquals('Master Your Credit Score: 5 Proven Strategies', $blog->h1_tag);
        $this->assertEquals('CIBIL Improvement Infographic', $blog->image_alt);

        // Check public blog view
        $viewResponse = $this->get(route('blog.show', $blog->slug));
        $viewResponse->assertStatus(200);
        $viewResponse->assertSee('Master Your Credit Score: 5 Proven Strategies');
        $viewResponse->assertSee('Proven 5 Tips to Boost Credit Score Fast | MLG Finedge');
    }

    public function test_admin_can_update_batch_image_alts(): void
    {
        $slide = HomeSlide::create([
            'title' => 'Slide 1 Title',
            'subtitle' => 'Slide 1 Subtitle',
            'cta_text' => 'Apply',
            'cta_url' => '/contact',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $service = Service::create([
            'service_name' => 'Business Loan Test',
            'slug' => 'business-loan-test',
            'icon' => 'briefcase',
            'badge' => 'Collateral-free',
            'hero_title' => 'Business Loan',
            'rate_value' => '11%',
            'max_loan' => '1 Cr',
            'tenure' => '5 Years',
            'summary' => 'Business growth capital',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->adminUser)->post(route('admin.seo.alts.update'), [
            'seo_logo_alt' => 'MLG Finedge Premier Logo Alt',
            'seo_about_img_alt' => 'MLG Finedge Award Winning Team',
            'slides' => [
                $slide->id => 'Hero Slider 1 Custom Alt Description',
            ],
            'services' => [
                $service->id => 'Business Loan Collateral-Free Solutions',
            ],
        ]);

        $response->assertRedirect();

        $slide->refresh();
        $service->refresh();

        $this->assertEquals('Hero Slider 1 Custom Alt Description', $slide->alt_text);
        $this->assertEquals('Business Loan Collateral-Free Solutions', $service->image_alt);
        $this->assertEquals('MLG Finedge Premier Logo Alt', SiteParameter::where('id', 'seo_logo_alt')->value('value'));
    }
}
