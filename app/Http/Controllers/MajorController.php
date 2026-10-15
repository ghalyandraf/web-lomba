<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Services\MajorRecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MajorController extends Controller
{
    /**
     * Menampilkan daftar jurusan dan fitur pencarian.
     */
    
public function index(Request $request)
{
    // Mengembalikan ID jurusan untuk proses pemilihan dari JavaScript.
    if ($request->expectsJson() && $request->filled('selected_major')) {
        $major = Major::where(
            'name',
            trim($request->query('selected_major'))
        )->first();

        if (!$major) {
            return response()->json([
                'message' => 'Jurusan tersebut belum tersedia di database.'
            ], 404);
        }

        return response()->json([
            'id' => $major->id,
            'name' => $major->name,
        ]);
    }

    // Daftar jurusan dan pencarian tetap berjalan seperti sebelumnya.
    $majors = Major::query()
        ->when($request->filled('q'), function ($query) use ($request) {
            $keyword = trim($request->query('q'));

            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('field', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        })
        ->orderBy('name')
        ->get();

    $selectedMajor = Auth::user()->major;

    return view('majors.index', compact(
        'majors',
        'selectedMajor'
    ));
}


    /**
     * Menganalisis rapor terbaru dan menampilkan rekomendasi.
     */
    public function recommendations(
        MajorRecommendationService $recommendationService
    ) {
        $reportCard = Auth::user()
            ->reportCards()
            ->latest()
            ->first();

        if (!$reportCard) {
            return redirect()
                ->route('report-cards.index')
                ->with(
                    'warning',
                    'Isi nilai rapor, minat, dan keterampilan terlebih dahulu agar LANTERA dapat memberikan rekomendasi jurusan.'
                );
        }

        $recommendations = $recommendationService->recommend(
            $reportCard
        );

        return view('majors.recommendations', compact(
            'recommendations',
            'reportCard'
        ));
    }

    /**
     * Menampilkan detail jurusan berdasarkan slug.
     */
    public function show(string $slug)
    {
        $major = Major::where('slug', $slug)->firstOrFail();

        $selectedMajor = Auth::user()->major;

        return view('majors.show', compact(
            'major',
            'selectedMajor'
        ));
    }

    /**
     * Menyimpan pilihan jurusan siswa ke users.major_id.
     */
    public function select(Request $request, Major $major)
    {
        $user = Auth::user();

        $user->major_id = $major->id;
        $user->save();

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Jurusan pilihan berhasil disimpan: ' . $major->name
            );
    }
}
