<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Seeder;

/**
 * Mengisi min_scores & interest_tags untuk 20 program studi pada Tabel 1 makalah.
 *
 * - Jurusan yang sudah ada (cocok nama / alias) hanya diperbarui min_scores dan interest_tags-nya.
 * - Jurusan yang belum ada dibuat baru.
 *
 * PENTING: Tabel 1 pada PDF hasil salin teksnya tidak menyimpan posisi kolom, sehingga nilai
 * minimum per mapel hanya bisa dipastikan untuk prodi yang muncul di contoh hitungan makalah.
 * Prodi bertanda "CEK" dibiarkan kosong (= tidak ada syarat mapel). Isi dari Tabel 1 aslinya.
 * Kunci min_scores memakai nama mapel yang sama dengan form nilai rapor:
 * Matematika, Biologi, Ekonomi, Fisika, Kimia.
 *
 * Jalankan: php artisan db:seed --class=MajorKnowledgeSeeder
 */
class MajorKnowledgeSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->programs() as $p) {
            $major = Major::where('name', $p['name'])
                ->when(isset($p['alias']), fn ($q) => $q->orWhere('name', $p['alias']))
                ->first() ?? new Major();

            $attrs = [
                'min_scores'    => $p['min'],
                'interest_tags' => $p['tags'],
            ];

            if (! $major->exists) {
                $attrs += [
                    'name'            => $p['name'],
                    'field'           => $p['field'],
                    'description'     => $p['desc'],
                    'required_skills' => array_map(
                        fn ($t) => ucfirst(str_replace('_', ' ', $t)),
                        $p['tags']
                    ),
                ];
            }

            foreach ($attrs as $key => $value) {
                // Jika kolom belum di-cast 'array' di model, simpan sebagai JSON
                $major->{$key} = (is_array($value) && ! $major->hasCast($key)) ? json_encode($value) : $value;
            }

            $major->save();
        }
    }

    private function programs(): array
    {
        return [
            ['name' => 'Teknik Informatika', 'alias' => 'Informatika', 'field' => 'Teknologi',
             'desc' => 'Pemrograman, data, dan pemecahan masalah.',
             'min' => ['Matematika' => 88],
             'tags' => ['logika', 'problem_solving', 'inovasi', 'teknologi', 'pemrograman']],

            ['name' => 'Kedokteran', 'field' => 'Kesehatan',
             'desc' => 'Mendiagnosis dan menangani kesehatan manusia.',
             'min' => ['Biologi' => 90],
             'tags' => ['riset', 'kesehatan', 'pelayanan', 'biologi', 'humaniora']],

            ['name' => 'Akuntansi', 'field' => 'Bisnis',
             'desc' => 'Mencatat, menganalisis, dan melaporkan keuangan.',
             'min' => ['Ekonomi' => 80],
             'tags' => ['detail', 'analitis', 'keuangan', 'bisnis']],

            ['name' => 'Arsitektur', 'field' => 'Seni',
             'desc' => 'Merancang ruang dan bangunan yang fungsional.',
             'min' => [], // CEK: PDF menulis 85, kolom mapel tidak terbaca
             'tags' => ['kreatif', 'desain', 'seni', 'teknik']],

            ['name' => 'Psikologi', 'field' => 'Sosial',
             'desc' => 'Mempelajari perilaku dan proses mental manusia.',
             'min' => ['Fisika' => 85], // sesuai contoh hitungan makalah
             'tags' => ['sosial', 'empati', 'analitis', 'riset']],

            ['name' => 'Manajemen', 'field' => 'Bisnis',
             'desc' => 'Mengelola organisasi, sumber daya, dan strategi.',
             'min' => [], // CEK: PDF menulis 82, kolom mapel tidak terbaca
             'tags' => ['kepemimpinan', 'strategi', 'bisnis', 'komunikasi']],

            ['name' => 'Desain Komunikasi Visual', 'field' => 'Seni',
             'desc' => 'Komunikasi melalui visual dan desain.',
             'min' => [],
             'tags' => ['kreatif', 'seni', 'desain', 'visual']],

            ['name' => 'Ilmu Komunikasi', 'field' => 'Sosial',
             'desc' => 'Mempelajari komunikasi, media, dan jurnalistik.',
             'min' => [], // CEK: PDF menulis 80, kolom mapel tidak terbaca
             'tags' => ['komunikasi', 'sosial', 'kreatif', 'jurnalistik']],

            ['name' => 'Agroteknologi', 'field' => 'Pertanian',
             'desc' => 'Teknologi budidaya tanaman dan pengelolaan lahan.',
             'min' => [], // CEK: PDF menulis 78 dan 78, kolom mapel tidak terbaca
             'tags' => ['lingkungan', 'pertanian', 'riset', 'biologi']],

            ['name' => 'Sistem Informasi', 'field' => 'Teknologi',
             'desc' => 'Menghubungkan teknologi dengan kebutuhan bisnis.',
             'min' => ['Matematika' => 86], // sesuai Tabel 1 dan Tabel 2
             'tags' => ['logika', 'bisnis', 'teknologi', 'manajemen']],

            ['name' => 'Hukum', 'field' => 'Sosial',
             'desc' => 'Mempelajari aturan, keadilan, dan penegakannya.',
             'min' => [],
             'tags' => ['analitis', 'logika', 'diskusi', 'keadilan']],

            ['name' => 'Farmasi', 'field' => 'Kesehatan',
             'desc' => 'Obat-obatan, kimia, dan pelayanan kesehatan.',
             'min' => ['Biologi' => 87, 'Fisika' => 87, 'Kimia' => 87],
             'tags' => ['kesehatan', 'riset', 'kimia', 'biologi']],

            ['name' => 'Teknik Sipil', 'field' => 'Teknik',
             'desc' => 'Perancangan dan konstruksi infrastruktur.',
             'min' => [], // CEK: PDF menulis 86, kolom mapel tidak terbaca
             'tags' => ['teknik', 'problem_solving', 'konstruksi', 'perancangan']],

            ['name' => 'Pendidikan Bahasa Inggris', 'field' => 'Pendidikan',
             'desc' => 'Mengajarkan bahasa dan budaya global.',
             'min' => [],
             'tags' => ['pendidikan', 'bahasa', 'komunikasi', 'budaya']],

            ['name' => 'Ilmu Gizi', 'alias' => 'Gizi', 'field' => 'Kesehatan',
             'desc' => 'Mengelola pola makan untuk hidup lebih sehat.',
             'min' => ['Biologi' => 82], // Tabel 1 dan 2 menulis 82 (teks hitungan menulis 83)
             'tags' => ['kesehatan', 'biologi', 'riset', 'pelayanan']],

            ['name' => 'Hubungan Internasional', 'field' => 'Sosial',
             'desc' => 'Politik global, diplomasi, dan kerja sama antarnegara.',
             'min' => [],
             'tags' => ['politik', 'global', 'komunikasi', 'analitis']],

            ['name' => 'Teknik Elektro', 'field' => 'Teknik',
             'desc' => 'Kelistrikan, elektronika, dan sistem kendali.',
             'min' => ['Matematika' => 89],
             'tags' => ['logika', 'teknologi', 'inovasi', 'matematika']],

            ['name' => 'Sastra Indonesia', 'field' => 'Bahasa & Budaya',
             'desc' => 'Mempelajari bahasa, sastra, dan budaya Indonesia.',
             'min' => [],
             'tags' => ['bahasa', 'budaya', 'kreatif', 'menulis']],

            ['name' => 'Kehutanan', 'field' => 'Pertanian',
             'desc' => 'Pengelolaan dan konservasi sumber daya hutan.',
             'min' => [], // CEK: PDF menulis 77 dan 77, kolom mapel tidak terbaca
             'tags' => ['lingkungan', 'alam', 'riset', 'konservasi']],

            ['name' => 'Ilmu Komputer', 'field' => 'Teknologi',
             'desc' => 'Komputasi, algoritma, dan riset teknologi.',
             'min' => ['Matematika' => 90],
             'tags' => ['logika', 'matematika', 'problem_solving', 'riset']],
        ];
    }
}