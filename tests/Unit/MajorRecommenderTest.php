<?php

namespace Tests\Unit;

use App\Services\MajorRecommender;
use PHPUnit\Framework\TestCase;

/**
 * Memverifikasi contoh hitungan pada makalah SENATIB 2025:
 * nilai Mat 86, Bio 90, Eko 80, Fis 84, Kim 88; minat #logika #analitis #kesehatan.
 */
class MajorRecommenderTest extends TestCase
{
    private function prodi(): array
    {
        return [
            ['name' => 'Teknik Informatika', 'min_scores' => ['Matematika' => 88],
             'interest_tags' => ['logika', 'problem_solving', 'inovasi', 'teknologi', 'pemrograman']],
            ['name' => 'Kedokteran', 'min_scores' => ['Biologi' => 90],
             'interest_tags' => ['riset', 'kesehatan', 'pelayanan', 'biologi', 'humaniora']],
            ['name' => 'Akuntansi', 'min_scores' => ['Ekonomi' => 80],
             'interest_tags' => ['detail', 'analitis', 'keuangan', 'bisnis']],
            ['name' => 'Hukum', 'min_scores' => [],
             'interest_tags' => ['analitis', 'logika', 'diskusi', 'keadilan']],
            ['name' => 'Sastra Indonesia', 'min_scores' => [],
             'interest_tags' => ['bahasa', 'budaya', 'kreatif', 'menulis']],
        ];
    }

    private function hasil(): array
    {
        $siswa = ['Matematika' => 86, 'Biologi' => 90, 'Ekonomi' => 80, 'Fisika' => 84, 'Kimia' => 88];

        $out = [];
        foreach ((new MajorRecommender())->recommend($siswa, '#logika, #analitis, #kesehatan', $this->prodi()) as $r) {
            $out[$r['major']['name']] = $r;
        }

        return $out;
    }

    public function test_skor_sama_dengan_contoh_makalah(): void
    {
        $hasil = $this->hasil();

        $this->assertEqualsWithDelta(0.797, $hasil['Teknik Informatika']['score'], 0.0011);
        $this->assertEqualsWithDelta(0.800, $hasil['Kedokteran']['score'], 0.0011);
        $this->assertEqualsWithDelta(0.813, $hasil['Akuntansi']['score'], 0.0011);
        $this->assertEqualsWithDelta(0.875, $hasil['Hukum']['score'], 0.0011);
    }

    public function test_hukum_peringkat_pertama(): void
    {
        $this->assertSame('Hukum', array_key_first($this->hasil()));
    }

    public function test_jurusan_tanpa_tag_minat_yang_sama_difilter(): void
    {
        $this->assertArrayNotHasKey('Sastra Indonesia', $this->hasil());
    }

    public function test_tag_minat_dinormalisasi(): void
    {
        $this->assertSame(
            ['logika', 'problem_solving', 'kesehatan'],
            MajorRecommender::normalizeTags('#Logika, problem solving ; #kesehatan, logika')
        );
    }
}