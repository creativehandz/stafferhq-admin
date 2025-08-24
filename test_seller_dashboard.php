<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;

// Set up the Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';

// Boot the application
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "🎯 Testing Seller Dashboard Data\n";
echo "===============================\n\n";

try {
    // Authenticate as the seller (user_id: 3)
    Auth::loginUsingId(3);
    echo "✅ Authenticated as seller (user_id: 3 - seller@towork.com)\n\n";

    // Create the dashboard controller
    $controller = new DashboardController();
    
    // Get seller stats
    $response = $controller->getSellerStatsApi();
    $stats = json_decode($response->getContent(), true);

    echo "📊 Seller Dashboard Statistics:\n";
    echo "==============================\n";
    echo "📋 Orders:\n";
    echo "  - Total Orders: {$stats['total_orders']}\n";
    echo "  - Pending Orders: {$stats['pending_orders']}\n";
    echo "  - In Progress Orders: {$stats['in_progress_orders']}\n";
    echo "  - Completed Orders: {$stats['completed_orders']}\n\n";

    echo "💰 Financial:\n";
    echo "  - Total Earnings: \${$stats['total_earnings']}\n";
    echo "  - This Month Earnings: \${$stats['this_month_earnings']}\n\n";

    echo "📈 Performance:\n";
    echo "  - Completion Rate: {$stats['completion_rate']}%\n";
    echo "  - Due Soon: {$stats['due_soon']}\n";
    echo "  - Overdue: {$stats['overdue']}\n\n";

    echo "🎯 Recent Orders:\n";
    echo "================\n";
    foreach ($stats['recent_orders'] as $order) {
        echo "  - Order #{$order['id']}: {$order['gig']} by {$order['buyer']} - \${$order['total']} ({$order['status']})\n";
    }

    echo "\n✅ Seller dashboard data retrieved successfully!\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
