<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GraduateController;
use App\Http\Controllers\TracerStudyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JuniorhighschoolController;
use App\Http\Controllers\RecordSelectionController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\AnnouncementController;
use Illuminate\Support\Facades\Route;

// Redirect root URL to login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Public Tracer Study Form Routes - No authentication required
Route::prefix('tracer')->name('tracer.')->group(function () {
    // Old combined form - keep for backward compatibility
    Route::get('/form', [TracerStudyController::class, 'showForm'])->name('form');
    
    // New separate forms for JHS and SHS
    Route::get('/jhs-form', [TracerStudyController::class, 'showJHSForm'])->name('jhs-form');
    Route::get('/shs-form', [TracerStudyController::class, 'showSHSForm'])->name('shs-form');
    
    // Submit routes for both forms - also public
    Route::post('/submit-jhs', [TracerStudyController::class, 'submitJHSForm'])->name('submit-jhs');
    Route::post('/submit-shs', [TracerStudyController::class, 'submitSHSForm'])->name('submit-shs');
    
    // Original submit route - keep for backward compatibility
    Route::post('/submit', [TracerStudyController::class, 'submitForm'])->name('submit');
});

// Dashboard route (protected by auth and verified middleware)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Profile routes (protected by auth middleware)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Record Selection route (protected by auth middleware)
Route::middleware('auth')->group(function () {
    Route::get('/create-record', [RecordSelectionController::class, 'index'])->name('records.create-selection');
});

// Graduate routes (protected by auth middleware)
Route::middleware('auth')->group(function () {
    Route::resource('graduates', GraduateController::class);
});

// Protected Tracer Study routes (admin functionalities)
Route::middleware('auth')->group(function() {
    // Tracer responses routes
    Route::get('/tracer-responses', [TracerStudyController::class, 'index'])->name('tracer-responses.index');
});

// Admin-only routes for tracer responses
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/tracer-responses/{id}/edit', [TracerStudyController::class, 'edit'])->name('tracer.edit');
    Route::put('/tracer-responses/{id}', [TracerStudyController::class, 'update'])->name('tracer.update');
    Route::delete('/tracer-responses/{id}', [TracerStudyController::class, 'destroy'])->name('tracer.destroy');
    
    // JHS tracer study routes
    Route::get('/jhs-tracer-responses/{id}/edit', [TracerStudyController::class, 'editJHS'])->name('tracer.edit-jhs');
    Route::put('/jhs-tracer-responses/{id}', [TracerStudyController::class, 'updateJHS'])->name('tracer.update-jhs');
    Route::delete('/jhs-tracer-responses/{id}', [TracerStudyController::class, 'destroyJHS'])->name('tracer.destroy-jhs');

    // Reports routes
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('/reports/profession', [ReportsController::class, 'professionalReport'])->name('reports.profession');
});

// Add Year route
Route::post('/add-year', [GraduateController::class, 'addYear'])->name('add.year');

// Add JHS Year route
Route::post('/add-jhs-year', [JuniorhighschoolController::class, 'addYear'])->name('add.jhs.year');

// User routes (protected by auth middleware)
Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::resource('students', JuniorhighschoolController::class);

// Announcements Routes
Route::prefix('announcements')->name('announcements.')->group(function() {
    Route::get('/', [AnnouncementController::class, 'index'])->name('index');
    Route::get('/create', [AnnouncementController::class, 'create'])->name('create');
    Route::post('/', [AnnouncementController::class, 'store'])->name('store');
    Route::get('/{announcement}', [AnnouncementController::class, 'show'])->name('show'); // This is the missing route
    Route::get('/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('edit');
    Route::put('/{announcement}', [AnnouncementController::class, 'update'])->name('update');
    Route::delete('/{announcement}', [AnnouncementController::class, 'destroy'])->name('destroy');
});

// Tracer Form Route (update this to include announcements)
Route::get('/tracer/form', function() {
    $activeAnnouncements = \App\Models\Announcement::where('expiry_date', '>=', now())
        ->orderBy('created_at', 'desc')
        ->get();
        
    return view('tracer.form', compact('activeAnnouncements'));
})->name('tracer.form');
// Authentication routes
require __DIR__.'/auth.php';