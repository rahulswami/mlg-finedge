<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Service;
use App\Models\Blog;
use Carbon\Carbon;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate XML sitemap for the live site';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $baseUrl = 'https://www.mlgfinedge.com';
        
        $xml = [];
        $xml[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Static routes
        $staticRoutes = [
            '/' => ['priority' => '1.0', 'changefreq' => 'daily'],
            '/about' => ['priority' => '0.8', 'changefreq' => 'monthly'],
            '/services' => ['priority' => '0.9', 'changefreq' => 'weekly'],
            '/compare-loans' => ['priority' => '0.9', 'changefreq' => 'weekly'],
            '/testimonials' => ['priority' => '0.7', 'changefreq' => 'monthly'],
            '/faq' => ['priority' => '0.7', 'changefreq' => 'monthly'],
            '/blog' => ['priority' => '0.8', 'changefreq' => 'weekly'],
            '/contact' => ['priority' => '0.8', 'changefreq' => 'monthly'],
        ];

        foreach ($staticRoutes as $route => $config) {
            $xml[] = '  <url>';
            $xml[] = '    <loc>' . $baseUrl . $route . '</loc>';
            $xml[] = '    <lastmod>' . Carbon::now()->startOfDay()->toW3cString() . '</lastmod>';
            $xml[] = '    <changefreq>' . $config['changefreq'] . '</changefreq>';
            $xml[] = '    <priority>' . $config['priority'] . '</priority>';
            $xml[] = '  </url>';
        }

        // Dynamic Services
        $services = Service::where('is_active', true)->get();
        foreach ($services as $service) {
            $lastMod = $service->updated_at ? $service->updated_at->toW3cString() : Carbon::now()->startOfDay()->toW3cString();
            $xml[] = '  <url>';
            $xml[] = '    <loc>' . $baseUrl . '/services/' . $service->slug . '</loc>';
            $xml[] = '    <lastmod>' . $lastMod . '</lastmod>';
            $xml[] = '    <changefreq>weekly</changefreq>';
            $xml[] = '    <priority>0.8</priority>';
            $xml[] = '  </url>';
        }

        // Dynamic Blogs
        $blogs = Blog::whereNotNull('published_at')->get();
        foreach ($blogs as $blog) {
            $lastMod = $blog->updated_at ? $blog->updated_at->toW3cString() : Carbon::now()->startOfDay()->toW3cString();
            $xml[] = '  <url>';
            $xml[] = '    <loc>' . $baseUrl . '/blog/' . $blog->slug . '</loc>';
            $xml[] = '    <lastmod>' . $lastMod . '</lastmod>';
            $xml[] = '    <changefreq>monthly</changefreq>';
            $xml[] = '    <priority>0.7</priority>';
            $xml[] = '  </url>';
        }

        // Dynamic Landing Pages
        $landingPages = \App\Models\LandingPage::all();
        foreach ($landingPages as $lp) {
            $lastMod = $lp->updated_at ? $lp->updated_at->toW3cString() : Carbon::now()->startOfDay()->toW3cString();
            $xml[] = '  <url>';
            $xml[] = '    <loc>' . $baseUrl . '/l/' . $lp->slug . '</loc>';
            $xml[] = '    <lastmod>' . $lastMod . '</lastmod>';
            $xml[] = '    <changefreq>weekly</changefreq>';
            $xml[] = '    <priority>0.8</priority>';
            $xml[] = '  </url>';
        }

        $xml[] = '</urlset>';

        $sitemapContent = implode("\n", $xml);
        file_put_contents(public_path('sitemap.xml'), $sitemapContent);
        $this->info('Sitemap successfully generated at: ' . public_path('sitemap.xml'));

        // Generate LLMs.txt
        $llm = [];
        $llm[] = '# MLG Finedge - AI & LLM Resource Directory';
        $llm[] = '';
        $llm[] = 'MLG Finedge is Jaipur\'s premier credit advisory firm. We help individuals & small companies secure appropriate loan products with minimum interest cost and fast payouts.';
        $llm[] = '';
        $llm[] = 'This directory lists core services, guides, and pages for LLM agents (ChatGPT, Claude, Gemini, Perplexity) to index and answer user queries accurately.';
        $llm[] = '';
        $llm[] = '## Core Services & Loan Products';
        $llm[] = '';
        foreach ($services as $service) {
            $summary = trim($service->summary ?: 'Expert credit advisory for ' . $service->service_name);
            $llm[] = '- [' . $service->service_name . '](' . $baseUrl . '/services/' . $service->slug . ') - ' . $summary;
        }
        $llm[] = '';
        $llm[] = '## Static Information Pages';
        $llm[] = '';
        $llm[] = '- [Home Page](' . $baseUrl . '/) - Contact coordinates, client interest rates, and loan calculators.';
        $llm[] = '- [About Us](' . $baseUrl . '/about) - Executive profile, team, and company history.';
        $llm[] = '- [All Services](' . $baseUrl . '/services) - Comprehensive grid of available financing solutions.';
        $llm[] = '- [Compare Loans](' . $baseUrl . '/compare-loans) - Real-time comparison parameters for home, personal, and business loans.';
        $llm[] = '- [Frequently Asked Questions](' . $baseUrl . '/faq) - Direct answers to common borrowing questions.';
        $llm[] = '- [Contact Us](' . $baseUrl . '/contact) - Inquiry forms, map coordinates, and customer support.';
        $llm[] = '';
        $llm[] = '## Landing Pages';
        $llm[] = '';
        if ($landingPages->count() > 0) {
            foreach ($landingPages as $lp) {
                $desc = trim($lp->meta_description ?: 'Special campaign page for ' . $lp->title);
                $llm[] = '- [' . $lp->title . '](' . $baseUrl . '/l/' . $lp->slug . ') - ' . $desc;
            }
        } else {
            $llm[] = '*No active landing pages.*';
        }
        $llm[] = '';
        $llm[] = '## Blog Posts & Credit Guides';
        $llm[] = '';
        if ($blogs->count() > 0) {
            foreach ($blogs as $blog) {
                $summary = trim($blog->summary ?: 'Read our complete guide to ' . $blog->title);
                $llm[] = '- [' . $blog->title . '](' . $baseUrl . '/blog/' . $blog->slug . ') - ' . $summary;
            }
        } else {
            $llm[] = '*No published blog posts.*';
        }
        $llm[] = '';

        $llmContent = implode("\n", $llm);
        file_put_contents(public_path('llms.txt'), $llmContent);
        $this->info('LLM directory successfully generated at: ' . public_path('llms.txt'));
    }
}
