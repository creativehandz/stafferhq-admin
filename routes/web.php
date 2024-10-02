<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\GigController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CategoryController;
use Inertia\Inertia;



//Redirect to welcome page when logout
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Redirect to login page when logout
// Route::get('/', function () {
//     return redirect()->route('login');
// });


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

Route::get('/all-job-posts', [JobController::class, 'index'])->name('all-job-posts');

Route::get('/all-contracts', function () {
    return Inertia::render('AllContracts');
})->name('all-contracts');

Route::get('/add-new-company', function () {
    return Inertia::render('AddNewCompany');
})->name('add-new-company');


Route::get('/talent', function () {
    return Inertia::render('Talent');
})->name('talent');


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

// Route::get('/find-work', function () {
//     return Inertia::render('Talent/FindWork');
// })->name('find-work');

Route::get('/your-service', function () {
    return Inertia::render('Talent/YourService');
})->name('your-service');

Route::get('/proposals-and-offer', function () {
    return Inertia::render('Talent/ProposalsAndOffer');
})->name('proposals-and-offer');

Route::get('/manage-orders', function () {
    return Inertia::render('Talent/YourActiveContracts');
})->name('manage-orders');

Route::get('/gigs-record', function () {
    return Inertia::render('Gigs/GigsRecord');
})->name('gigs-record');

// Route::get('/gigs-record', function () {
//     return Inertia::render('Talent/ContractHistory');
// })->name('gigs-record');

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

Route::get('/find-work/best-matches', function () {
    return Inertia::render('Talent/BestMatches');
})->name('best-matches');

Route::get('/find-work/most-recent', function () {
    return Inertia::render('Talent/MostRecent');
})->name('most-recent');

Route::get('/find-work/saved-jobs', function () {
    return Inertia::render('Talent/SavedJobs');
})->name('saved-jobs');

Route::get('/thank-you', function () {
    return Inertia::render('ThankyouPage');
})->name('thank-you');

Route::get('/applicants', function () {
    return Inertia::render('Applicants');
})->name('applicants');

Route::get('/become-a-seller', function () {
    return Inertia::render('BecomeASeller',[
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('become-a-seller');


// Route::get('/categories', function () {
//     return Inertia::render('Categories',[
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//     ]);
// })->name('categories');


Route::get('/categories', [CategoryController::class, 'getCategoriesWithSubcategories'])->name('categories');

Route::get('/categories/{categoryId}', [CategoryController::class, 'getCategoryDetail'])->name('category.detail');

Route::get('/categories/{categoryId}/sellers', function () {
    return Inertia::render('Sellers',[
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('sellers');

// Route::get('/edit-resume', function () {
//     return Inertia::render('Talent/EditResume');
// })->name('edit-resume');

// Route::get('/messages', function () {
//     return Inertia::render('Messages');
// })->name('messages');


//Routes for Talent end

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');    

     //create routes for jobs
     Route::post('post-a-job', [JobController::class, 'store']);
     //Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');

     //create route for create resume
     Route::post('/create-resume', [ResumeController::class, 'store']);

     //display resume data
     Route::get('/setting', [ResumeController::class, 'getResumeData']);

     
    Route::get('/edit-resume', [ResumeController::class,'editResume'])->name('resume.edit');
    Route::patch('/edit-resume', [ResumeController::class, 'updateResume'])->name('resume.update');


    Route::get('/find-work', [JobController::class, 'showAllJobs'])->name('find-work');

    Route::get('/find-work/{id}', [JobController::class, 'show'])->name('job.show');

    Route::get('/find-work/{id}/submit-proposal', [JobController::class, 'showJobInProposal'])->name('job.showJobInProposal');



    Route::post('/find-work/{id}/submit-proposal', [ProposalController::class, 'submit'])->name('proposals.submit');


    // Route for fetching messages
    Route::get('/messages/{receiver}', [ChatController::class, 'fetchMessages'])->name('messages.fetch');

    Route::get('/messages', [ChatController::class, 'fetchUsers'])->name('messages.users');

    // // Route for sending messages
    Route::post('/messages', [ChatController::class, 'sendMessage'])->name('messages.send');

    Route::get('/employer-dashboard', [JobController::class,'showTotalJobs'])->name('employer-dashboard');
    

    Route::get('/manage-orders', [OrderController::class,'getOrdersByStatus'])->name('manage-orders');

    Route::get('/gigs-record', [GigController::class,'getGigByStatus'])->name('gigs-record');

    Route::get('/create-gig', [GigController::class, 'create'])->name('create-gig');
    Route::post('/create-gig', [GigController::class, 'store'])->name('gigs.store');


    Route::get('/categoriesandsub', [CategoryController::class, 'getAllCategoriesWithSubCategories']);




});




require __DIR__.'/auth.php';
