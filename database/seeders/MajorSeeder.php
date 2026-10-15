<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MajorSeeder extends Seeder
{
    public function run(): void
    {
        $majors = [
            ['Informatika', 'Teknologi', 'Pemrograman, data, dan pemecahan masalah', ['Logika', 'Matematika', 'Kreativitas']],
            ['Sistem Informasi', 'Teknologi & Bisnis', 'Menghubungkan teknologi dengan kebutuhan bisnis', ['Analisis', 'Komunikasi', 'Teknologi']],
            ['Desain Komunikasi Visual', 'Kreatif', 'Komunikasi melalui visual dan desain', ['Kreativitas', 'Visual', 'Storytelling']],
            ['Manajemen', 'Bisnis', 'Mengelola organisasi, sumber daya, dan strategi', ['Kepemimpinan', 'Analisis', 'Komunikasi']],
            ['Akuntansi', 'Bisnis', 'Mencatat, menganalisis, dan melaporkan keuangan', ['Ketelitian', 'Matematika', 'Etika']],
            ['Bisnis Digital', 'Bisnis & Digital', 'Membangun usaha berbasis teknologi digital', ['Kreativitas', 'Analisis', 'Teknologi']],
            ['Kedokteran', 'Kesehatan', 'Mendiagnosis dan menangani kesehatan manusia', ['Ketelitian', 'Empati', 'Biologi']],
            ['Keperawatan', 'Kesehatan', 'Merawat dan mendampingi pasien secara langsung', ['Empati', 'Komunikasi', 'Ketelitian']],
            ['Gizi', 'Kesehatan', 'Mengelola pola makan untuk hidup lebih sehat', ['Biologi', 'Analisis', 'Edukasi']],
            ['Arsitektur', 'Kreatif', 'Merancang ruang dan bangunan yang fungsional', ['Kreativitas', 'Matematika', 'Visual']],
        ];

        foreach ($majors as [$name, $field, $desc, $skills]) {
            Major::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'field' => $field,
                    'description' => $desc,
                    'min_scores' => [],
                    'required_skills' => $skills,
                ]
            );
        }
    }
}