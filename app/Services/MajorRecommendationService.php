<?php

namespace App\Services;

use App\Models\Major;
use App\Models\ReportCard;
use Illuminate\Support\Collection;

class MajorRecommendationService
{
    /**
     * Membuat rekomendasi jurusan berdasarkan nilai rapor,
     * minat, dan keterampilan siswa.
     */
    public function recommend(ReportCard $reportCard): Collection
    {
        $scores = $this->normalizeScores($reportCard->scores ?? []);
        $interests = $this->normalizeText($reportCard->interests ?? '');
        $skills = $this->normalizeText($reportCard->skills ?? '');

        return Major::query()
            ->get()
            ->map(function (Major $major) use ($scores, $interests, $skills) {
                $requirements = $this->normalizeScores(
                    $major->min_scores ?? []
                );

                $requiredSkills = $major->required_skills ?? [];

                $scoreResult = $this->calculateScoreMatch(
                    $scores,
                    $requirements
                );

                $interestResult = $this->calculateTextMatch(
                    $interests,
                    (string) $major->name . ' ' .
                    (string) $major->field . ' ' .
                    (string) $major->description
                );

                $skillResult = $this->calculateSkillMatch(
                    $skills,
                    $requiredSkills
                );

                /*
                 * Bobot:
                 * Nilai rapor 60%
                 * Minat      20%
                 * Keterampilan 20%
                 *
                 * Jika suatu kategori tidak memiliki data yang dapat
                 * dinilai, bobotnya didistribusikan ke kategori lain
                 * yang tersedia.
                 */
                $components = [];

                if ($scoreResult['available']) {
                    $components[] = [
                        'score' => $scoreResult['score'],
                        'weight' => 60,
                    ];
                }

                if ($interests !== '') {
                    $components[] = [
                        'score' => $interestResult,
                        'weight' => 20,
                    ];
                }

                if ($skills !== '' && count($requiredSkills) > 0) {
                    $components[] = [
                        'score' => $skillResult,
                        'weight' => 20,
                    ];
                }

                $totalWeight = array_sum(
                    array_column($components, 'weight')
                );

                $matchScore = $totalWeight > 0
                    ? (int) round(
                        array_sum(array_map(
                            fn ($component) =>
                                $component['score'] * $component['weight'],
                            $components
                        )) / $totalWeight
                    )
                    : 0;

                $reasons = [];

                if ($scoreResult['available']) {
                    if ($scoreResult['score'] >= 80) {
                        $reasons[] = 'Nilai rapor cukup sesuai dengan kriteria jurusan.';
                    } elseif ($scoreResult['score'] >= 60) {
                        $reasons[] = 'Sebagian nilai rapor sesuai dengan kriteria jurusan.';
                    } else {
                        $reasons[] = 'Beberapa nilai rapor masih perlu ditingkatkan.';
                    }
                } else {
                    $reasons[] = 'Belum ada cukup data nilai untuk menilai persyaratan jurusan.';
                }

                if ($interests !== '') {
                    $reasons[] = $interestResult >= 50
                        ? 'Minat yang diisi memiliki keterkaitan dengan bidang jurusan.'
                        : 'Keterkaitan minat dengan bidang jurusan masih perlu dieksplorasi.';
                }

                if ($skills !== '' && count($requiredSkills) > 0) {
                    $reasons[] = $skillResult >= 50
                        ? 'Ada keterampilan yang berkaitan dengan kebutuhan jurusan.'
                        : 'Keterampilan yang dibutuhkan jurusan masih dapat dikembangkan.';
                }

                $major->match_score = $matchScore;
                $major->match_reasons = $reasons;
                $major->score_analysis = $scoreResult;

                return $major;
            })
            ->sortByDesc('match_score')
            ->values();
    }

    /**
     * Menyamakan format nama mata pelajaran.
     */
    private function normalizeSubject(string $subject): string
    {
        $subject = mb_strtolower(trim($subject));

        $aliases = [
            'matematika' => 'matematika',
            'bahasa_inggris' => 'bahasa inggris',
            'bahasa indonesia' => 'bahasa indonesia',
            'fisika' => 'fisika',
            'kimia' => 'kimia',
            'biologi' => 'biologi',
            'ekonomi' => 'ekonomi',
            'informatika_tik' => 'informatika',
            'tik' => 'informatika',
        ];

        return $aliases[$subject] ?? str_replace('_', ' ', $subject);
    }

    private function normalizeScores(array $scores): array
    {
        $normalized = [];

        foreach ($scores as $subject => $score) {
            if (!is_numeric($score)) {
                continue;
            }

            $normalized[$this->normalizeSubject((string) $subject)] =
                max(0, min(100, (float) $score));
        }

        return $normalized;
    }

    /**
     * Menghitung kecocokan nilai dengan nilai minimum jurusan.
     * Nilai minimum tidak dianggap sebagai batas mutlak penerimaan.
     */
    private function calculateScoreMatch(
        array $scores,
        array $requirements
    ): array {
        if (empty($requirements)) {
            if (empty($scores)) {
                return [
                    'available' => false,
                    'score' => 0,
                ];
            }

            return [
                'available' => true,
                'score' => 70,
            ];
        }

        $results = [];

        foreach ($requirements as $subject => $minimum) {
            if (!is_numeric($minimum)) {
                continue;
            }

            $normalizedSubject = $this->normalizeSubject(
                (string) $subject
            );

            if (!array_key_exists($normalizedSubject, $scores)) {
                continue;
            }

            $minimum = max(1, (float) $minimum);
            $studentScore = $scores[$normalizedSubject];

            $results[] = min(
                100,
                ($studentScore / $minimum) * 100
            );
        }

        if (empty($results)) {
            return [
                'available' => false,
                'score' => 0,
            ];
        }

        return [
            'available' => true,
            'score' => (int) round(
                array_sum($results) / count($results)
            ),
        ];
    }

    /**
     * Mencari keterkaitan teks minat dengan informasi jurusan.
     */
    private function calculateTextMatch(
        string $studentInterests,
        string $majorInformation
    ): int {
        $interestWords = $this->keywords($studentInterests);
        $majorWords = $this->keywords($majorInformation);

        if (empty($interestWords)) {
            return 0;
        }

        $matches = array_intersect(
            $interestWords,
            $majorWords
        );

        return (int) round(
            count($matches) / count($interestWords) * 100
        );
    }

    /**
     * Mencocokkan keterampilan yang dimasukkan siswa.
     */
    private function calculateSkillMatch(
        string $studentSkills,
        array $requiredSkills
    ): int {
        $studentWords = $this->keywords($studentSkills);

        $requiredWords = [];

        foreach ($requiredSkills as $skill) {
            if (is_string($skill)) {
                $requiredWords = array_merge(
                    $requiredWords,
                    $this->keywords($skill)
                );
            }
        }

        $requiredWords = array_values(array_unique($requiredWords));

        if (empty($requiredWords)) {
            return 0;
        }

        $matches = array_intersect(
            $requiredWords,
            $studentWords
        );

        return (int) round(
            count($matches) / count($requiredWords) * 100
        );
    }

    private function normalizeText(string $text): string
    {
        return mb_strtolower(trim($text));
    }

    private function keywords(string $text): array
    {
        $text = mb_strtolower($text);

        $words = preg_split(
            '/[^\p{L}\p{N}]+/u',
            $text,
            -1,
            PREG_SPLIT_NO_EMPTY
        );

        $stopWords = [
            'dan', 'atau', 'yang', 'di', 'ke', 'dari',
            'untuk', 'dengan', 'saya', 'aku', 'suka',
            'ingin', 'belajar', 'bidang', 'jurusan',
        ];

        $words = array_filter(
            $words,
            fn ($word) =>
                mb_strlen($word) > 2 &&
                !in_array($word, $stopWords, true)
        );

        return array_values(array_unique($words));
    }
}
