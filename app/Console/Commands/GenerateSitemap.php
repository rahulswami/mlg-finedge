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

        $xml[] = '</urlset>';

        $sitemapContent = implode("\n", $xml);
        file_put_contents(public_path('sitemap.xml'), $sitemapContent);

        $this->info('Sitemap successfully generated at: ' . public_path('sitemap.xml'));
    }
}
