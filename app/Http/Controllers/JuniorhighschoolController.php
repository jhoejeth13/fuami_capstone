<?php

namespace App\Http\Controllers;

use App\Models\Juniorhighschool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JuniorhighschoolController extends Controller
{
public function index()
{
    $query = Juniorhighschool::query();
    
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
    
    // Get unique school years for filter dropdown
    $schoolYears = Juniorhighschool::select('school_year')
                    ->distinct()
                    ->orderBy('school_year', 'desc')
                    ->pluck('school_year');
    
    return view('students.index', compact('students', 'schoolYears'));
}

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lrn_number' => 'required|unique:juniorhighschool|max:12',
            'first_name' => 'required|max:50',
            'middle_name' => 'nullable|max:50',
            'last_name' => 'required|max:50',
            'suffix' => 'nullable|max:10',
            'gender' => 'required|in:Male,Female',
            'birthdate' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'school_year' => 'required|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

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
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Juniorhighschool $student)
    {
        $validated = $request->validate([
            'lrn_number' => 'required|max:12|unique:juniorhighschool,lrn_number,'.$student->id,
            'first_name' => 'required|max:50',
            'middle_name' => 'nullable|max:50',
            'last_name' => 'required|max:50',
            'suffix' => 'nullable|max:10',
            'gender' => 'required|in:Male,Female',
            'birthdate' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'school_year' => 'required|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

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
}