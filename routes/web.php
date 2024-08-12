<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/form', function () {
    return Inertia::render('Form');
})->name('form');

Route::get('/users', function () {
    return Inertia::render('Users');
})->name('users');

Route::get('/analytics', function () {
    return Inertia::render('Analytics');
})->name('analytics');

Route::get('/post-a-job', function () {
    return Inertia::render('PostAJob');
})->name('post-a-job');

Route::get('/add-new-company', function () {
    return Inertia::render('AddNewCompany');
})->name('add-new-company');

Route::get('/setting', function () {
    return Inertia::render('Setting');
})->name('setting');

Route::get('/talent', function () {
    return Inertia::render('Talent');
})->name('talent');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
