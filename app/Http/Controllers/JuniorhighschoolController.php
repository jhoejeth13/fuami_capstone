<?php

namespace App\Http\Controllers;

use App\Models\Juniorhighschool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JuniorhighschoolController extends Controller
{
    // Add this property to store suffix options
    protected $suffixOptions = [
        '' => '-- No Suffix --',
        'Jr.' => 'Jr.',
        'Sr.' => 'Sr.',
        'II' => 'II',
        'III' => 'III',
        'IV' => 'IV',
        'V' => 'V',
        'Others' => 'Others (Please specify)'
    ];

    public function index()
    {
        $query = Juniorhighschool::query();
        
        // Exclude "Year Reference" dummy records from the main listing
        $query->where(function($q) {
            $q->where('first_name', '!=', 'Year')
              ->orWhere('last_name', '!=', 'Reference');
        });
        
        // Search filter
        if ($search = request('search')) {
            $query->where(function($q) use ($search) {
                $q->where('lrn_number', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }
        
        // School year filter
        if ($year = request('year')) {
            $query->where('school_year', $year);
        }
        
        // Grade level filter
        if ($grade = request('grade')) {
            $query->where('grade_level', $grade);
        }
        
        $perPage = request('perPage') ?? 5;
        $students = $query->paginate($perPage);
        
        // Get unique school years for filter dropdown (don't exclude dummy records here)
        $schoolYears = Juniorhighschool::select('school_year')
                        ->distinct()
                        ->orderBy('school_year', 'desc')
                        ->pluck('school_year');
        
        return view('students.index', compact('students', 'schoolYears'));
    }

    public function create()
    {
        // Get unique school years for dropdown
        $schoolYears = Juniorhighschool::select('school_year')
                        ->distinct()
                        ->orderBy('school_year', 'desc')
                        ->pluck('school_year');
                        
        return view('students.create', [
            'suffixOptions' => $this->suffixOptions,
            'schoolYears' => $schoolYears
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lrn_number' => 'required|max:12|unique:juniorhighschool',          
            'first_name' => 'required|max:50',
            'middle_name' => 'nullable|max:50',
            'last_name' => 'required|max:50',
            'suffix' => 'nullable|max:10',
            'other_suffix' => 'required_if:suffix,Others|nullable|max:10',
            'gender' => 'required|in:Male,Female',
            'birthdate' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'school_year' => 'required|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle suffix
        $validated['suffix'] = $request->suffix === 'Others' ? $request->other_suffix : $request->suffix;

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('student-photos', 'public');
        }

        Juniorhighschool::create($validated);

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function show(Juniorhighschool $student)
    {
        return view('students.show', compact('student'));
    }

    public function edit(Juniorhighschool $student)
    {
        // Get unique school years for dropdown
        $schoolYears = Juniorhighschool::select('school_year')
                        ->distinct()
                        ->orderBy('school_year', 'desc')
                        ->pluck('school_year');
                        
        return view('students.edit', [
            'student' => $student,
            'suffixOptions' => $this->suffixOptions,
            'schoolYears' => $schoolYears
        ]);
    }

    public function update(Request $request, Juniorhighschool $student)
    {
        $validated = $request->validate([
            'lrn_number' => 'required|max:12|unique:juniorhighschool,lrn_number,'.$student->id,
            'first_name' => 'required|max:50',
            'middle_name' => 'nullable|max:50',
            'last_name' => 'required|max:50',
            'suffix' => 'nullable|max:10',
            'other_suffix' => 'required_if:suffix,Others|nullable|max:10',
            'gender' => 'required|in:Male,Female',
            'birthdate' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'school_year' => 'required|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle suffix
        $validated['suffix'] = $request->suffix === 'Others' ? $request->other_suffix : $request->suffix;

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($student->photo_path) {
                Storage::disk('public')->delete($student->photo_path);
            }
            $validated['photo_path'] = $request->file('photo')->store('student-photos', 'public');
        }

        if ($request->has('remove_photo') && $student->photo_path) {
            Storage::disk('public')->delete($student->photo_path);
            $validated['photo_path'] = null;
        }

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Juniorhighschool $student)
    {
        if ($student->photo_path) {
            Storage::disk('public')->delete($student->photo_path);
        }
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    public function print()
    {
        $query = Juniorhighschool::query();
        
        // Exclude "Year Reference" dummy records
        $query->where(function($q) {
            $q->where('first_name', '!=', 'Year')
              ->orWhere('last_name', '!=', 'Reference');
        });
        
        // Apply the same filters as the index method
        if ($search = request('search')) {
            $query->where(function($q) use ($search) {
                $q->where('lrn_number', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }
        
        if ($year = request('year')) {
            $query->where('school_year', $year);
        }
        
        // Grade level filter
        if ($grade = request('grade')) {
            $query->where('grade_level', $grade);
        }
        
        $students = $query->get();
        $school_year = request('year');
        
        return view('students.print', compact('students', 'school_year'));
    }
    
    /**
     * Add a new school year for JHS students
     */
    public function addYear(Request $request)
    {
        $request->validate([
            'year' => 'required|string|unique:juniorhighschool,school_year',
        ]);

        // Create a dummy record with the new school year so it appears in the filters
        // We'll add a placeholder record that will show up in the filter but not in listings
        $dummy = new Juniorhighschool();
        $dummy->first_name = 'Year';
        $dummy->last_name = 'Reference';
        $dummy->gender = 'Male';
        $dummy->school_year = $request->input('year');
        $dummy->save();

        return response()->json(['year' => $request->input('year')]);
    }
}