<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Graduate;
use App\Models\TracerStudyResponse;
use App\Models\Juniorhighschool;
use App\Models\JHSTracerResponse;
use Illuminate\Support\Facades\DB;

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
        $unemployedQuery = TracerStudyResponse::where('employment_status', 'Unemployed');
        if ($selectedEmploymentYear !== 'all') {
            $employedQuery->where('year_graduated', $selectedEmploymentYear);
            $unemployedQuery->where('year_graduated', $selectedEmploymentYear);
        }
        $employed = $employedQuery->count();
        $unemployed = $unemployedQuery->count();

        // Fetch JHS employment status counts
        $jhsEmployedQuery = JHSTracerResponse::where('employment_status', 'Employed');
        $jhsUnemployedQuery = JHSTracerResponse::where('employment_status', 'Unemployed');
        if ($selectedEmploymentYear !== 'all') {
            $jhsEmployedQuery->where('year_graduated', $selectedEmploymentYear);
            $jhsUnemployedQuery->where('year_graduated', $selectedEmploymentYear);
        }
        $jhsEmployed = $jhsEmployedQuery->count();
        $jhsUnemployed = $jhsUnemployedQuery->count();

        // Calculate total JHS alumni
        $totalJHSAlumniQuery = JHSTracerResponse::query();
        if ($selectedEmploymentYear !== 'all') {
            $totalJHSAlumniQuery->where('year_graduated', $selectedEmploymentYear);
        }
        $totalJHSAlumni = $totalJHSAlumniQuery->count();

        // Calculate total employed (employed)
        $totalEmployed = $employed;

        // Fetch total alumni based on year_graduated in tracer_study_responses
        $totalAlumniQuery = TracerStudyResponse::query();
        if ($selectedEmploymentYear !== 'all') {
            $totalAlumniQuery->where('year_graduated', $selectedEmploymentYear);
        }
        $totalAlumni = $totalAlumniQuery->count();

        // Fetch profession data for SHS graduates
        $shsProfessionQuery = TracerStudyResponse::where('employment_status', 'Employed')
            ->whereNotNull('occupational_classification')
            ->where('graduate_type', 'SHS');
            
        if ($selectedEmploymentYear !== 'all') {
            $shsProfessionQuery->where('year_graduated', $selectedEmploymentYear);
        }
        
        $shsProfessionData = $shsProfessionQuery
            ->select('occupational_classification', DB::raw('count(*) as total'))
            ->groupBy('occupational_classification')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
            
        // Fetch profession data for JHS graduates
        $jhsProfessionQuery = JHSTracerResponse::where('employment_status', 'Employed')
            ->whereNotNull('occupational_classification');
            
        if ($selectedEmploymentYear !== 'all') {
            $jhsProfessionQuery->where('year_graduated', $selectedEmploymentYear);
        }
        
        $jhsProfessionData = $jhsProfessionQuery
            ->select('occupational_classification', DB::raw('count(*) as total'))
            ->groupBy('occupational_classification')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        
        // Combined profession data for both JHS and SHS
        $combinedProfessionData = collect();
        
        // Process SHS data
        foreach ($shsProfessionData as $profession) {
            $existing = $combinedProfessionData->firstWhere('occupation', $profession->occupational_classification);
            if ($existing) {
                $existing['total'] += $profession->total;
                $existing['shs'] = $profession->total;
            } else {
                $combinedProfessionData->push([
                    'occupation' => $profession->occupational_classification,
                    'total' => $profession->total,
                    'shs' => $profession->total,
                    'jhs' => 0
                ]);
            }
        }
        
        // Process JHS data
        foreach ($jhsProfessionData as $profession) {
            $existing = $combinedProfessionData->firstWhere('occupation', $profession->occupational_classification);
            if ($existing) {
                $existing['total'] += $profession->total;
                $existing['jhs'] = $profession->total;
            } else {
                $combinedProfessionData->push([
                    'occupation' => $profession->occupational_classification,
                    'total' => $profession->total,
                    'jhs' => $profession->total,
                    'shs' => 0
                ]);
            }
        }
        
        // Sort by total and limit to top 5
        $combinedProfessionData = $combinedProfessionData->sortByDesc('total')->take(5)->values();

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
            'Unemployed' => $unemployed,
        ];
        
        $jhsEmploymentData = [
            'Employed' => $jhsEmployed,
            'Unemployed' => $jhsUnemployed,
        ];

        return view('dashboard', [
            'totalGraduates' => $totalGraduates,
            'totalJHSStudents' => $totalJHSStudents,
            'totalEmployed' => $totalEmployed,
            'totalAlumni' => $totalAlumni,
            'totalJHSAlumni' => $totalJHSAlumni,
            'genderData' => $genderData,
            'jhsGenderData' => $jhsGenderData,
            'employmentData' => $employmentData,
            'jhsEmploymentData' => $jhsEmploymentData,
            'lastUpdated' => $lastUpdated,
            'selectedGraduateYear' => $selectedGraduateYear,
            'selectedEmploymentYear' => $selectedEmploymentYear,
            'selectedFilterType' => $selectedFilterType,
            'availableGraduateYears' => $availableGraduateYears,
            'availableEmploymentYears' => $availableEmploymentYears,
            'maleGraduates' => $maleGraduates,
            'femaleGraduates' => $femaleGraduates,
            'maleJHSStudents' => $maleJHSStudents,
            'femaleJHSStudents' => $femaleJHSStudents,
            'shsMaleCount' => $maleGraduates,
            'shsFemaleCount' => $femaleGraduates,
            'jhsMaleCount' => $maleJHSStudents,
            'jhsFemaleCount' => $femaleJHSStudents,
            'shsProfessionData' => $shsProfessionData,
            'jhsProfessionData' => $jhsProfessionData,
            'combinedProfessionData' => $combinedProfessionData
        ]);
    }
}