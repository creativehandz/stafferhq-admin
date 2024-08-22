<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use Inertia\Inertia;

//Redirect to welcome page when logout
// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Redirect to login page when logout
Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/employer-dashboard', function () {
    return Inertia::render('EmployerDashboard');
})->middleware(['auth', 'verified'])->name('employer-dashboard');


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

Route::get('/all-job-posts', function () {
    return Inertia::render('AllJobPosts');
})->name('all-job-posts');

Route::get('/all-contracts', function () {
    return Inertia::render('AllContracts');
})->name('all-contracts');

Route::get('/add-new-company', function () {
    return Inertia::render('AddNewCompany');
})->name('add-new-company');

Route::get('/setting', function () {
    return Inertia::render('Setting');
})->name('setting');

Route::get('/talent', function () {
    return Inertia::render('Talent');
})->name('talent');

Route::get('/messages', function () {
    return Inertia::render('Messages');
})->name('messages');

Route::get('/discover', function () {
    return Inertia::render('Discover');
})->name('discover');

Route::get('/saved-talent', function () {
    return Inertia::render('SavedTalent');
})->name('saved-talent');

Route::get('/create-resume', function () {
    return Inertia::render('CreateResume');
})->name('create-resume');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');    

     //create routes for jobs
     Route::post('post-a-job', [JobController::class, 'store']);
});




require __DIR__.'/auth.php';
