<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GraduateController;
use App\Http\Controllers\TracerStudyController;
use App\Http\Controllers\DashboardController; // Add this line
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Replace the closure route with controller route
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Graduate routes (protected by auth middleware)
Route::middleware('auth')->group(function () {
    Route::resource('graduates', GraduateController::class);
});

// Tracer Study routes
Route::get('/tracer-study', [TracerStudyController::class, 'showForm'])->name('tracer.form');
Route::post('/tracer-study', [TracerStudyController::class, 'submitForm'])->name('tracer.submit');
Route::get('/tracer-responses', [TracerStudyController::class, 'index'])->name('tracer-responses.index');

Route::post('/add-year', [GraduateController::class, 'addYear'])->name('addYear');
Route::post('/add-year', [GraduateController::class, 'addYear'])->name('add.year');
require __DIR__.'/auth.php';