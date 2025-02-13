<?php

namespace App\Http\Controllers;

use App\Models\Graduate;
use App\Models\TracerStudyResponse;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch the total number of graduates
        $totalGraduates = Graduate::count();

        // Fetch employment status counts from TracerStudyResponse
        $employed = TracerStudyResponse::where('employment_status', 'employed')->count();
        $selfEmployed = TracerStudyResponse::where('employment_status', 'self-employed')->count();
        $unemployed = TracerStudyResponse::where('employment_status', 'unemployed')->count();

        // Fetch the latest created_at timestamp from both tables
        $lastAddedGraduate = Graduate::latest('created_at')->value('created_at');
        $lastAddedTracer = TracerStudyResponse::latest('created_at')->value('created_at');

        // Determine the most recent timestamp between the two tables
        if ($lastAddedGraduate && $lastAddedTracer) {
            $lastUpdated = $lastAddedGraduate->gt($lastAddedTracer) ? $lastAddedGraduate : $lastAddedTracer;
        } elseif ($lastAddedGraduate) {
            $lastUpdated = $lastAddedGraduate;
        } elseif ($lastAddedTracer) {
            $lastUpdated = $lastAddedTracer;
        } else {
            $lastUpdated = now(); // Fallback if both tables are empty
        }

        return view('dashboard', compact(
            'totalGraduates',
            'employed',
            'selfEmployed',
            'unemployed',
            'lastUpdated' // Pass the last updated timestamp to the view
        ));
    }
}