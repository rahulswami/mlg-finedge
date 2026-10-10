<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('page_seos')) {
            Schema::create('page_seos', function (Blueprint $table) {
                $table->id();
                $table->string('page_key')->unique();
                $table->string('page_name');
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->text('meta_keywords')->nullable();
                $table->string('canonical_url')->nullable();
                $table->string('meta_robots')->default('index, follow');
                $table->string('og_title')->nullable();
                $table->text('og_description')->nullable();
                $table->string('og_image')->nullable();
                $table->string('og_type')->default('website');
                $table->string('twitter_card')->default('summary_large_image');
                $table->string('twitter_title')->nullable();
                $table->text('twitter_description')->nullable();
                $table->string('twitter_image')->nullable();
                $table->string('h1_tag')->nullable();
                $table->string('hero_image_alt')->nullable();
                $table->longText('schema_markup')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (Schema::hasTable('services')) {
            Schema::table('services', function (Blueprint $table) {
                if (!Schema::hasColumn('services', 'meta_title')) {
                    $table->string('meta_title')->nullable();
                }
                if (!Schema::hasColumn('services', 'meta_description')) {
                    $table->text('meta_description')->nullable();
                }
                if (!Schema::hasColumn('services', 'meta_keywords')) {
                    $table->text('meta_keywords')->nullable();
                }
                if (!Schema::hasColumn('services', 'canonical_url')) {
                    $table->string('canonical_url')->nullable();
                }
                if (!Schema::hasColumn('services', 'meta_robots')) {
                    $table->string('meta_robots')->default('index, follow');
                }
                if (!Schema::hasColumn('services', 'og_image')) {
                    $table->string('og_image')->nullable();
                }
                if (!Schema::hasColumn('services', 'h1_tag')) {
                    $table->string('h1_tag')->nullable();
                }
                if (!Schema::hasColumn('services', 'image_alt')) {
                    $table->string('image_alt')->nullable();
                }
            });
        }

        if (Schema::hasTable('blogs')) {
            Schema::table('blogs', function (Blueprint $table) {
                if (!Schema::hasColumn('blogs', 'meta_title')) {
                    $table->string('meta_title')->nullable();
                }
                if (!Schema::hasColumn('blogs', 'meta_description')) {
                    $table->text('meta_description')->nullable();
                }
                if (!Schema::hasColumn('blogs', 'meta_keywords')) {
                    $table->text('meta_keywords')->nullable();
                }
                if (!Schema::hasColumn('blogs', 'canonical_url')) {
                    $table->string('canonical_url')->nullable();
                }
                if (!Schema::hasColumn('blogs', 'meta_robots')) {
                    $table->string('meta_robots')->default('index, follow');
                }
                if (!Schema::hasColumn('blogs', 'og_image')) {
                    $table->string('og_image')->nullable();
                }
                if (!Schema::hasColumn('blogs', 'h1_tag')) {
                    $table->string('h1_tag')->nullable();
                }
                if (!Schema::hasColumn('blogs', 'image_alt')) {
                    $table->string('image_alt')->nullable();
                }
            });
        }

        if (Schema::hasTable('landing_pages')) {
            Schema::table('landing_pages', function (Blueprint $table) {
                if (!Schema::hasColumn('landing_pages', 'meta_title')) {
                    $table->string('meta_title')->nullable();
                }
                if (!Schema::hasColumn('landing_pages', 'meta_keywords')) {
                    $table->text('meta_keywords')->nullable();
                }
                if (!Schema::hasColumn('landing_pages', 'canonical_url')) {
                    $table->string('canonical_url')->nullable();
                }
                if (!Schema::hasColumn('landing_pages', 'meta_robots')) {
                    $table->string('meta_robots')->default('index, follow');
                }
                if (!Schema::hasColumn('landing_pages', 'og_image')) {
                    $table->string('og_image')->nullable();
                }
                if (!Schema::hasColumn('landing_pages', 'h1_tag')) {
                    $table->string('h1_tag')->nullable();
                }
                if (!Schema::hasColumn('landing_pages', 'image_alt')) {
                    $table->string('image_alt')->nullable();
                }
            });
        }

        if (Schema::hasTable('home_slides')) {
            Schema::table('home_slides', function (Blueprint $table) {
                if (!Schema::hasColumn('home_slides', 'alt_text')) {
                    $table->string('alt_text')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_seos');

        if (Schema::hasTable('services')) {
            Schema::table('services', function (Blueprint $table) {
                $columns = ['meta_title', 'meta_description', 'meta_keywords', 'canonical_url', 'meta_robots', 'og_image', 'h1_tag', 'image_alt'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('services', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('blogs')) {
            Schema::table('blogs', function (Blueprint $table) {
                $columns = ['meta_title', 'meta_description', 'meta_keywords', 'canonical_url', 'meta_robots', 'og_image', 'h1_tag', 'image_alt'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('blogs', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('landing_pages')) {
            Schema::table('landing_pages', function (Blueprint $table) {
                $columns = ['meta_title', 'meta_keywords', 'canonical_url', 'meta_robots', 'og_image', 'h1_tag', 'image_alt'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('landing_pages', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('home_slides') && Schema::hasColumn('home_slides', 'alt_text')) {
            Schema::table('home_slides', function (Blueprint $table) {
                $table->dropColumn('alt_text');
            });
        }
    }
};
