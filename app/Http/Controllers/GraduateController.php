<?php

namespace App\Http\Controllers;

use App\Models\Graduate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GraduateController extends Controller
{
    public function index()
    {
        $graduates = Graduate::all();
        return view('graduates.index', compact('graduates'));
    }

    public function create()
    {
        return view('graduates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ID_student' => 'required|string|max:255',
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
        return view('graduates.edit', compact('graduate'));
    }

    public function update(Request $request, Graduate $graduate)
    {
        $request->validate([
            'ID_student' => 'required|string|max:255',
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
}