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
     * Generic professional report that can be filtered by graduate type
     */
    public function professionalReport(Request $request)
    {
        $graduateType = $request->input('graduate_type', 'SHS');
        $year = $request->input('year', null);
        $gender = $request->input('gender', null);
        
        if ($graduateType === 'JHS') {
            $model = JHSTracerResponse::class;
            $years = JHSTracerResponse::distinct()
                ->orderBy('year_graduated', 'desc')
                ->pluck('year_graduated');
        } else {
            $model = TracerStudyResponse::class;
            $years = TracerStudyResponse::where('graduate_type', 'SHS')
                ->distinct()
                ->orderBy('year_graduated', 'desc')
                ->pluck('year_graduated');
        }
        
        // Base query for profession counts
        $professionQuery = $model::where('employment_status', 'Employed')
            ->whereNotNull('occupational_classification');
            
        // Base query for alumni list
        $alumniQuery = $model::where('employment_status', 'Employed')
            ->whereNotNull('occupational_classification')
            ->select('id', 'first_name', 'middle_name', 'last_name', 'suffix', 'occupational_classification', 'year_graduated', 'gender');
        
        // Apply filters
        if ($year) {
            $professionQuery->where('year_graduated', $year);
            $alumniQuery->where('year_graduated', $year);
        }
        
        if ($gender) {
            $professionQuery->where('gender', $gender);
            $alumniQuery->where('gender', $gender);
        }
        
        // Get profession data with counts
        $professionData = $professionQuery->select('occupational_classification', DB::raw('count(*) as total'))
            ->groupBy('occupational_classification')
            ->orderByDesc('total')
            ->get();
        
        // Get all alumni data for the modal
        $allAlumni = $alumniQuery->get();
        
        return view('reports.profession', [
            'professionData' => $professionData,
            'allAlumni' => $allAlumni,
            'years' => $years,
            'selectedYear' => $year,
            'selectedGender' => $gender,
            'graduateType' => $graduateType,
            'totalGraduates' => $professionData->sum('total')
        ]);
    }
}