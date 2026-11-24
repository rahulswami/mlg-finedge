<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use App\Models\PageSeo;
use App\Models\PageContent;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('page_seos')) {
            PageSeo::updateOrCreate(
                ['page_key' => 'privacy_policy'],
                [
                    'page_name' => 'Privacy Policy',
                    'meta_title' => 'Privacy Policy | MLG FinEdge',
                    'meta_description' => 'Read the Privacy Policy of MLG FinEdge. Learn how we collect, use, process and protect your personal and financial information when using our loan advisory services.',
                    'meta_keywords' => 'privacy policy, mlg finedge privacy, data protection, loan advisory jaipur privacy',
                    'canonical_url' => 'https://www.mlgfinedge.com/privacy-policy',
                    'meta_robots' => 'index, follow',
                    'h1_tag' => 'Privacy Policy',
                    'og_title' => 'Privacy Policy | MLG FinEdge',
                    'og_description' => 'Read the Privacy Policy of MLG FinEdge. Learn how we protect your personal and financial information.',
                    'og_type' => 'website',
                    'twitter_card' => 'summary_large_image',
                    'is_active' => true,
                ]
            );
        }

        if (Schema::hasTable('page_contents')) {
            PageContent::updateOrCreate(
                ['page' => 'privacy_policy', 'section' => 'hero', 'key' => 'title'],
                ['value' => 'Privacy Policy']
            );
            PageContent::updateOrCreate(
                ['page' => 'privacy_policy', 'section' => 'hero', 'key' => 'subtitle'],
                ['value' => 'Our commitment to protecting your personal and financial information with transparency, security, and integrity.']
            );
            PageContent::updateOrCreate(
                ['page' => 'privacy_policy', 'section' => 'meta', 'key' => 'last_updated'],
                ['value' => 'November 24, 2026']
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('page_seos')) {
            PageSeo::where('page_key', 'privacy_policy')->delete();
        }

        if (Schema::hasTable('page_contents')) {
            PageContent::where('page', 'privacy_policy')->delete();
        }
    }
};
