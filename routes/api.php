<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/users/role/{role}', [UserController::class, 'getUsersByRole']);

// Notification routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [DashboardController::class, 'getNotifications']);
    Route::get('/notifications/unread-count', [DashboardController::class, 'getUnreadNotificationsCount']);
    Route::post('/notifications/{id}/mark-read', [DashboardController::class, 'markNotificationAsRead']);
    Route::post('/notifications/mark-all-read', [DashboardController::class, 'markAllNotificationsAsRead']);
});
