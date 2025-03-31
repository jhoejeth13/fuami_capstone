<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TracerStudyResponse;
use Illuminate\Support\Facades\DB;
use App\Helpers\LocationHelper;
use Illuminate\Support\Facades\Cache;

class TracerStudyController extends Controller
{
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
            'address' => 'required|string',
            'barangay' => 'required|string',
            'municipality' => 'required|string',
            'province' => 'required|string',
            'region' => 'required|string',
            'postal_code' => 'nullable|string',
            'country' => 'nullable|string',
            'shs_track' => 'required|string',
            'year_graduated' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'employment_status' => 'required|string',
            'organization_type' => 'nullable|string',
            'organization_type_other' => 'nullable|string|required_if:organization_type,Other',
            'occupational_classification' => 'nullable|string',
            'occupational_classification_other' => 'nullable|string|required_if:occupational_classification,Other',
            'employer_name' => 'required|string',
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
        ]);

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

        // Convert Yes/No to boolean
        $validated['job_related_to_shs'] = $request->job_related_to_shs === 'Yes';
        $validated['fuami_factor'] = $request->fuami_factor === 'Yes';

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

        // Apply filter only if employment_status is set and not empty
        if ($request->filled('employment_status')) {
            $query->where('employment_status', $request->employment_status);
        }

        $perPage = $request->input('perPage', 5); // Default to 5 items per page
        $responses = $query->paginate($perPage);

        return view('tracer.responses', [
            'responses' => $responses,
            'organizationTypes' => $this->organizationTypes,
            'occupationClassifications' => $this->occupationClassifications,
            'suffixOptions' => $this->suffixOptions
        ]);
    }

    public function rules()
{
    $rules = [
        'employment_status' => 'required|in:Employed,Unemployed',
        'unemployment_reason' => 'required_if:employment_status,Unemployed',
    ];

    if ($this->input('employment_status') === 'Employed') {
        $rules += [
            'employer_name' => 'required',
            'organization_type' => 'required',
            'occupational_classification' => 'required',
            'job_situation' => 'required',
            'years_in_company' => 'required'
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
    $validated = $request->validate([
        // Same validation rules as in submitForm
    ]);

    $response = TracerStudyResponse::findOrFail($id);
    
    try {
        $response->update($validated);
        return redirect()->route('tracer.responses')->with('success', 'Record updated successfully!');
    } catch (\Exception $e) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => 'Failed to update record: ' . $e->getMessage()]);
    }
}

public function destroy($id)
{
    $response = TracerStudyResponse::findOrFail($id);
    
    try {
        $response->delete();
        return redirect()->route('tracer.responses')->with('success', 'Record deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('tracer.responses')
            ->withErrors(['error' => 'Failed to delete record: ' . $e->getMessage()]);
    }
}
}