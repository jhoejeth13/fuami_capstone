<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TracerStudyResponse;

class TracerStudyController extends Controller
{
    public function showForm()
    {
        return view('tracer.tracer-study-form');
    }

    public function submitForm(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'age' => 'required|integer|min:16',
            'gender' => 'required|string',
            'birthdate' => 'required|date',
            'civil_status' => 'required|string',
            'religion' => 'required|string',
            'address' => 'required|string',
            'municipality' => 'required|string',
            'province' => 'required|string',
            'region' => 'required|string',
            'postal_code' => 'required|string',
            'country' => 'required|string',
            'shs_track' => 'required|string',
            'year_graduated' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'employment_status' => 'required|string',
            'organization_type' => 'nullable|string',
            'occupational_classification' => 'nullable|string',
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

    public function index()
    {
        $responses = TracerStudyResponse::all();
        return view('tracer.responses', compact('responses'));
    }
}