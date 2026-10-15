<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Major;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $latestReportCard = $user->reportCards()->latest()->first();

        $latestAnalysis = $user->analysisResults()
            ->with('major')
            ->latest()
            ->first();

        $majors = Major::all();

        $selectedMajor = null;

        if ($request->filled('major_id')) {
            $selectedMajor = Major::find($request->integer('major_id'));
        }

        return view('dashboard.index', compact(
            'user',
            'latestReportCard',
            'latestAnalysis',
            'majors',
            'selectedMajor'
        ));
    }
}
