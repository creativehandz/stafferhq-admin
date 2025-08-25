<?php

use App\Http\Controllers\BillingDetailsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BuyerProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ResumeController;

// Test route for checkout functionality
Route::get('/test-checkout', function () {
    return view('test-checkout');
});

// CSRF token route for AJAX
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

// Test user creation route
Route::post('/create-test-user', function () {
    $user = \App\Models\User::firstOrCreate(
        ['email' => 'test@example.com'],
        [
            'name' => 'Test User',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]
    );
    
    auth()->login($user);
    
    return response()->json([
        'message' => 'Test user created and logged in',
        'user' => $user->only(['id', 'name', 'email'])
    ]);
});
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\GigController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BuyerJobController;

use Faker\Provider\ar_EG\Internet;
use Inertia\Inertia;
use App\Http\Controllers\UserStatusController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\RequirementController;
use App\Http\Controllers\UserController;

//Redirect to welcome page when logout
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Test database connection route
Route::get('/test-db-connection', function () {
    try {
        DB::connection()->getPdo();
        return response()->json([
            'status' => 'success',
            'message' => 'Database connection successful!',
            'database' => config('database.default'),
            'host' => config('database.connections.' . config('database.default') . '.host'),
            'database_name' => config('database.connections.' . config('database.default') . '.database'),
            'timestamp' => now()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Database connection failed!',
            'error' => $e->getMessage(),
            'timestamp' => now()
        ], 500);
    }
});

Route::post('/billing-details', [BillingDetailsController::class, 'store']);

Route::post('/store-package', [PackageController::class, 'storePackageInSession'])->name('store.package');
Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store']);
// routes/web.php


// This in api.php will respond to /api/buyer-checkout
Route::get('/seller-orders', [CheckoutController::class, 'index']);


Route::post('/submit-requirements', [RequirementController::class, 'store']);

// this is for testing
Route::get('/demo-me', function () {
    return Inertia::render('OtherPages/demoMe');
})->name('DemoMe');

// Dropdown Routes for Buyer
Route::get('/referral', function () {
    return Inertia::render('Referral/ReferralHome');
})->name('ReferralHome');

Route::get('/buyer-profile', [BuyerProfileController::class, 'show'])->name('buyer-profile');
Route::get('/buyer-profile/edit', [BuyerProfileController::class, 'edit'])->name('buyer-profile.edit')->middleware('auth');
Route::put('/buyer-profile', [BuyerProfileController::class, 'update'])->name('buyer-profile.update')->middleware('auth');

Route::get('/buyer-checkout', function () {
    return Inertia::render('Jobs/BillingHome');
})->name('BillingHome');

Route::get('/contact-me', function () {
    return Inertia::render('OtherPages/ContactMe');
})->name('contactMe');

Route::get('/buyer-inbox', function () {
    return Inertia::render('Chats/ChatHome');
})->name('BuyerChats');

Route::get('premium-plans', function () {
    return Inertia::render('OtherPages/PremiumPlans');
})->name("PremiumPlans");

Route::get('/orders', function () {
    return Inertia::render('OtherPages/Orders');
})->name('Orders');

Route::get('/switch-to-selling', function () {
    return Inertia::render('OtherPages/SwitchToSelling');
})->name('SwitchToSelling');

Route::post('/switch-to-selling', [UserController::class, 'switchToSelling'])->name('switch.to.selling');

Route::post('/switch-to-buying', [UserController::class, 'switchToBuying'])->name('switch.to.buying');



Route::get('/post-a-request', function () {
    return Inertia::render('OtherPages/PostARequest');
})->name('PostARequest');

Route::get('/refer-a-friend', function () {
    return Inertia::render('OtherPages/ReferAFriend');
})->name('ReferAFriend');

Route::get('/account-settings', function () {
    return Inertia::render('OtherPages/AccountSettings');
})->name('AccountSettings');

Route::get('/billing-and-payments', function () {
    return Inertia::render('OtherPages/BillingAndPayments');
})->name('BillingAndPayments');

Route::get('/english', function () {
    return Inertia::render('OtherPages/English');
})->name('English');

Route::get('/inr', function () {
    return Inertia::render('OtherPages/INR');
})->name('INR');

Route::get('/help-and-support', function () {
    return Inertia::render('OtherPages/HelpAndSupport');
})->name('HelpAndSupport');
// Routes for Buyer ends

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/seller-dashboard', [App\Http\Controllers\DashboardController::class, 'sellerDashboard'])
    ->middleware(['auth', 'verified'])->name('seller-dashboard');

Route::get('/buyer-dashboard', [BuyerProfileController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])->name('buyer-dashboard');

Route::get('/gigs', [GigController::class, 'getGigs']);

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

// Removed duplicate manage-orders route - using the one inside auth middleware

Route::get('/gigs-record', function () {
    return Inertia::render('Gigs/GigsRecord');
})->name('gigs-record');


// Route::get('/job-listings', function () {
//     return Inertia::render('Talent/JobListings');
// })->name('job-listings');

Route::get('/job-listings', [BuyerJobController::class, 'index'])->name('job-listings');

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

Route::get('send-mail', [MailController::class, 'index']);
// Route::get('/categories', function () {
//     return Inertia::render('Categories',[
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//     ]);
// })->name('categories');


Route::get('/categories', [CategoryController::class, 'getCategoriesWithSubcategories'])->name('categories');

Route::get('/', [CategoryController::class, 'getCatwithButtons']);

Route::get('/categories/{categoryId}', [CategoryController::class, 'getCategoryDetail'])->name('category.detail');

Route::get('/categories/{categoryId}/sellers', function () {
    return Inertia::render('Sellers',[
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('sellers');

Route::get('/post-a-project-brief', function () {
    return Inertia::render('PostAProjectBrief');
})->name('post-a-project-brief');

Route::post('/buyer-jobs', [BuyerJobController::class, 'store']);

Route::post('/buyer-checkout/{id}/update-status', [CheckoutController::class, 'updateStatus']);


// Route::get('/edit-resume', function () {
//     return Inertia::render('Talent/EditResume');
// })->name('edit-resume');

// Route::get('/messages', function () {
//     return Inertia::render('Messages');
// })->name('messages');


//Routes for Talent end

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
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

    // Route to get all last messages
    Route::get('/last-messages', [ChatController::class,'fetchLastMessages'])->name('messages.last');

    Route::get('/messages', [ChatController::class, 'fetchUsers'])->name('messages.users');

    // // Route for sending messages
    Route::post('/messages', [ChatController::class, 'sendMessage'])->name('messages.send');

    Route::post('/api/update-online-status', [UserStatusController::class, 'updateOnlineStatus']);


    Route::get('/employer-dashboard', [JobController::class,'showTotalJobs'])->name('employer-dashboard');
    

    Route::get('/manage-orders', [OrderController::class,'getOrdersByStatus'])->name('manage-orders');

    Route::get('/gigs-record', [GigController::class,'getGigByStatus'])->name('gigs-record');

    Route::get('/create-gig', [GigController::class, 'create'])->name('create-gig');
    Route::post('/create-gig', [GigController::class, 'store'])->name('gigs.store');


    Route::get('/categoriesandsub', [CategoryController::class, 'getAllCategoriesWithSubCategories']);


    Route::get('/job-description/{id}', [GigController::class, 'show'])->name('job.show');

    Route::get('/checkout/{id}', [GigController::class, 'checkout'])->name('checkout');


    // seller dashboard route for order timeline
    Route::get('/order-timeline', function () {
        return Inertia::render('OrderTimeline');
    })->name('OrderTimeline');

    // Notification routes for web interface
    Route::get('/web/notifications', [DashboardController::class, 'getNotifications'])->name('web.notifications');
    Route::get('/web/notifications/unread-count', [DashboardController::class, 'getUnreadNotificationsCount'])->name('web.notifications.unread-count');
    Route::post('/web/notifications/{id}/mark-read', [DashboardController::class, 'markNotificationAsRead'])->name('web.notifications.mark-read');
    Route::post('/web/notifications/mark-all-read', [DashboardController::class, 'markAllNotificationsAsRead'])->name('web.notifications.mark-all-read');
});




require __DIR__.'/auth.php';
