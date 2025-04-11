<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TracerStudyResponse;
use Illuminate\Support\Facades\DB;
use App\Helpers\LocationHelper;
use Illuminate\Support\Facades\Cache;
use App\Models\JHSTracerResponse;
use App\Models\Juniorhighschool;

class TracerStudyController extends Controller
{
    public function __construct()
    {
        // Apply auth middleware only to admin functions and index
        $this->middleware('auth')->only(['index', 'edit', 'update', 'destroy', 'editJHS', 'updateJHS', 'destroyJHS']);
        $this->middleware(\App\Http\Middleware\AdminMiddleware::class)->only(['edit', 'update', 'destroy', 'editJHS', 'updateJHS', 'destroyJHS']);
    }

    // Organization types and occupational classifications
    protected $organizationTypes = [
        'Government',
        'Private Company',
        'Non-Profit/NGO',
        'International Organization',
        'Educational Institution',
        'Healthcare',
        'Financial Services',
        'Technology',
        'Manufacturing',
        'Retail',
        'Other'
    ];

    protected $occupationClassifications = [
        'Management' => ['Top Executive', 'Operations Manager'],
        'Professional' => ['Engineer', 'Teacher', 'Nurse/Medical', 'IT Professional'],
        'Technical' => ['Technician', 'Craftsman'],
        'Service' => ['Customer Service', 'Food Service'],
        'Other' => ['Other']
    ];

    // Suffix options
    protected $suffixOptions = [
        '' => 'None',
        'Jr.' => 'Jr.',
        'Sr.' => 'Sr.',
        'II' => 'II',
        'III' => 'III',
        'IV' => 'IV',
        'V' => 'V',
        'Other' => 'Other'
    ];

    public function showForm(Request $request)
    {
        // If graduate_type is passed directly in the request, redirect to the appropriate form
        if ($request->has('graduate_type')) {
            $graduateType = $request->input('graduate_type');
            
            if ($graduateType === 'JHS') {
                return redirect()->route('tracer.jhs-form');
            } else if ($graduateType === 'SHS') {
                return redirect()->route('tracer.shs-form');
            }
        }
        
        // Otherwise show the selection form
        return view('tracer.form');
    }

    public function submitForm(Request $request)
    {
        // Validate the graduate type field
        $request->validate([
            'graduate_type' => 'required|in:JHS,SHS',
        ]);
        
        // Get graduate type and redirect to the appropriate form
        $graduateType = $request->input('graduate_type');
        
        if ($graduateType === 'JHS') {
            return redirect()->route('tracer.jhs-form');
        } else if ($graduateType === 'SHS') {
            return redirect()->route('tracer.shs-form');
        }
        
        // If something is wrong, go back with error
                return redirect()->back()
                    ->withInput()
            ->withErrors(['error' => 'Invalid graduate type selected.']);
    }

    public function index(Request $request)
    {
        // Get the graduate type from request or default to SHS
        $type = $request->input('type', 'shs');
        
        if (strtolower($type) === 'jhs') {
            // Query JHS tracer responses
            $query = \App\Models\JHSTracerResponse::query();
            
            // Apply search filter
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('first_name', 'LIKE', "%{$search}%")
                      ->orWhere('middle_name', 'LIKE', "%{$search}%")
                      ->orWhere('last_name', 'LIKE', "%{$search}%");
                });
            }
            
            // Apply employment status filter
            if ($request->filled('employment_status')) {
                $query->where('employment_status', $request->employment_status);
            }
            
            // Calculate male and female counts
            $maleCount = JHSTracerResponse::where('gender', 'Male')->count();
            $femaleCount = JHSTracerResponse::where('gender', 'Female')->count();

            // Paginate the results
            $perPage = $request->input('perPage', 5);
            $responses = $query->paginate($perPage)->appends($request->except('page'));
            
            // Use JHS responses view
            return view('tracer.jhs-responses', [
                'responses' => $responses,
                'organizationTypes' => $this->organizationTypes,
                'occupationClassifications' => $this->occupationClassifications,
                'suffixOptions' => $this->suffixOptions,
                'type' => 'jhs',
                'maleCount' => $maleCount,
                'femaleCount' => $femaleCount
            ]);
        } else {
            // Query SHS tracer responses
            $query = TracerStudyResponse::query();

            // Apply search filter
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('first_name', 'LIKE', "%{$search}%")
                      ->orWhere('middle_name', 'LIKE', "%{$search}%")
                      ->orWhere('last_name', 'LIKE', "%{$search}%");
                });
            }

            // Apply employment status filter
            if ($request->filled('employment_status')) {
                $query->where('employment_status', $request->employment_status);
            }

            // Filter by graduate type
            $query->where('graduate_type', 'SHS');
            
            // Paginate the results
            $perPage = $request->input('perPage', 5);
            $responses = $query->paginate($perPage)->appends($request->except('page'));
            
            // Use SHS responses view
            return view('tracer.responses', [
                'responses' => $responses,
                'organizationTypes' => $this->organizationTypes,
                'occupationClassifications' => $this->occupationClassifications,
                'suffixOptions' => $this->suffixOptions,
                'type' => 'shs'
            ]);
        }
    }

    public function edit($id)
    {
        $response = TracerStudyResponse::findOrFail($id);
        
        // Generate years for the graduation year dropdown
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 10);
        
        return view('tracer.edit', [
            'response' => $response,
            'organizationTypes' => $this->organizationTypes,
            'occupationClassifications' => $this->occupationClassifications,
            'suffixOptions' => $this->suffixOptions,
            'years' => $years
        ]);
    }

    public function update(Request $request, $id)
    {
        $response = TracerStudyResponse::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'suffix_other' => 'nullable|string|max:255|required_if:suffix,Other',
            'age' => 'required|integer|min:16',
            'gender' => 'required|string',
            'birthdate' => 'required|date',
            'civil_status' => 'required|string',
            'religion' => 'required|string',
            'address' => 'nullable|string',
            'barangay' => 'required|string',
            'municipality' => 'required|string',
            'province' => 'required|string',
            'region' => 'required|string',
            'postal_code' => 'nullable|string',
            'country' => 'nullable|string',
            'year_graduated' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'employment_status' => 'required|string',
            'employer_name' => 'required_if:employment_status,Employed|nullable|string',
            'organization_type' => 'nullable|string|required_if:employment_status,Employed',
            'organization_type_other' => 'nullable|string|required_if:organization_type,Other',
            'occupational_classification' => 'nullable|string|required_if:employment_status,Employed',
            'occupational_classification_other' => 'nullable|string|required_if:occupational_classification,Other',
            'job_situation' => 'nullable|string|required_if:employment_status,Employed',
            'years_in_company' => 'nullable|string|required_if:employment_status,Employed',
            'unemployment_reason' => 'nullable|string',
            'shs_track' => 'required|string',
        ]);

        // Handle "other" values
        if ($request->filled('organization_type') && $request->organization_type === 'Other') {
            $validated['organization_type'] = $request->organization_type_other;
        }
        
        if ($request->filled('occupational_classification') && $request->occupational_classification === 'Other') {
            $validated['occupational_classification'] = $request->occupational_classification_other;
        }

        if ($request->filled('suffix') && $request->suffix === 'Other') {
            $validated['suffix'] = $request->suffix_other;
        }

        // Remove fields that are not in the database
        unset($validated['suffix_other']);
        unset($validated['organization_type_other']);
        unset($validated['occupational_classification_other']);
        
        // Convert Yes/No to boolean if they exist in the request
        if ($request->has('job_related_to_shs')) {
            $validated['job_related_to_shs'] = $request->job_related_to_shs === 'Yes';
        }
        
        if ($request->has('fuami_factor')) {
            $validated['fuami_factor'] = $request->fuami_factor === 'Yes';
        }

        try {
            $response->update($validated);
            return redirect()->route('tracer-responses.index', ['type' => 'shs'])->with('success', 'Response updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update response: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $response = TracerStudyResponse::findOrFail($id);
        $response->delete();
        
        return redirect()->route('tracer-responses.index', ['type' => 'shs'])->with('success', 'Response deleted successfully.');
    }

    public function showJHSForm()
    {
        // Helper function to get regions and provinces
        $regions = cache()->remember('regions', 60*24*7, function() {
            return LocationHelper::getRegions();
        });
        
        // Get unique years from juniorhighschool table (including Year Reference records)
        $years = Juniorhighschool::select('school_year')
            ->distinct()
            ->orderBy('school_year', 'desc')
            ->pluck('school_year')
            ->toArray();
        
        // If no years found, use current year
        if (empty($years)) {
            $currentYear = date('Y');
            $years = range($currentYear, $currentYear - 10);
        }
        
        return view('tracer.jhs-form', [
            'organizationTypes' => $this->organizationTypes,
            'occupationClassifications' => $this->occupationClassifications,
            'suffixOptions' => $this->suffixOptions,
            'regions' => $regions,
            'years' => $years,
        ]);
    }

    public function showSHSForm()
    {
        // Helper function to get regions and provinces
        $regions = cache()->remember('regions', 60*24*7, function() {
            return LocationHelper::getRegions();
        });
        
        // Get unique years from SHS tracer responses
        $years = TracerStudyResponse::where('graduate_type', 'SHS')
            ->select('year_graduated')
            ->distinct()
            ->orderBy('year_graduated', 'desc')
            ->pluck('year_graduated')
            ->toArray();
        
        // If no years found, use current year
        if (empty($years)) {
            $currentYear = date('Y');
            $years = range($currentYear, $currentYear - 10);
        }
        
        return view('tracer.shs-form', [
            'organizationTypes' => $this->organizationTypes,
            'occupationClassifications' => $this->occupationClassifications,
            'suffixOptions' => $this->suffixOptions,
            'regions' => $regions,
            'years' => $years,
        ]);
    }

    public function submitJHSForm(Request $request)
    {
        $validated = $request->validate([
            'graduate_type' => 'required|in:JHS',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'suffix_other' => 'nullable|string|max:255|required_if:suffix,Other',
            'age' => 'required|integer|min:16',
            'gender' => 'required|string',
            'birthdate' => 'required|date',
            'civil_status' => 'required|string',
            'religion' => 'required|string',
            'address' => 'nullable|string',
            'barangay' => 'required|string',
            'municipality' => 'required|string',
            'province' => 'required|string',
            'region' => 'required|string',
            'postal_code' => 'nullable|string',
            'country' => 'nullable|string',
            'year_graduated' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'employment_status' => 'required|string',
            'employer_name' => 'required_if:employment_status,Employed|nullable|string',
            'employer_address' => 'required_if:employment_status,Employed|nullable|string',
            'organization_type' => 'nullable|string|required_if:employment_status,Employed',
            'organization_type_other' => 'nullable|string|required_if:organization_type,Other',
            'occupational_classification' => 'nullable|string|required_if:employment_status,Employed',
            'occupational_classification_other' => 'nullable|string|required_if:occupational_classification,Other',
            'job_situation' => 'nullable|string|required_if:employment_status,Employed',
            'years_in_company' => 'nullable|string|required_if:employment_status,Employed',
            'unemployment_reason' => 'nullable|string',
        ]);

        // Handle "other" values
        if ($request->filled('organization_type') && $request->organization_type === 'Other') {
            $validated['organization_type'] = $request->organization_type_other;
        }
        
        if ($request->filled('occupational_classification') && $request->occupational_classification === 'Other') {
            $validated['occupational_classification'] = $request->occupational_classification_other;
        }

        if ($request->filled('suffix') && $request->suffix === 'Other') {
            $validated['suffix'] = $request->suffix_other;
        }

        // Remove fields that are not in the database
        unset($validated['suffix_other']);
        unset($validated['organization_type_other']);
        unset($validated['occupational_classification_other']);
        
        try {
            \App\Models\JHSTracerResponse::create($validated);
            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'JHS graduate data saved successfully!']);
            }
            return redirect()->back()->with('success', 'JHS graduate data saved successfully!');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'error' => 'Failed to save data: ' . $e->getMessage()], 422);
            }
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to save data: ' . $e->getMessage()]);
        }
    }

    public function submitSHSForm(Request $request)
    {
        $validated = $request->validate([
            'graduate_type' => 'required|in:SHS',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'suffix_other' => 'nullable|string|max:255|required_if:suffix,Other',
            'age' => 'required|integer|min:16',
            'gender' => 'required|string',
            'birthdate' => 'required|date',
            'civil_status' => 'required|string',
            'religion' => 'required|string',
            'address' => 'nullable|string',
            'barangay' => 'required|string',
            'municipality' => 'required|string',
            'province' => 'required|string',
            'region' => 'required|string',
            'postal_code' => 'nullable|string',
            'country' => 'nullable|string',
            'year_graduated' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'employment_status' => 'required|string',
            'employer_name' => 'required_if:employment_status,Employed|nullable|string',
            'employer_address' => 'required_if:employment_status,Employed|nullable|string',
            'organization_type' => 'nullable|string|required_if:employment_status,Employed',
            'organization_type_other' => 'nullable|string|required_if:organization_type,Other',
            'occupational_classification' => 'nullable|string|required_if:employment_status,Employed',
            'occupational_classification_other' => 'nullable|string|required_if:occupational_classification,Other',
            'job_situation' => 'nullable|string|required_if:employment_status,Employed',
            'years_in_company' => 'nullable|string|required_if:employment_status,Employed',
            'unemployment_reason' => 'nullable|string',
            'shs_track' => 'required|string',
            'job_related_to_shs' => 'nullable|string|in:Yes,No',
            'fuami_factor' => 'nullable|string|in:Yes,No',
        ]);

        // Handle "other" values
        if ($request->filled('organization_type') && $request->organization_type === 'Other') {
            $validated['organization_type'] = $request->organization_type_other;
        }
        
        if ($request->filled('occupational_classification') && $request->occupational_classification === 'Other') {
            $validated['occupational_classification'] = $request->occupational_classification_other;
        }

        if ($request->filled('suffix') && $request->suffix === 'Other') {
            $validated['suffix'] = $request->suffix_other;
        }

        // Remove fields that are not in the database
        unset($validated['suffix_other']);
        unset($validated['organization_type_other']);
        unset($validated['occupational_classification_other']);
        
        // Convert Yes/No to boolean
        if ($request->has('job_related_to_shs')) {
            $validated['job_related_to_shs'] = $request->job_related_to_shs === 'Yes';
        }
        
        if ($request->has('fuami_factor')) {
            $validated['fuami_factor'] = $request->fuami_factor === 'Yes';
        }

        try {
            TracerStudyResponse::create($validated);
            return redirect()->back()->with('success', 'SHS graduate data saved successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to save data: ' . $e->getMessage()]);
        }
    }

    public function editJHS($id)
    {
        $response = \App\Models\JHSTracerResponse::findOrFail($id);
        
        // Helper function to get regions and provinces
        $regions = cache()->remember('regions', 60*24*7, function() {
            return LocationHelper::getRegions();
        });

        // Generate years for the graduation year dropdown
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear - 10);

        return view('tracer.jhs-edit', [
            'response' => $response,
            'organizationTypes' => $this->organizationTypes,
            'occupationClassifications' => $this->occupationClassifications,
            'suffixOptions' => $this->suffixOptions,
            'regions' => $regions,
            'years' => $years
        ]);
    }

    public function updateJHS(Request $request, $id)
    {
        $response = \App\Models\JHSTracerResponse::findOrFail($id);
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'suffix_other' => 'nullable|string|max:255|required_if:suffix,Other',
            'age' => 'required|integer|min:16',
            'gender' => 'required|string',
            'birthdate' => 'required|date',
            'civil_status' => 'required|string',
            'religion' => 'required|string',
            'address' => 'nullable|string',
            'barangay' => 'required|string',
            'municipality' => 'required|string',
            'province' => 'required|string',
            'region' => 'required|string',
            'postal_code' => 'nullable|string',
            'country' => 'nullable|string',
            'year_graduated' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'employment_status' => 'required|string',
            'employer_name' => 'required_if:employment_status,Employed|nullable|string',
            'organization_type' => 'nullable|string|required_if:employment_status,Employed',
            'organization_type_other' => 'nullable|string|required_if:organization_type,Other',
            'occupational_classification' => 'nullable|string|required_if:employment_status,Employed',
            'occupational_classification_other' => 'nullable|string|required_if:occupational_classification,Other',
            'job_situation' => 'nullable|string|required_if:employment_status,Employed',
            'years_in_company' => 'nullable|string|required_if:employment_status,Employed',
            'unemployment_reason' => 'nullable|string',
        ]);

        // Handle "other" values
        if ($request->filled('organization_type') && $request->organization_type === 'Other') {
            $validated['organization_type'] = $request->organization_type_other;
        }
        
        if ($request->filled('occupational_classification') && $request->occupational_classification === 'Other') {
            $validated['occupational_classification'] = $request->occupational_classification_other;
        }

        if ($request->filled('suffix') && $request->suffix === 'Other') {
            $validated['suffix'] = $request->suffix_other;
        }

        // Remove fields that are not in the database
        unset($validated['suffix_other']);
        unset($validated['organization_type_other']);
        unset($validated['occupational_classification_other']);

        try {
            $response->update($validated);
            return redirect()->route('tracer-responses.index', ['type' => 'jhs'])->with('success', 'Response updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update response: ' . $e->getMessage()]);
        }
    }

    public function destroyJHS($id)
    {
        $response = \App\Models\JHSTracerResponse::findOrFail($id);
        $response->delete();
        
        return redirect()->route('tracer-responses.index', ['type' => 'jhs'])->with('success', 'Response deleted successfully.');
    }

    public function handleLocations()
    {
        $path = storage_path('app/locations');
        
        if (!file_exists($path)) {
            Log::error("Directory missing: ".$path);
            mkdir($path, 0755, true); // Creates if missing
        }

        // Your business logic here
        $files = scandir($path);
        return view('tracer.responses', ['files' => $files]);
    }
}