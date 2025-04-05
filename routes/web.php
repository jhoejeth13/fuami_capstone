<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GraduateController;
use App\Http\Controllers\TracerStudyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JuniorhighschoolController;
use App\Http\Controllers\RecordSelectionController;
use Illuminate\Support\Facades\Route;

// Redirect root URL to login page
Route::get('/', function () {
    return redirect()->route('login');
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

// Tracer Study routes
Route::middleware('auth')->group(function () {
    // Public routes (viewable by all authenticated users)
    Route::get('/tracer-study', [TracerStudyController::class, 'showForm'])->name('tracer.form');
    Route::post('/tracer-study', [TracerStudyController::class, 'submitForm'])->name('tracer.submit');
    Route::get('/tracer-responses', [TracerStudyController::class, 'index'])->name('tracer-responses.index');
    
    // Admin-only routes
    Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
        Route::get('/tracer-responses/{id}/edit', [TracerStudyController::class, 'edit'])->name('tracer.edit');
        Route::put('/tracer-responses/{id}', [TracerStudyController::class, 'update'])->name('tracer.update');
        Route::delete('/tracer-responses/{id}', [TracerStudyController::class, 'destroy'])->name('tracer.destroy');
    });
});

// Add Year route
Route::post('/add-year', [GraduateController::class, 'addYear'])->name('add.year');

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
// Authentication routes
require __DIR__.'/auth.php';