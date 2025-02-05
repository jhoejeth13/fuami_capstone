<?php

namespace App\Http\Controllers;

use App\Models\Graduate;
use App\Models\TracerStudyResponse;

class DashboardController extends Controller
{
    public function index()
    {
        $totalGraduates = Graduate::count();
        $employed = TracerStudyResponse::where('employment_status', 'employed')->count();
        $selfEmployed = TracerStudyResponse::where('employment_status', 'self-employed')->count();
        $unemployed = TracerStudyResponse::where('employment_status', 'unemployed')->count();

        return view('dashboard', compact(
            'totalGraduates',
            'employed',
            'selfEmployed',
            'unemployed'
        ));
    }
}