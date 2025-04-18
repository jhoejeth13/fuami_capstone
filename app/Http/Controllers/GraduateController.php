<?php

namespace App\Http\Controllers;

use App\Models\Graduate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Year;

class GraduateController extends Controller
{
    public function index(Request $request)
    {
        $query = Graduate::query();
    
        // Apply search filter if provided
        if ($request->has('search')) {
            $search = strtolower($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(ID_student) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(first_name) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(middle_name) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(last_name) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(strand) LIKE ?', ["%{$search}%"]);
            });
        }
    
        // Apply year filter if provided
        if ($request->has('year') && $request->year != '') {
            $query->where('year_graduated', $request->year);
        }
    
        // Handle print request
        if ($request->has('print')) {
            $graduates = $query->get();
            $year = $request->input('year');
            return view('graduates.print', compact('graduates', 'year'));
        }
    
        // Paginate results
        $perPage = $request->input('perPage', 10); // Default to 5 rows per page
        $graduates = $query->paginate($perPage);
    
        // Append query parameters to pagination links
        $graduates->appends([
            'search' => $request->search,
            'year' => $request->year,
            'perPage' => $perPage,
        ]);
    
        // Get unique years from graduates table
        $years = Graduate::distinct()->orderBy('year_graduated', 'desc')->pluck('year_graduated');
    
        return view('graduates.index', compact('graduates', 'years'));
    }

    public function create()
    {
        // Get unique years from graduates table
        $years = Graduate::distinct()->orderBy('year_graduated', 'desc')->pluck('year_graduated');

        return view('graduates.create', compact('years'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ID_student' => 'nullable|string|max:255', // Changed to nullable
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string|in:Male,Female,Other',
            'birthdate' => 'nullable|date',
            'year_graduated' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'strand' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $picturePath = $request->hasFile('picture') 
            ? $request->file('picture')->store('graduates', 'public')
            : null;

        Graduate::create([
            'ID_student' => $request->ID_student,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'birthdate' => $request->birthdate,
            'year_graduated' => $request->year_graduated,
            'strand' => $request->strand,
            'address' => $request->address,
            'picture' => $picturePath,
        ]);

        return redirect()->route('graduates.index')->with('success', 'Graduate added successfully!');
    }

    public function show(Graduate $graduate)
    {
        return view('graduates.show', compact('graduate'));
    }

    public function edit(Graduate $graduate)
    {
        // Get unique years from graduates table
        $years = Graduate::distinct()->orderBy('year_graduated', 'desc')->pluck('year_graduated');
        return view('graduates.edit', compact('graduate', 'years'));
    }

    public function update(Request $request, Graduate $graduate)
    {
        $request->validate([
            'ID_student' => 'nullable|string|max:255', // Changed to nullable
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string|in:Male,Female,Other',
            'birthdate' => 'nullable|date',
            'year_graduated' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'strand' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('picture')) {
            if ($graduate->picture) {
                Storage::disk('public')->delete($graduate->picture);
            }
            $picturePath = $request->file('picture')->store('graduates', 'public');
        } else {
            $picturePath = $graduate->picture;
        }

        $graduate->update([
            'ID_student' => $request->ID_student,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'birthdate' => $request->birthdate,
            'year_graduated' => $request->year_graduated,
            'strand' => $request->strand,
            'address' => $request->address,
            'picture' => $picturePath,
        ]);

        return redirect()->route('graduates.index')->with('success', 'Graduate updated successfully!');
    }

    public function destroy(Graduate $graduate)
    {
        if ($graduate->picture) {
            Storage::disk('public')->delete($graduate->picture);
        }
        $graduate->delete();
        return redirect()->route('graduates.index')->with('success', 'Graduate deleted successfully!');
    }

    public function addYear(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|unique:years,year',
        ]);

        $year = Year::create([
            'year' => $request->input('year'),
        ]);

        return response()->json(['year' => $year->year]);
    }

}