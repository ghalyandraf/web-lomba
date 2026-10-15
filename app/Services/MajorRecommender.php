<?php

namespace App\Services;

/**
 * Rekomendasi jurusan dengan Knowledge-Based Filtering (case-based, weighted similarity).
 * Mengikuti makalah SENATIB 2025 "Sistem Rekomendasi Program Studi Berdasarkan
 * Preferensi dan Kemampuan Akademik":
 *
 *   1) Filter  : hanya jurusan yang punya minimal satu tag minat yang sama dengan siswa.
 *   2) Skor    : Sim(user, item) = W1*S1 + W2*S2 + ... + Wn*Sn
 *                - 5 mata pelajaran (Matematika, Biologi, Ekonomi, Fisika, Kimia),
 *                  bobot 0,15 per mapel
 *                    S = 1                      jika jurusan tidak mensyaratkan mapel itu
 *                    S = 1 - selisih / 100      jika disyaratkan (nilai maksimum 100)
 *                - minat, bobot 0,25
 *                    S = jumlah tag yang sama / jumlah tag milik jurusan
 *   3) Urutkan : skor tertinggi = paling direkomendasikan.
 *
 * Kelas ini tidak bergantung pada Laravel: jurusan boleh berupa model Eloquent,
 * objek biasa, atau array dengan kunci: name, min_scores, interest_tags.
 */
class MajorRecommender
{
    public const SUBJECTS = ['Matematika', 'Biologi', 'Ekonomi', 'Fisika', 'Kimia'];
    public const SUBJECT_WEIGHT = 0.15;
    public const INTEREST_WEIGHT = 0.25;
    public const MAX_SCORE = 100;

    /** Nama kolom lain yang dikenali untuk tiap mapel (termasuk nama kolom di makalah). */
    private const ALIASES = [
        'n_mat' => 'matematika', 'mat' => 'matematika',
        'n_bio' => 'biologi',    'bio' => 'biologi',
        'n_eko' => 'ekonomi',    'eko' => 'ekonomi',
        'n_fis' => 'fisika',     'fis' => 'fisika',
        'n_kim' => 'kimia',      'kim' => 'kimia',
    ];

    /**
     * false (bawaan): hanya nilai yang KURANG dari syarat yang mengurangi skor.
     * true          : selisih diambil mutlak, nilai yang melebihi syarat juga dikurangi
     *                 (sebagian contoh hitungan di makalah memakai cara ini).
     */
    private bool $penalizeSurplus;

    public function __construct(bool $penalizeSurplus = false)
    {
        $this->penalizeSurplus = $penalizeSurplus;
    }

    /**
     * Rekomendasi seluruh jurusan, diurutkan dari skor tertinggi.
     *
     * @param  array|string|null $scores    nilai rapor siswa, mis. ['Matematika' => 86, ...]
     * @param  array|string|null $interests tag minat, mis. '#logika, #analitis' atau ['logika', 'analitis']
     * @param  iterable          $majors    daftar jurusan
     * @param  int|null          $limit     batasi jumlah hasil
     * @return array<int, array>  tiap item: major, score (0-1), percent (0-100), matched_tags,
     *                            interest_score, subject_scores
     */
    public function recommend($scores, $interests, iterable $majors, ?int $limit = null): array
    {
        $studentTags = self::normalizeTags($interests);
        $results = [];

        foreach ($majors as $major) {
            $result = $this->score($scores, $interests, $major);

            // Tahap 1 (filter): buang jurusan tanpa tag minat yang sama.
            // Jika siswa belum memilih minat, filter dilewati (skor minat = 0).
            if (! empty($studentTags) && empty($result['matched_tags'])) {
                continue;
            }

            $results[] = $result;
        }

        // Tahap 3: urut skor tertinggi; seri -> tag sama lebih banyak -> nama
        usort($results, function ($a, $b) {
            return ($b['score'] <=> $a['score'])
                ?: (count($b['matched_tags']) <=> count($a['matched_tags']))
                ?: strcmp((string) self::field($a['major'], 'name', ''), (string) self::field($b['major'], 'name', ''));
        });

        return $limit !== null ? array_slice($results, 0, $limit) : $results;
    }

    /**
     * Hitung kecocokan siswa dengan SATU jurusan (tanpa tahap filter).
     */
    public function score($scores, $interests, $major): array
    {
        $studentScores = self::normalizeScores($scores);
        $studentTags   = self::normalizeTags($interests);
        $minScores     = self::normalizeScores(self::field($major, 'min_scores'));
        $majorTags     = self::normalizeTags(self::field($major, 'interest_tags'));

        // Nilai akademik: 5 mapel x bobot 0,15
        $total = 0.0;
        $subjectScores = [];

        foreach (self::SUBJECTS as $subject) {
            $s = $this->subjectSimilarity($studentScores, $minScores, $subject);
            $subjectScores[$subject] = round($s, 3);
            $total += self::SUBJECT_WEIGHT * $s;
        }

        // Minat: tag sama / jumlah tag jurusan, bobot 0,25
        $matched = array_values(array_intersect($studentTags, $majorTags));
        $interestScore = count($majorTags) > 0 ? count($matched) / count($majorTags) : 0.0;
        $total += self::INTEREST_WEIGHT * $interestScore;

        return [
            'major'          => $major,
            'score'          => round($total, 3),
            'percent'        => (int) round($total * 100),
            'matched_tags'   => $matched,
            'interest_score' => round($interestScore, 3),
            'subject_scores' => $subjectScores,
        ];
    }

    /** Kecocokan dalam persen (0-100) untuk satu jurusan. */
    public function percent($scores, $interests, $major): int
    {
        return $this->score($scores, $interests, $major)['percent'];
    }

    private function subjectSimilarity(array $studentScores, array $minScores, string $subject): float
    {
        $key = self::key($subject);

        // Jurusan tidak mensyaratkan mapel ini -> skor penuh
        if (! array_key_exists($key, $minScores)) {
            return 1.0;
        }

        $min   = $minScores[$key];
        $score = $studentScores[$key] ?? 0.0; // nilai kosong dianggap 0
        $diff  = $this->penalizeSurplus ? abs($min - $score) : max(0.0, $min - $score);

        return max(0.0, 1 - $diff / self::MAX_SCORE);
    }

    /** '#Logika, problem solving' atau JSON/array -> ['logika', 'problem_solving'] */
    public static function normalizeTags($input): array
    {
        if (is_string($input)) {
            $decoded = json_decode($input, true);
            $input = (json_last_error() === JSON_ERROR_NONE && is_array($decoded))
                ? $decoded
                : preg_split('/[,;\n#]+/', $input);
        }

        if (! is_array($input)) {
            return [];
        }

        $tags = [];
        foreach ($input as $tag) {
            if (! is_scalar($tag)) {
                continue;
            }
            $tag = mb_strtolower(trim((string) $tag));
            $tag = preg_replace('/[\s\-]+/u', '_', ltrim($tag, '#'));
            $tag = trim($tag, '_');
            if ($tag !== '') {
                $tags[$tag] = true;
            }
        }

        return array_keys($tags);
    }

    /** ['Matematika' => '86', 'n_bio' => 90] -> ['matematika' => 86.0, 'biologi' => 90.0] */
    private static function normalizeScores($scores): array
    {
        if (is_string($scores)) {
            $scores = json_decode($scores, true);
        }

        if (! is_array($scores)) {
            return [];
        }

        $out = [];
        foreach ($scores as $name => $value) {
            if (is_numeric($value)) {
                $out[self::key($name)] = (float) $value;
            }
        }

        return $out;
    }

    private static function key($name): string
    {
        $key = str_replace([' ', '-'], '_', mb_strtolower(trim((string) $name)));

        return self::ALIASES[$key] ?? $key;
    }

    private static function field($item, string $key, $default = null)
    {
        if (is_array($item)) {
            return $item[$key] ?? $default;
        }

        if (is_object($item)) {
            return $item->{$key} ?? $default;
        }

        return $default;
    }
}