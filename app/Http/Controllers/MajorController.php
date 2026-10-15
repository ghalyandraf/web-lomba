<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    public function index(Request $request)
    {
        $majors = Major::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = $request->query('q');

                $query->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%")
                      ->orWhere('field', 'like', "%{$keyword}%");
                });
            })
            ->orderBy('name')
            ->get();

        return view('majors.index', compact('majors'));
    }
}