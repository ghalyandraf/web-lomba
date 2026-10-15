<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Menambah kolom tag minat pada jurusan (atribut minat_tags di makalah).
 * Contoh isi: ["logika","problem_solving","teknologi"]
 *
 * Setelah migrasi, tambahkan di model App\Models\Major:
 *     protected $casts = ['interest_tags' => 'array', ...];
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('majors', function (Blueprint $table) {
            if (! Schema::hasColumn('majors', 'interest_tags')) {
                $table->json('interest_tags')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('majors', function (Blueprint $table) {
            if (Schema::hasColumn('majors', 'interest_tags')) {
                $table->dropColumn('interest_tags');
            }
        });
    }
};