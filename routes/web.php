<?php

use App\Http\Controllers\AlumniCardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\Profile\PhotoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Публичные вакансии
Route::get('/vacancies', [JobController::class, 'index'])->name('jobs.index');
Route::get('/vacancies/{id}', [JobController::class, 'show'])
    ->name('jobs.show')
    ->where('id', '[0-9]+');

// Публичный экран карты выпускника по public_id
Route::get('/card/{publicId}', [AlumniCardController::class, 'show'])
    ->name('alumni.card.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/alumni', [ProfileController::class, 'updateAlumni'])->name('profile.alumni.update');
    Route::post('/profile/photo', [PhotoController::class, 'update'])->name('profile.photo.update');
    Route::delete('/profile/photo', [PhotoController::class, 'destroy'])->name('profile.photo.destroy');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
