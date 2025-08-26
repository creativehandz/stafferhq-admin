<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/users/role/{role}', [UserController::class, 'getUsersByRole']);

// Notification routes (requires authentication)
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [DashboardController::class, 'getNotifications']);
    Route::get('/notifications/unread-count', [DashboardController::class, 'getUnreadNotificationsCount']);
    Route::post('/notifications/{id}/mark-read', [DashboardController::class, 'markNotificationAsRead']);
    Route::post('/notifications/mark-all-read', [DashboardController::class, 'markAllNotificationsAsRead']);
    
    // Order Status routes
    Route::get('/order-statuses', [OrderStatusController::class, 'index']);
    Route::get('/order-statuses/statistics', [OrderStatusController::class, 'getStatusStatistics']);
    Route::get('/orders/{orderId}/status-history', [OrderStatusController::class, 'getOrderHistory']);
    Route::get('/orders/status/{statusSlug}', [OrderStatusController::class, 'getOrdersByStatus']);
    Route::put('/orders/{orderId}/status', [OrderStatusController::class, 'changeOrderStatus']);
    Route::put('/orders/bulk-status-update', [OrderStatusController::class, 'bulkUpdateStatus']);
    
    // Review routes
    Route::post('/reviews', [ReviewController::class, 'store']);
});
