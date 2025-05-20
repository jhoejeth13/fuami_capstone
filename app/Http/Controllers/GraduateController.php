<?php

namespace App\Http\Controllers;

use App\Models\Graduate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Year;

class GraduateController extends Controller
{
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
        $perPage = $request->input('perPage', 10); // Default to 10 rows per page
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
        $years = Graduate::distinct()->orderBy('year_graduated', 'desc')->pluck('year_graduated');

        return view('graduates.create', [
            'years' => $years,
            'suffixOptions' => $this->suffixOptions
        ]);
    }

 public function store(Request $request)
    {
        $validated = $request->validate([
            'ID_student' => 'nullable|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|max:10',
            'other_suffix' => 'required_if:suffix,Others|nullable|max:10',
            'gender' => 'required|string|in:Male,Female,Other',
            'birthdate' => 'nullable|date',
            'year_graduated' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'strand' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle suffix logic
        $validated['suffix'] = $request->suffix === 'Others' ? $request->other_suffix : $request->suffix;

        if ($request->hasFile('picture')) {
            $validated['picture'] = $request->file('picture')->store('graduates', 'public');
        }

        Graduate::create($validated);

        return redirect()->route('graduates.index')
            ->with('success', 'SHS Graduate added successfully!')
            ->with('showModal', true);
    }
    public function show(Graduate $graduate)
    {
        return view('graduates.show', compact('graduate'));
    }

public function edit(Graduate $graduate)
{
    $years = Graduate::distinct()->orderBy('year_graduated', 'desc')->pluck('year_graduated');
    
    // Determine if we should show the other_suffix field
    $showOtherSuffix = ($graduate->suffix === 'Others');
    
    return view('graduates.edit', [
        'graduate' => $graduate,
        'years' => $years,
        'suffixOptions' => $this->suffixOptions,
        'showOtherSuffix' => $showOtherSuffix
    ]);
}

    public function update(Request $request, Graduate $graduate)
    {
        $validated = $request->validate([
            'ID_student' => 'nullable|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|max:10',
            'other_suffix' => 'required_if:suffix,Others|nullable|max:10',
            'gender' => 'required|string|in:Male,Female,Other',
            'birthdate' => 'nullable|date',
            'year_graduated' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'strand' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle suffix logic
        $validated['suffix'] = $request->suffix === 'Others' ? $request->other_suffix : $request->suffix;

        if ($request->hasFile('picture')) {
            if ($graduate->picture) {
                Storage::disk('public')->delete($graduate->picture);
            }
            $validated['picture'] = $request->file('picture')->store('graduates', 'public');
        }

        if ($request->has('remove_picture') && $graduate->picture) {
            Storage::disk('public')->delete($graduate->picture);
            $validated['picture'] = null;
        }

        $graduate->update($validated);

        return redirect()->route('graduates.index')
            ->with('success', 'Graduate updated successfully!');
    }

    public function destroy(Graduate $graduate)
    {
        if ($graduate->picture) {
            Storage::disk('public')->delete($graduate->picture);
        }
        $graduate->delete();
        
        return redirect()->route('graduates.index')
            ->with('success', 'Graduate deleted successfully!');
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