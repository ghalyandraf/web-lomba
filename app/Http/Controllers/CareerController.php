<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CareerPlan;
use Illuminate\Support\Facades\Auth;

class CareerController extends Controller
{
    public function index()
    {
        $careerPlans = Auth::user()->careerPlans()->latest()->get();
        return view('career.index', compact('careerPlans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'target_career' => 'required|string|max:255',
            'education_path' => 'required|string|max:255',
            'short_term_goals' => 'required|string',
            'medium_term_goals' => 'required|string',
            'long_term_goals' => 'required|string',
            'progress_percentage' => 'required|integer|min:0|max:100',
        ]);

        CareerPlan::create([
            'user_id' => Auth::id(),
            'target_career' => $request->target_career,
            'education_path' => $request->education_path,
            'short_term_goals' => $request->short_term_goals,
            'medium_term_goals' => $request->medium_term_goals,
            'long_term_goals' => $request->long_term_goals,
            'progress_percentage' => $request->progress_percentage,
        ]);

        return redirect()->route('career.index')->with('success', 'Rencana karier berhasil disimpan!');
    }
}