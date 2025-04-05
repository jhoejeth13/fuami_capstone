<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Graduate;
use App\Models\TracerStudyResponse;
use App\Models\Juniorhighschool;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get the selected filter type (default to 'both')
        $selectedFilterType = $request->input('filter_type', 'both');

        // Get the selected year for graduates from the request (default to 'all' if not provided)
        $selectedGraduateYear = $request->input('graduate_year', 'all');

        // Get the selected year for employment data from the request (default to 'all' if not provided)
        $selectedEmploymentYear = $request->input('employment_year', 'all');

        // Fetch JHS students total and gender data
        $totalJHSStudentsQuery = Juniorhighschool::query();
        if ($selectedGraduateYear !== 'all') {
            $totalJHSStudentsQuery->where('school_year', $selectedGraduateYear);
        }
        $totalJHSStudents = $totalJHSStudentsQuery->count();

        // Fetch JHS gender data
        $maleJHSStudentsQuery = Juniorhighschool::where('gender', 'Male');
        $femaleJHSStudentsQuery = Juniorhighschool::where('gender', 'Female');
        if ($selectedGraduateYear !== 'all') {
            $maleJHSStudentsQuery->where('school_year', $selectedGraduateYear);
            $femaleJHSStudentsQuery->where('school_year', $selectedGraduateYear);
        }
        $maleJHSStudents = $maleJHSStudentsQuery->count();
        $femaleJHSStudents = $femaleJHSStudentsQuery->count();

        // Fetch the total number of graduates (filtered by selected year or all)
        $totalGraduatesQuery = Graduate::query();
        if ($selectedGraduateYear !== 'all') {
            $totalGraduatesQuery->where('year_graduated', $selectedGraduateYear);
        }
        $totalGraduates = $totalGraduatesQuery->count();

        // Fetch the number of male and female graduates (filtered by selected year or all)
        $maleGraduatesQuery = Graduate::where('gender', 'Male');
        $femaleGraduatesQuery = Graduate::where('gender', 'Female');
        if ($selectedGraduateYear !== 'all') {
            $maleGraduatesQuery->where('year_graduated', $selectedGraduateYear);
            $femaleGraduatesQuery->where('year_graduated', $selectedGraduateYear);
        }
        $maleGraduates = $maleGraduatesQuery->count();
        $femaleGraduates = $femaleGraduatesQuery->count();

        // Fetch employment status counts (filtered by selected year or all)
        $employedQuery = TracerStudyResponse::where('employment_status', 'Employed');
        $selfEmployedQuery = TracerStudyResponse::where('employment_status', 'Self-employed');
        $unemployedQuery = TracerStudyResponse::where('employment_status', 'Unemployed');
        if ($selectedEmploymentYear !== 'all') {
            $employedQuery->where('year_graduated', $selectedEmploymentYear);
            $selfEmployedQuery->where('year_graduated', $selectedEmploymentYear);
            $unemployedQuery->where('year_graduated', $selectedEmploymentYear);
        }
        $employed = $employedQuery->count();
        $selfEmployed = $selfEmployedQuery->count();
        $unemployed = $unemployedQuery->count();

        // Calculate total employed (employed + self-employed)
        $totalEmployed = $employed + $selfEmployed;

        // Fetch total alumni based on year_graduated in tracer_study_responses
        $totalAlumniQuery = TracerStudyResponse::query();
        if ($selectedEmploymentYear !== 'all') {
            $totalAlumniQuery->where('year_graduated', $selectedEmploymentYear);
        }
        $totalAlumni = $totalAlumniQuery->count();

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

        // Get a list of available years for the graduate dropdown filter (combine from both JHS and SHS)
        $shsYears = Graduate::select('year_graduated')
            ->distinct()
            ->orderBy('year_graduated', 'desc')
            ->pluck('year_graduated');
            
        $jhsYears = Juniorhighschool::select('school_year')
            ->distinct()
            ->orderBy('school_year', 'desc')
            ->pluck('school_year');
            
        $availableGraduateYears = collect($shsYears)->merge($jhsYears)->unique()->sort()->values();

        // Get a list of available years for the employment dropdown filter
        $availableEmploymentYears = TracerStudyResponse::select('year_graduated')
            ->distinct()
            ->orderBy('year_graduated', 'desc')
            ->pluck('year_graduated');

        // Prepare data for charts
        $genderData = [
            'Male' => $maleGraduates,
            'Female' => $femaleGraduates,
        ];
        
        $jhsGenderData = [
            'Male' => $maleJHSStudents,
            'Female' => $femaleJHSStudents,
        ];

        $employmentData = [
            'Employed' => $employed,
            'Self Employed' => $selfEmployed,
            'Unemployed' => $unemployed,
        ];

        return view('dashboard', compact(
            'totalGraduates',
            'totalJHSStudents',
            'totalEmployed',
            'totalAlumni',
            'genderData',
            'jhsGenderData',
            'employmentData',
            'lastUpdated',
            'selectedGraduateYear',
            'selectedEmploymentYear',
            'selectedFilterType',
            'availableGraduateYears',
            'availableEmploymentYears'
        ));
    }
    
}