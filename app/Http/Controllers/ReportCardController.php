<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportCard;
use Illuminate\Support\Facades\Auth;

class ReportCardController extends Controller
{
    public function index()
    {
        $reportCards = Auth::user()->reportCards()->latest()->get();
        
        $availableSubjects = [
            'Matematika',
            'Bahasa_Indonesia',
            'Bahasa_Inggris',
            'Fisika',
            'Kimia',
            'Biologi',
            'Ekonomi',
            'Geografi',
            'Sosiologi',
            'Sejarah',
            'Informatika_TIK',
            'Seni_Budaya',
            'Pendidikan_Agama',
            'Pendidikan_Kewarganegaraan',
            'Penjasorkes'
        ];

        return view('report_cards.index', compact('reportCards', 'availableSubjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'semester' => 'required|string|max:255',
            'scores' => 'required|array',
            'scores.*' => 'nullable|numeric|min:0|max:100',
            'interests' => 'required|string',
            'skills' => 'required|string',
        ]);

        $processedScores = [];
        foreach ($request->scores as $subject => $value) {
            if ($value !== null && $value !== '') {
                $processedScores[$subject] = (float) $value;
            }
        }

        ReportCard::create([
            'user_id' => Auth::id(),
            'semester' => $request->semester,
            'scores' => $processedScores,
            'interests' => $request->interests,
            'skills' => $request->skills,
        ]);

        return redirect()->route('report-cards.index')->with('success', 'Nilai rapor berhasil disimpan dengan akurat!');
    }
}