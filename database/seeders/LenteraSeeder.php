<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Major;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LenteraSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Demo Siswa
        $demoUser = User::firstOrCreate(
            ['email' => 'siswa@lentera.test'],
            [
                'name' => 'Bintang Pelajar',
                'password' => Hash::make('password123')
            ]
        );

        // 2. Data Jurusan (Majors)
        $majors = [
            [
                'name' => 'Informatika',
                'description' => 'Mempelajari pengembangan perangkat lunak, algoritma, kecerdasan buatan, dan sistem jaringan komputer.',
                'min_scores' => [
                    'Matematika' => 80,
                    'Bahasa Inggris' => 75,
                    'Fisika' => 75
                ],
                'required_skills' => ['Pemrograman Dasar', 'Logika Pemecahan Masalah', 'Analisis Data']
            ],
            [
                'name' => 'Kedokteran',
                'description' => 'Mempelajari ilmu kesehatan manusia, diagnosis penyakit, farmakologi, dan penanganan klinis.',
                'min_scores' => [
                    'Biologi' => 85,
                    'Kimia' => 85,
                    'Matematika' => 80
                ],
                'required_skills' => ['Biologi Sel', 'Hafalan Medis', 'Empati & Komunikasi']
            ],
            [
                'name' => 'Manajemen Bisnis',
                'description' => 'Mempelajari pengelolaan operasional perusahaan, strategi pemasaran, keuangan, dan kewirausahaan.',
                'min_scores' => [
                    'Matematika' => 75,
                    'Bahasa Inggris' => 80,
                    'Ekonomi' => 80
                ],
                'required_skills' => ['Kepemimpinan', 'Manajemen Keuangan', 'Public Speaking']
            ]
        ];

        foreach ($majors as $major) {
            Major::firstOrCreate(['name' => $major['name']], $major);
        }
    }
}