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
        Schema::create('comparison_banks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('home_rate', 8, 2);
            $table->double('personal_rate', 8, 2);
            $table->double('business_rate', 8, 2);
            $table->double('fee_percent', 8, 2);
            $table->string('sector');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comparison_banks');
    }
};
