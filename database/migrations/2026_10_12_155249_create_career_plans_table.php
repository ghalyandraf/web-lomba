<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('career_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('target_career'); // Contoh: Web Developer, Data Scientist
            $table->string('education_path'); // Contoh: S1 Informatika
            $table->text('short_term_goals'); // Target jangka pendek
            $table->text('medium_term_goals'); // Target jangka menengah
            $table->text('long_term_goals'); // Target jangka panjang
            $table->integer('progress_percentage')->default(0); // Progress pencapaian
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_plans');
    }
};