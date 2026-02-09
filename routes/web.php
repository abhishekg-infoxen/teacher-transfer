<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\LocationController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [TeacherController::class , 'dashboard'])->name('dashboard');
    Route::get('/teacher/profile', [TeacherController::class , 'profile'])->name('teacher.profile');
    Route::get('/teacher/matches', [TeacherController::class , 'findMatches'])->name('matches');
    Route::put('/teacher/profile', [TeacherController::class , 'update'])->name('teacher.update');
    Route::get('/api/locations', [LocationController::class , 'getLocations']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class , 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
