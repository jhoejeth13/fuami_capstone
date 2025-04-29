<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderBy('expiry_date', 'desc')->paginate(10);
        return view('announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('announcements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
            'expiry_date' => 'required|date|after_or_equal:today',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('announcements', 'public');
            $validated['image_path'] = $path;
        }

        // Create announcement with all validated data
        Announcement::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'image_path' => $validated['image_path'] ?? null,
            'expiry_date' => $validated['expiry_date'],
        ]);

        return redirect()->route('announcements.index')
                         ->with('success', 'Announcement published successfully!');
    }

    public function show(Announcement $announcement)
    {
        return view('announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        return view('announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
            'expiry_date' => 'required|date|after_or_equal:today',
        ]);

        // Handle image upload/update
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($announcement->image_path) {
                Storage::disk('public')->delete($announcement->image_path);
            }
            
            $path = $request->file('image')->store('announcements', 'public');
            $validated['image_path'] = $path;
        } elseif ($request->has('remove_image')) {
            // Handle image removal
            if ($announcement->image_path) {
                Storage::disk('public')->delete($announcement->image_path);
            }
            $validated['image_path'] = null;
        }

        $announcement->update($validated);

        return redirect()->route('announcements.index')
                         ->with('success', 'Announcement updated successfully!');
    }

    public function destroy(Announcement $announcement)
    {
        // Delete associated image if exists
        if ($announcement->image_path) {
            Storage::disk('public')->delete($announcement->image_path);
        }

        $announcement->delete();

        return redirect()->route('announcements.index')
                         ->with('success', 'Announcement deleted successfully!');
    }
}