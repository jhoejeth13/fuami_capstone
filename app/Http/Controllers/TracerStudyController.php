<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TracerStudyResponse;
use Illuminate\Support\Facades\DB;
use App\Helpers\LocationHelper;
use Illuminate\Support\Facades\Cache;

class TracerStudyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(\App\Http\Middleware\AdminMiddleware::class)->only(['edit', 'update', 'destroy']);
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
        'Other' => ['Others (please specify)']
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

    public function showForm()
    {
        // Fetch unique graduation years from the database
        $years = DB::table('years')->pluck('year')->sort();

        // Get regions with caching (simplified without error logging)
        $regions = Cache::remember('regions_data', 3600, function () {
            return LocationHelper::getRegions() ?? [];
        });

        // Pass the years and dropdown options to the view
        return view('tracer.tracer-study-form', [
            'years' => $years,
            'organizationTypes' => $this->organizationTypes,
            'occupationClassifications' => $this->occupationClassifications,
            'suffixOptions' => $this->suffixOptions,
            'regions' => $regions,
        ]);
    }

    public function submitForm(Request $request)
    {
        // Common validation rules for both JHS and SHS
        $rules = [
            'graduate_type' => 'required|in:JHS,SHS',
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
            'organization_type' => 'nullable|string',
            'organization_type_other' => 'nullable|string|required_if:organization_type,Other',
            'occupational_classification' => 'nullable|string',
            'occupational_classification_other' => 'nullable|string|required_if:occupational_classification,Other',
            'employer_name' => 'nullable|string',
            'employment_type' => 'nullable|string',
            'work_location' => 'nullable|string',
            'job_situation' => 'nullable|string',
            'years_in_company' => 'nullable|string',
            'monthly_income' => 'nullable|integer',
            'reason_staying_job' => 'nullable|string',
            'nature_of_employment' => 'nullable|string',
            'company_name' => 'nullable|string',
            'years_in_business' => 'nullable|string',
            'self_employed_income' => 'nullable|integer',
            'unemployment_reason' => 'nullable|string',
        ];
        
        // Add SHS-specific validation only if graduate_type is SHS
        if ($request->input('graduate_type') === 'SHS') {
            $rules['shs_track'] = 'required|string';
        }

        $validated = $request->validate($rules);

        // Handle "other" values
        if ($request->organization_type === 'Other') {
            $validated['organization_type'] = $request->organization_type_other;
        }
        
        if ($request->occupational_classification === 'Other') {
            $validated['occupational_classification'] = $request->occupational_classification_other;
        }

        if ($request->suffix === 'Other') {
            $validated['suffix'] = $request->suffix_other;
        }

        // Convert Yes/No to boolean if they exist in the request
        if ($request->has('job_related_to_shs')) {
            $validated['job_related_to_shs'] = $request->job_related_to_shs === 'Yes';
        }
        
        if ($request->has('fuami_factor')) {
            $validated['fuami_factor'] = $request->fuami_factor === 'Yes';
        }

        try {
            TracerStudyResponse::create($validated);
            return redirect()->back()->with('success', 'Data saved successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to save data: ' . $e->getMessage()]);
        }
    }

    public function index(Request $request)
    {
        $query = TracerStudyResponse::query();

        // Apply filters
        if ($request->filled('employment_status')) {
            $query->where('employment_status', $request->employment_status);
        }
        
        // Filter by graduate type, default to SHS if not specified
        $graduateType = $request->input('graduate_type', 'SHS');
        $query->where('graduate_type', $graduateType);

        $perPage = $request->input('perPage', 5); // Default to 5 items per page
        $responses = $query->paginate($perPage)->appends($request->except('page'));

        // Determine which view to use based on graduate type
        $view = $graduateType === 'JHS' ? 'tracer.jhs-responses' : 'tracer.responses';

        return view($view, [
            'responses' => $responses,
            'organizationTypes' => $this->organizationTypes,
            'occupationClassifications' => $this->occupationClassifications,
            'suffixOptions' => $this->suffixOptions,
            'graduateType' => $graduateType
        ]);
    }

    public function rules()
    {
        $rules = [
            'employment_status' => 'required|in:Employed,Unemployed',
            'unemployment_reason' => 'nullable',
        ];

        if ($this->input('employment_status') === 'Employed') {
            $rules += [
                'employer_name' => 'nullable',
                'organization_type' => 'nullable',
                'occupational_classification' => 'nullable',
                'job_situation' => 'nullable',
                'years_in_company' => 'nullable'
            ];
        }

        return $rules;
    }

    public function edit($id)
    {
        $response = TracerStudyResponse::findOrFail($id);
        $years = DB::table('years')->pluck('year')->sort();
        
        return view('tracer.edit', [
            'response' => $response,
            'years' => $years,
            'organizationTypes' => $this->organizationTypes,
            'occupationClassifications' => $this->occupationClassifications,
            'suffixOptions' => $this->suffixOptions,
        ]);
    }

    public function update(Request $request, $id)
    {
        $response = TracerStudyResponse::findOrFail($id);

        $rules = [
            // Personal Information
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'age' => 'required|integer|min:1',
            'gender' => 'required|string|in:Male,Female',
            'birthdate' => 'required|date',
            'civil_status' => 'required|string|in:Single,Married,Widowed,Separated',
            'religion' => 'required|string|max:255',
            'religion_other' => 'nullable|string|max:255|required_if:religion,Others',
            'address' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            
            // Education Information
            'shs_track' => 'required|string|in:Academic,Technical-Vocational-Livelihood',
            'year_graduated' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            
            // Contact Information
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            
            // Employment Information
            'employment_status' => 'required|string|in:Employed,Unemployed',
        ];

        // Add conditional rules based on employment status
        if ($request->employment_status === 'Employed') {
            $rules['employer_name'] = 'required|string|max:255';
            $rules['organization_type'] = 'required|string|max:255';
            $rules['occupational_classification'] = 'required|string|max:255';
            $rules['job_situation'] = 'required|string|in:Regular,Contractual,Probationary,Project-based,Permanent,Part-time';
            $rules['years_in_company'] = 'required|string|max:255';
            
            // If organization type is "Others (please specify)", require the other field
            if ($request->organization_type === 'Others (please specify)') {
                $rules['organization_type_other'] = 'required|string|max:255';
            }
            
            // If occupational classification is "Other", require the other field
            if ($request->occupational_classification === 'Others (please specify)') {
                $rules['occupational_classification_other'] = 'required|string|max:255';
            }
        } else {
            $rules['unemployment_reason'] = 'required|string|max:255';
        }

        // Validate the request data
        $validated = $request->validate($rules);

        // Handle the "Others" value for religion
        if ($request->religion === 'Others') {
            $validated['religion'] = $request->religion_other;
        }

        // Handle other "Others" values like organization_type, etc.
        if ($request->organization_type === 'Others (please specify)') {
            $validated['organization_type'] = $request->organization_type_other;
        }
        
        if ($request->occupational_classification === 'Others (please specify)') {
            $validated['occupational_classification'] = $request->occupational_classification_other;
        }

        // Remove the fields that are not in the database table
        unset($validated['religion_other']);
        unset($validated['organization_type_other']);
        unset($validated['occupational_classification_other']);

        try {
            $response->update($validated);
            return redirect()->route('tracer-responses.index')
                ->with('success', 'Updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('tracer-responses.index')
                ->withErrors(['error' => 'Failed to update record: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $response = TracerStudyResponse::findOrFail($id);
        
        try {
            $response->delete();
            return redirect()->route('tracer-responses.index')->with('success', 'Record deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('tracer-responses.index')
                ->withErrors(['error' => 'Failed to delete record: ' . $e->getMessage()]);
        }
    }
}