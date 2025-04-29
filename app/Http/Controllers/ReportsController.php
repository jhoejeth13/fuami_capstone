<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TracerStudyResponse;
use App\Models\JHSTracerResponse;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(\App\Http\Middleware\AdminMiddleware::class);
    }

    /**
     * Show the main reports page with options.
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Generate profession-based reports for SHS graduates
     */
    public function professionReportSHS(Request $request)
    {
        // Get filters
        $year = $request->input('year', null);
        $gender = $request->input('gender', null);
        
        // Base query
        $query = TracerStudyResponse::where('employment_status', 'Employed')
            ->where('graduate_type', 'SHS')
            ->whereNotNull('occupational_classification');
        
        // Apply filters
        if ($year) {
            $query->where('year_graduated', $year);
        }
        
        if ($gender) {
            $query->where('gender', $gender);
        }
        
        // Group by occupational classification and count
        $professionData = $query->select('occupational_classification', DB::raw('count(*) as total'))
            ->groupBy('occupational_classification')
            ->orderByDesc('total')
            ->get();
        
        // Get years for filter dropdown
        $years = TracerStudyResponse::where('graduate_type', 'SHS')
            ->distinct()
            ->orderBy('year_graduated', 'desc')
            ->pluck('year_graduated');
            
        return view('reports.profession', [
            'professionData' => $professionData,
            'years' => $years,
            'selectedYear' => $year,
            'selectedGender' => $gender,
            'graduateType' => 'SHS',
            'totalGraduates' => $professionData->sum('total')
        ]);
    }
    
    /**
     * Generate profession-based reports for JHS graduates
     */
    public function professionReportJHS(Request $request)
    {
        // Get filters
        $year = $request->input('year', null);
        $gender = $request->input('gender', null);
        
        // Base query
        $query = JHSTracerResponse::where('employment_status', 'Employed')
            ->whereNotNull('occupational_classification');
        
        // Apply filters
        if ($year) {
            $query->where('year_graduated', $year);
        }
        
        if ($gender) {
            $query->where('gender', $gender);
        }
        
        // Group by occupational classification and count
        $professionData = $query->select('occupational_classification', DB::raw('count(*) as total'))
            ->groupBy('occupational_classification')
            ->orderByDesc('total')
            ->get();
        
        // Get years for filter dropdown
        $years = JHSTracerResponse::distinct()
            ->orderBy('year_graduated', 'desc')
            ->pluck('year_graduated');
            
        return view('reports.profession', [
            'professionData' => $professionData,
            'years' => $years,
            'selectedYear' => $year,
            'selectedGender' => $gender,
            'graduateType' => 'JHS',
            'totalGraduates' => $professionData->sum('total')
        ]);
    }
    
    /**
     * Generic professional report that can be filtered by graduate type
     */
    public function professionalReport(Request $request)
    {
        $graduateType = $request->input('graduate_type', 'SHS');
        
        if ($graduateType === 'JHS') {
            return $this->professionReportJHS($request);
        } else {
            return $this->professionReportSHS($request);
        }
    }
} 