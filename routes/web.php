<?php

use App\Http\Controllers\AlumniCardController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\Profile\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\SuperAdmin\ApplicationController;
use App\Http\Controllers\SuperAdmin\StatsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Публичный экран карты выпускника по public_id
Route::get('/card/{publicId}', [AlumniCardController::class, 'show'])
    ->name('alumni.card.show');

// Кабинет супер-админа
Route::prefix('super-admin')
    ->middleware(['auth', 'super.admin'])
    ->name('super-admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('users', SuperAdminUserController::class);
        Route::patch('users/{user}/status', [SuperAdminUserController::class, 'updateStatus'])
            ->name('users.status');
        Route::post('users/{user}/reset-password', [SuperAdminUserController::class, 'resetPassword'])
            ->name('users.reset-password');

        Route::get('applications', [ApplicationController::class, 'index'])
            ->name('applications.index');
        Route::get('applications/{application}', [ApplicationController::class, 'show'])
            ->name('applications.show');
        Route::patch('applications/{application}/approve', [ApplicationController::class, 'approve'])
            ->name('applications.approve');
        Route::patch('applications/{application}/reject', [ApplicationController::class, 'reject'])
            ->name('applications.reject');
        Route::patch('applications/{application}/suspend', [ApplicationController::class, 'suspend'])
            ->name('applications.suspend');

        Route::get('stats', [StatsController::class, 'index'])
            ->name('stats');
    });

Route::middleware('auth')->group(function () {
    Route::get('/vacancies', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/vacancies/{id}', [JobController::class, 'show'])
        ->name('jobs.show')
        ->where('id', '[0-9]+');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/alumni', [ProfileController::class, 'updateAlumni'])->name('profile.alumni.update');
    Route::post('/profile/photo', [PhotoController::class, 'update'])->name('profile.photo.update');
    Route::delete('/profile/photo', [PhotoController::class, 'destroy'])->name('profile.photo.destroy');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
