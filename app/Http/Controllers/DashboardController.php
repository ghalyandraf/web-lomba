<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportCard;
use App\Models\AnalysisResult;
use App\Models\Major;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $latestReportCard = $user->reportCards()->latest()->first();
        $latestAnalysis = $user->analysisResults()->with('major')->latest()->first();
        $majors = Major::all();

        return view('dashboard.index', compact('user', 'latestReportCard', 'latestAnalysis', 'majors'));
    }
}