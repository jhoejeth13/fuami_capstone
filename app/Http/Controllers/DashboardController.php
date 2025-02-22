<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Graduate;
use App\Models\TracerStudyResponse;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get the selected year for graduates from the request (default to 'all' if not provided)
        $selectedGraduateYear = $request->input('graduate_year', 'all');

        // Get the selected year for employment data from the request (default to 'all' if not provided)
        $selectedEmploymentYear = $request->input('employment_year', 'all');

        // Fetch the total number of graduates (filtered by selected year or all)
        $totalGraduatesQuery = Graduate::query();
        if ($selectedGraduateYear !== 'all') {
            $totalGraduatesQuery->where('year_graduated', $selectedGraduateYear);
        }
        $totalGraduates = $totalGraduatesQuery->count();

        // Fetch the number of male and female graduates (filtered by selected year or all)
        $maleGraduatesQuery = Graduate::where('gender', 'male');
        $femaleGraduatesQuery = Graduate::where('gender', 'female');
        if ($selectedGraduateYear !== 'all') {
            $maleGraduatesQuery->where('year_graduated', $selectedGraduateYear);
            $femaleGraduatesQuery->where('year_graduated', $selectedGraduateYear);
        }
        $maleGraduates = $maleGraduatesQuery->count();
        $femaleGraduates = $femaleGraduatesQuery->count();

        // Fetch employment status counts (filtered by selected year or all)
        $employedQuery = TracerStudyResponse::where('employment_status', 'employed');
        $selfEmployedQuery = TracerStudyResponse::where('employment_status', 'self-employed');
        $unemployedQuery = TracerStudyResponse::where('employment_status', 'unemployed');
        if ($selectedEmploymentYear !== 'all') {
            $employedQuery->where('year_graduated', $selectedEmploymentYear);
            $selfEmployedQuery->where('year_graduated', $selectedEmploymentYear);
            $unemployedQuery->where('year_graduated', $selectedEmploymentYear);
        }
        $employed = $employedQuery->count();
        $selfEmployed = $selfEmployedQuery->count();
        $unemployed = $unemployedQuery->count();

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

        // Get a list of available years for the graduate dropdown filter
        $availableGraduateYears = Graduate::select('year_graduated')
            ->distinct()
            ->orderBy('year_graduated', 'desc')
            ->pluck('year_graduated');

        // Get a list of available years for the employment dropdown filter
        $availableEmploymentYears = TracerStudyResponse::select('year_graduated')
            ->distinct()
            ->orderBy('year_graduated', 'desc')
            ->pluck('year_graduated');

        // Prepare data for charts
        $genderData = [
            'male' => $maleGraduates,
            'female' => $femaleGraduates,
        ];

        $employmentData = [
            'employed' => $employed,
            'self_employed' => $selfEmployed,
            'unemployed' => $unemployed,
        ];

        return view('dashboard', compact(
            'totalGraduates',
            'genderData',
            'employmentData',
            'lastUpdated',
            'selectedGraduateYear',
            'selectedEmploymentYear',
            'availableGraduateYears',
            'availableEmploymentYears'
        ));
    }
}