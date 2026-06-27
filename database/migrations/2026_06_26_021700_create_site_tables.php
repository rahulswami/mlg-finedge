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
        Schema::create('site_parameters', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->text('value')->nullable();
            $table->string('label');
            $table->string('category');
            $table->timestamps();
        });

        Schema::create('home_slides', function (Blueprint $table) {
            $table->id();
            $table->string('image_path')->nullable();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role')->nullable();
            $table->text('content');
            $table->integer('rating');
            $table->string('avatar_path')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('page_contents', function (Blueprint $table) {
            $table->string('page');
            $table->string('section');
            $table->string('key');
            $table->text('value')->nullable();
            $table->primary(['page', 'section', 'key']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_contents');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('home_slides');
        Schema::dropIfExists('site_parameters');
    }
};
