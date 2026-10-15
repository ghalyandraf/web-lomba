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
        $validated = $request->validate([
            'target_career'       => 'required|string|max:255',
            'education_path'      => 'required|string|max:255',
            'short_term_goals'    => 'required|string',
            'medium_term_goals'   => 'required|string',
            'long_term_goals'     => 'required|string',
            'progress_percentage' => 'nullable|integer|min:0|max:100', // sebelumnya required
        ]);

        CareerPlan::create([
            'user_id'             => Auth::id(),
            'target_career'       => $validated['target_career'],
            'education_path'      => $validated['education_path'],
            'short_term_goals'    => $validated['short_term_goals'],
            'medium_term_goals'   => $validated['medium_term_goals'],
            'long_term_goals'     => $validated['long_term_goals'],
            'progress_percentage' => $validated['progress_percentage'] ?? 0,
        ]);

        return redirect()->route('career.index')->with('success', 'Rencana karier berhasil disimpan!');
    }
}