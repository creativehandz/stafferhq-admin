<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ResumeController;
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



//Routes for Employer Starts
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
//Routes for Employer end


//Routes for Talent start
Route::get('/create-resume', function () {
    return Inertia::render('Talent/CreateResume');
})->name('create-resume');

Route::get('/design', function () {
    return Inertia::render('Talent/Design');
})->name('design');

Route::get('/hourly-price', function () {
    return Inertia::render('Talent/HourlyPrice');
})->name('hourly-price');

Route::get('/find-work', function () {
    return Inertia::render('Talent/FindWork');
})->name('find-work');

Route::get('/your-service', function () {
    return Inertia::render('Talent/YourService');
})->name('your-service');

Route::get('/proposals-and-offer', function () {
    return Inertia::render('Talent/ProposalsAndOffer');
})->name('proposals-and-offer');

Route::get('/your-active-contracts', function () {
    return Inertia::render('Talent/YourActiveContracts');
})->name('your-active-contracts');

Route::get('/contract-history', function () {
    return Inertia::render('Talent/ContractHistory');
})->name('contract-history');

Route::get('/hourly-work-diary', function () {
    return Inertia::render('Talent/HourlyWorkDiary');
})->name('hourly-work-diary');

Route::get('/financial-overview', function () {
    return Inertia::render('Talent/FinancialOverview');
})->name('financial-overview');

Route::get('/your-report', function () {
    return Inertia::render('Talent/YourReport');
})->name('your-report');

Route::get('/billing-and-earning', function () {
    return Inertia::render('Talent/BillingAndEarning');
})->name('billing-and-earning');

Route::get('/transaction-and-invoices', function () {
    return Inertia::render('Talent/TransactionAndInvoices');
})->name('transaction-and-invoices');


Route::get('/certificate-of-earning', function () {
    return Inertia::render('Talent/CertificateOfEarning');
})->name('certificate-of-earning');

Route::get('/withdraw-earning', function () {
    return Inertia::render('Talent/WithdrawEarning');
})->name('withdraw-earning');

Route::get('/setting', function () {
    return Inertia::render('Talent/Setting');
})->name('setting');


Route::get('/error-page', function () {
    return Inertia::render('ErrorPage');
})->name('error-page');

// Route::get('/edit-resume', function () {
//     return Inertia::render('Talent/EditResume');
// })->name('edit-resume');

//Routes for Talent end

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');    

     //create routes for jobs
     Route::post('post-a-job', [JobController::class, 'store']);

     //create route for create resume
     Route::post('/create-resume', [ResumeController::class, 'store']);

     //display resume data
     Route::get('/setting', [ResumeController::class, 'getResumeData']);

     
    Route::get('/edit-resume', [ResumeController::class,'editResume'])->name('resume.edit');
    Route::patch('/edit-resume', [ResumeController::class, 'updateResume'])->name('resume.update');
});




require __DIR__.'/auth.php';
