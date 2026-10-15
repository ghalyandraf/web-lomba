<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Major;
use App\Services\MajorRecommendationService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(
        Request $request,
        MajorRecommendationService $recommendationService
    ) {
        $user = Auth::user();

        $latestReportCard = $user->reportCards()->latest()->first();

        $latestAnalysis = $user->analysisResults()
            ->with('major')
            ->latest()
            ->first();

        $majors = Major::all();

        $selectedMajor = $user->major()->first();

        if (!$selectedMajor && $request->filled('major_id')) {
            $selectedMajor = Major::find($request->integer('major_id'));
        }

        $selectedMajorMatchScore = null;

        if ($latestReportCard && $selectedMajor) {
            $recommendations = $recommendationService->recommend(
                $latestReportCard
            );

            $selectedRecommendation = $recommendations->firstWhere(
                'id',
                $selectedMajor->id
            );

            if ($selectedRecommendation) {
                $selectedMajorMatchScore =
                    $selectedRecommendation->match_score;
            }
        }

        return view('dashboard.index', compact(
            'user',
            'latestReportCard',
            'latestAnalysis',
            'majors',
            'selectedMajor',
            'selectedMajorMatchScore'
        ));
    }
}
