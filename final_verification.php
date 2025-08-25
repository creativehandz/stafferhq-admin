<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "FINAL VERIFICATION - Manage Orders Fix\n";
echo "=====================================\n\n";

// 1. Check database state
echo "1. DATABASE STATE:\n";
$totalOrders = DB::table('manage_orders')->count();
echo "   Total orders in manage_orders table: {$totalOrders}\n";

$ordersByUser = DB::table('manage_orders')
    ->select('user_id', DB::raw('count(*) as count'))
    ->groupBy('user_id')
    ->get();

echo "   Orders by user:\n";
foreach($ordersByUser as $userOrder) {
    echo "   - User {$userOrder->user_id}: {$userOrder->count} orders\n";
}

// 2. Check recent orders
echo "\n2. RECENT ORDERS:\n";
$recentOrders = DB::table('manage_orders')
    ->orderBy('created_at', 'desc')
    ->limit(3)
    ->get(['id', 'user_id', 'buyer', 'gig', 'status', 'created_at']);

foreach($recentOrders as $order) {
    echo "   Order {$order->id}: {$order->gig} by {$order->buyer} for user {$order->user_id} ({$order->status})\n";
}

// 3. Check controller file
echo "\n3. CONTROLLER VERIFICATION:\n";
$controllerPath = __DIR__ . '/app/Http/Controllers/OrderController.php';
$controllerContent = file_get_contents($controllerPath);

if (strpos($controllerContent, 'ManageOrder::forUser') !== false) {
    echo "   ✓ OrderController uses ManageOrder::forUser()\n";
} else {
    echo "   ✗ OrderController doesn't use ManageOrder::forUser()\n";
}

if (strpos($controllerContent, 'Auth::id()') !== false) {
    echo "   ✓ OrderController uses Auth::id() for user filtering\n";
} else {
    echo "   ✗ OrderController doesn't use Auth::id()\n";
}

// 4. Check routes
echo "\n4. ROUTE VERIFICATION:\n";
$routesPath = __DIR__ . '/routes/web.php';
$routesContent = file_get_contents($routesPath);

$manageOrdersCount = substr_count($routesContent, "'/manage-orders'");
echo "   Number of manage-orders routes: {$manageOrdersCount}\n";

if (strpos($routesContent, 'OrderController::class') !== false) {
    echo "   ✓ Route points to OrderController\n";
} else {
    echo "   ✗ Route doesn't point to OrderController\n";
}

echo "\n5. EXPECTED BEHAVIOR:\n";
echo "   - When seller (user ID 3) logs in and visits /manage-orders\n";
echo "   - They should see 6 orders (5 pending, 1 active)\n";
echo "   - Orders should be grouped by status with proper counts\n";
echo "   - Page should render Talent/YourActiveContracts with full data\n";

echo "\n6. TROUBLESHOOTING STEPS:\n";
echo "   1. Login as pranavtfcppp@gmail.com / 12345678\n";
echo "   2. Visit /debug-manage-orders to verify authentication\n";
echo "   3. Visit /manage-orders to see the actual orders page\n";
echo "   4. Check browser console for any JavaScript errors\n";

echo "\nVerification completed!\n";
