<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Major;
use App\Models\AnalysisResult;
use App\Models\Recommendation;
use Illuminate\Support\Facades\Auth;

class DiamondController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $latestReportCard = $user->reportCards()->latest()->first();
        $analysisResults = $user->analysisResults()->with('major', 'recommendations')->latest()->get();

        return view('diamond.index', compact('latestReportCard', 'analysisResults'));
    }

    public function analyze(Request $request)
    {
        $user = Auth::user();
        $reportCard = $user->reportCards()->latest()->first();

        if (!$reportCard) {
            return redirect()->route('report-cards.index')->with('error', 'Silakan masukkan nilai rapor terlebih dahulu.');
        }

        $userScores = $reportCard->scores ?? [];
        $majors = Major::all();

        AnalysisResult::where('user_id', $user->id)->delete();

        foreach ($majors as $major) {
            $minScores = $major->min_scores;
            $totalCriteria = count($minScores);
            $fulfilledCriteria = 0;
            $matchedAspects = [];
            $improvementAspects = [];

            if ($totalCriteria > 0) {
                foreach ($minScores as $subject => $minVal) {
                    if (!isset($userScores[$subject])) {
                        $improvementAspects[] = "Mata pelajaran " . str_replace('_', ' ', $subject) . " tidak tercatat di rapor (Syarat minimum: $minVal)";
                        continue;
                    }

                    $userVal = $userScores[$subject];
                    if ($userVal >= $minVal) {
                        $fulfilledCriteria++;
                        $matchedAspects[] = "Nilai " . str_replace('_', ' ', $subject) . " ($userVal) memenuhi standar ($minVal)";
                    } else {
                        $shortfall = $minVal - $userVal;
                        $improvementAspects[] = "Nilai " . str_replace('_', ' ', $subject) . " ($userVal) kurang $shortfall poin dari standar ($minVal)";
                    }
                }
                $matchPercentage = round(($fulfilledCriteria / $totalCriteria) * 100, 2);
            } else {
                $matchPercentage = 70.00;
            }

            if ($matchPercentage >= 100) {
                $category = 'Sangat Sesuai';
            } elseif ($matchPercentage >= 50) {
                $category = 'Cukup Sesuai';
            } else {
                $category = 'Perlu Pengembangan';
            }

            $analysis = AnalysisResult::create([
                'user_id' => $user->id,
                'major_id' => $major->id,
                'match_percentage' => $matchPercentage,
                'category' => $category,
                'matched_aspects' => $matchedAspects,
                'improvement_aspects' => $improvementAspects,
            ]);

            if (count($improvementAspects) > 0) {
                Recommendation::create([
                    'analysis_result_id' => $analysis->id,
                    'title' => "Panduan Strategis Pejuang SNBT: " . $major->name,
                    'learning_tips' => "Nilai rapor kamu belum sepenuhnya memenuhi standar minimum murni untuk jurusan ini, namun peluang lolos lewat jalur SNBT (UTBK) masih sangat terbuka lebar! Langkah taktis yang harus kamu lakukan: 1) Fokus penguatan Tes Potensi Skolastik (TPS) meliputi Penalaran Umum, Pemahaman Bacaan, dan Pengetahuan Kuantitatif. 2) Evaluasi mata pelajaran yang masih kosong atau kurang dengan mengulik konsep dasarnya kembali, bukan sekadar menghafal rumus. 3) Rutin mengikuti simulasi tryout berkala untuk melatih manajemen waktu pengerjaan soal. Jadikan skor UTBK yang tinggi sebagai penutup celah kekurangan nilai rapor sekolahmu!",
                    'resources' => "Buat jadwal belajar harian yang konsisten, fokus pada pemahaman konsep inti, dan evaluasi setiap kesalahan dari hasil tryout.",
                    'is_completed' => false,
                ]);
            }
        }

        return redirect()->route('diamond.index')->with('success', 'Analisis Diamond berhasil mendeteksi kecocokan jurusan untukmu!');
    }
}