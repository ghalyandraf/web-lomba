<?php

namespace App\Services;

use App\Models\Major;
use Illuminate\Support\Collection;

/**
 * Menghitung persentase kecocokan jurusan.
 * Rumusnya SAMA dengan skrip di halaman Nilai Rapor (report_cards/index.blade.php):
 *   nilai   = rata-rata berbobot mapel relevan x faktor cakupan (0,5 - 1)
 *   akhir   = 70% nilai + 30% kecocokan minat/keahlian (jika minat/keahlian diisi)
 * Kalau salah satu diubah, ubah yang lain juga.
 */
class MajorMatcher
{
    public const DEFAULT_MIN = 75;

    public const SUBJECTS = [
        'Pendidikan_Agama' => 'Pendidikan Agama dan Budi Pekerti',
        'Pendidikan_Pancasila' => 'Pendidikan Pancasila (PPKn)',
        'Bahasa_Indonesia' => 'Bahasa Indonesia',
        'Matematika' => 'Matematika',
        'Bahasa_Inggris' => 'Bahasa Inggris',
        'Sejarah' => 'Sejarah',
        'PJOK' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan',
        'Seni_Budaya' => 'Seni dan Budaya',
        'Informatika_TIK' => 'Informatika',
        'Projek_IPAS' => 'IPAS (Ilmu Pengetahuan Alam dan Sosial)',
        'Muatan_Lokal' => 'Muatan Lokal / Bahasa Daerah',
        'Fisika' => 'Fisika',
        'Kimia' => 'Kimia',
        'Biologi' => 'Biologi',
        'Matematika_Lanjut' => 'Matematika Tingkat Lanjut',
        'Ekonomi' => 'Ekonomi',
        'Sosiologi' => 'Sosiologi',
        'Geografi' => 'Geografi',
        'Antropologi' => 'Antropologi',
        'Sejarah_Lanjut' => 'Sejarah Tingkat Lanjut',
        'Bahasa_Indonesia_Lanjut' => 'Bahasa Indonesia Tingkat Lanjut',
        'Bahasa_Inggris_Lanjut' => 'Bahasa Inggris Tingkat Lanjut',
        'Bahasa_Arab' => 'Bahasa Arab',
        'Bahasa_Jerman' => 'Bahasa Jerman',
        'Bahasa_Jepang' => 'Bahasa Jepang',
        'Bahasa_Korea' => 'Bahasa Korea',
        'Bahasa_Mandarin' => 'Bahasa Mandarin',
        'Bahasa_Prancis' => 'Bahasa Prancis',
        'Seni_Musik' => 'Seni Musik',
        'Seni_Rupa' => 'Seni Rupa',
        'Seni_Teater' => 'Seni Teater',
        'Seni_Tari' => 'Seni Tari',
        'Prakarya_Kewirausahaan' => 'Prakarya dan Kewirausahaan',
        'Mapel_Kejuruan' => 'Mata pelajaran kejuruan (SMK)',
    ];

    /** Bobot mapel yang punya nilai minimum eksplisit vs mapel dari required_skills. */
    private const WEIGHT_EXPLICIT = 2;
    private const WEIGHT_SKILL    = 1;

    private array $subjectIndex = [];

    public function __construct()
    {
        foreach (self::SUBJECTS as $key => $label) {
            $this->subjectIndex[$this->normKey($key)] = $this->normKey($key);
            $this->subjectIndex[$this->normKey($label)] = $this->normKey($key);
        }
    }

    /**
     * Key mapel (sudah dinormalisasi: huruf kecil + underscore) => nama tampil.
     * Dipakai JS di halaman Nilai Rapor.
     */
    public static function subjectLabels(): array
    {
        $out = [];
        foreach (self::SUBJECTS as $key => $label) {
            $norm = trim(preg_replace('/[\s-]+/u', '_', mb_strtolower(trim($key))));
            $out[$norm] = $label;
        }
        return $out;
    }

    /**
     * Ubah satu record Major jadi payload untuk JS dan untuk perhitungan rank().
     *
     * @return array{id:mixed,name:string,field:string,tags:string[],subjects:array<int,array{key:string,w:float,min:float}>}
     */
    public function prepare($m): array
    {
        $tags    = $this->strings($this->toArray(data_get($m, 'interest_tags')));
        $skills  = $this->strings($this->toArray(data_get($m, 'required_skills')));
        $field   = trim((string) data_get($m, 'field', ''));
        $allTags = $this->strings(array_merge($tags, $field !== '' ? [$field] : [], $skills));

        [$perSubject, $globalMin] = $this->parseMinScores(data_get($m, 'min_scores'));
        $defaultMin = $globalMin > 0 ? $globalMin : (float) self::DEFAULT_MIN;

        $subjects = [];

        // 1) mapel dengan nilai minimum eksplisit (bobot lebih besar)
        foreach ($perSubject as $key => $min) {
            if ($min <= 0) {
                continue;
            }
            $subjects[$key] = [
                'key' => $key,
                'w'   => (float) self::WEIGHT_EXPLICIT,
                'min' => (float) $min,
            ];
        }

        // 2) required_skills yang ternyata nama mapel
        foreach ($skills as $skill) {
            $key = $this->subjectIndex[$this->normKey($skill)] ?? null;
            if ($key && ! isset($subjects[$key])) {
                $subjects[$key] = [
                    'key' => $key,
                    'w'   => (float) self::WEIGHT_SKILL,
                    'min' => $defaultMin,
                ];
            }
        }

        return [
            'id'       => data_get($m, 'id'),
            'name'     => (string) (data_get($m, 'name') ?? '-'),
            'field'    => $field,
            'tags'     => $allTags,
            'subjects' => array_values($subjects),
        ];
    }

    /**
     * @param  array|string|null  $grades     ['Matematika' => 90, ...]
     * @param  array|string|null  $interests  "teknologi, desain" atau array
     * @param  array|string|null  $skills     "coding, public speaking" atau array
     * @return Collection  terurut dari yang paling cocok
     */
    public function rank($grades, $interests = '', $skills = '', ?Collection $majors = null): Collection
    {
        if (is_string($grades)) {
            $grades = json_decode($grades, true) ?: [];
        }

        $clean = [];
        foreach ((array) $grades as $key => $value) {
            if ($value === null || $value === '' || ! is_numeric($value)) {
                continue;
            }
            $value = (float) $value;
            if ($value < 0 || $value > 100) {
                continue;
            }
            $clean[$this->normKey($key)] = $value;
        }

        if (! $clean) {
            return collect();
        }

        $avg    = array_sum($clean) / count($clean);
        $terms  = $this->terms($interests, $skills);
        $majors ??= Major::all();
        $labels = self::subjectLabels();

        return $majors
            ->map(fn ($m) => $this->scoreMajor($m, $clean, $avg, $terms, $labels))
            ->sortByDesc('pct')
            ->values()
            ->map(function ($row, $i) {
                $row['rank'] = $i + 1;
                return $row;
            });
    }

    public static function level(float $pct): array
    {
        if ($pct >= 80) return ['text' => 'Sangat Cocok',  'key' => 'high', 'color' => '#1f9d63'];
        if ($pct >= 60) return ['text' => 'Cocok',         'key' => 'mid',  'color' => '#2f80c9'];
        if ($pct >= 40) return ['text' => 'Cukup Cocok',   'key' => 'low',  'color' => '#d9a21b'];
        return                 ['text' => 'Kurang Cocok',  'key' => 'none', 'color' => '#d32f2f'];
    }

    // ---------------------------------------------------------------

    private function scoreMajor($m, array $grades, float $avg, array $terms, array $labels): array
    {
        $p  = $this->prepare($m);
        $sn = $this->gradeScore($p['subjects'], $grades, $avg, $labels);

        $matchedTerms = 0;
        $matched = [];
        foreach ($terms as $term) {
            $hit = false;
            foreach ($p['tags'] as $tag) {
                if ($this->tagMatches($tag, $term)) {
                    $hit = true;
                    $matched[$tag] = true;
                }
            }
            if ($hit) {
                $matchedTerms++;
            }
        }

        $pct = $sn['pct'];
        if (count($terms) > 0) {
            $pct = $sn['pct'] * 0.7 + (($matchedTerms / count($terms)) * 100) * 0.3;
        }

        return [
            'id'      => $p['id'],
            'name'    => $p['name'],
            'field'   => $p['field'],
            'pct'     => max(0, min(100, $pct)),
            'note'    => $sn['note'],
            'tags'    => $p['tags'],
            'matched' => array_keys($matched),
        ];
    }

    /**
     * Port persis dari skorNilai() di JS halaman Nilai Rapor.
     * Rata-rata berbobot mapel relevan x faktor cakupan (0,5 - 1).
     */
    private function gradeScore(array $subjects, array $grades, float $avg, array $labels): array
    {
        $wAll = 0.0;
        $wFill = 0.0;
        $sum = 0.0;
        $names = [];

        foreach ($subjects as $s) {
            $wAll += $s['w'];
            if (isset($grades[$s['key']])) {
                $g = $grades[$s['key']];
                $v = $s['min'] > 0 ? min(100, ($g / $s['min']) * 100) : $g;
                $wFill += $s['w'];
                $sum   += $s['w'] * $v;
                $names[] = $labels[$s['key']] ?? $s['key'];
            }
        }

        if ($wFill <= 0) {
            return [
                'pct'  => $avg * 0.5,
                'note' => 'Nilai mapel yang relevan belum diisi, jadi hanya memakai rata-rata semua nilai (dikurangi).',
            ];
        }

        $coverage = $wFill / $wAll;

        return [
            'pct'  => ($sum / $wFill) * (0.5 + 0.5 * $coverage),
            'note' => 'Mapel relevan terisi: ' . implode(', ', $names) . ' (' . count($names) . ' dari ' . count($subjects) . ').',
        ];
    }

    private function parseMinScores($raw): array
    {
        if (is_string($raw) && ! is_numeric($raw)) {
            $raw = $this->toArray($raw);
        }

        $per = [];
        $global = 0.0;

        if (is_numeric($raw)) {
            $global = (float) $raw;
        } elseif (is_array($raw)) {
            foreach ($raw as $k => $v) {
                if (is_numeric($v) && ! is_int($k)) {
                    $per[$this->normKey($k)] = (float) $v;
                } elseif (is_array($v)) {
                    $name = $v['subject'] ?? $v['mapel'] ?? $v['name'] ?? null;
                    $val  = $v['min'] ?? $v['score'] ?? $v['nilai'] ?? null;
                    if ($name !== null && is_numeric($val)) {
                        $per[$this->normKey($name)] = (float) $val;
                    }
                }
            }
        }

        return [$per, $global];
    }

    private function terms($interests, $skills): array
    {
        $join = fn ($v) => is_array($v) ? implode(',', $v) : (string) $v;
        $parts = preg_split('/[,;\n]/u', $join($interests) . ',' . $join($skills));

        $out = [];
        foreach ($parts as $part) {
            $n = $this->norm($part);
            if ($n !== '' && ! in_array($n, $out, true)) {
                $out[] = $n;
            }
        }
        return $out;
    }

    private function tagMatches(string $tag, string $term): bool
    {
        $a = $this->norm($tag);
        if ($a === $term) {
            return true;
        }
        if (mb_strlen($a) >= 3 && mb_strlen($term) >= 3) {
            return str_contains($a, $term) || str_contains($term, $a);
        }
        return false;
    }

    private function toArray($v): array
    {
        if (is_string($v)) {
            $d = json_decode($v, true);
            return is_array($d) ? $d : [];
        }
        return is_array($v) ? $v : [];
    }

    private function strings(array $arr): array
    {
        $arr = array_filter($arr, 'is_scalar');
        $arr = array_map(fn ($x) => trim((string) $x), $arr);
        return array_values(array_unique(array_filter($arr, fn ($x) => $x !== '')));
    }

    private function norm($s): string
    {
        return trim(preg_replace('/\s+/u', ' ', mb_strtolower((string) $s)));
    }

    private function normKey($s): string
    {
        return trim(preg_replace('/[\s-]+/u', '_', mb_strtolower(trim((string) $s))));
    }
}