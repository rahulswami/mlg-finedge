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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('service_name');
            $table->string('hero_category')->nullable();
            $table->string('hero_title');
            $table->string('hero_subtitle')->nullable();
            $table->string('rate_value')->nullable();
            $table->string('max_loan')->nullable();
            $table->string('tenure')->nullable();
            $table->string('intro_title')->nullable();
            $table->longText('intro_content')->nullable();
            $table->text('eligibility_criteria')->nullable();
            $table->text('documents_required')->nullable();
            $table->string('tips_title')->nullable();
            $table->longText('tips_content')->nullable();
            $table->longText('faqs')->nullable();
            $table->string('badge')->nullable();
            $table->text('summary')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
