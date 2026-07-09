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
        if (Schema::hasTable('services') && !Schema::hasColumn('services', 'schema_markup')) {
            Schema::table('services', function (Blueprint $table) {
                $table->text('schema_markup')->nullable();
            });
        }
        if (Schema::hasTable('blogs') && !Schema::hasColumn('blogs', 'schema_markup')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->text('schema_markup')->nullable();
            });
        }
        if (Schema::hasTable('landing_pages') && !Schema::hasColumn('landing_pages', 'schema_markup')) {
            Schema::table('landing_pages', function (Blueprint $table) {
                $table->text('schema_markup')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('services') && Schema::hasColumn('services', 'schema_markup')) {
            Schema::table('services', function (Blueprint $table) {
                $table->dropColumn('schema_markup');
            });
        }
        if (Schema::hasTable('blogs') && Schema::hasColumn('blogs', 'schema_markup')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->dropColumn('schema_markup');
            });
        }
        if (Schema::hasTable('landing_pages') && Schema::hasColumn('landing_pages', 'schema_markup')) {
            Schema::table('landing_pages', function (Blueprint $table) {
                $table->dropColumn('schema_markup');
            });
        }
    }
};
