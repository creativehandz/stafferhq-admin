<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Current Order Statuses in Database\n";
echo "==================================\n\n";

// Get all orders with their current status
$orders = DB::table('manage_orders')
    ->select('id', 'user_id', 'buyer', 'gig', 'status', 'created_at')
    ->orderBy('created_at', 'desc')
    ->get();

echo "All Orders:\n";
foreach($orders as $order) {
    echo "Order {$order->id}: {$order->gig} - {$order->buyer} - Status: '{$order->status}' - Created: {$order->created_at}\n";
}

echo "\nOrder Status Summary:\n";
$statusCounts = DB::table('manage_orders')
    ->select('status', DB::raw('count(*) as count'))
    ->groupBy('status')
    ->get();

foreach($statusCounts as $status) {
    echo "- {$status->status}: {$status->count} orders\n";
}

echo "\nRecent Orders (last 3):\n";
$recentOrders = DB::table('manage_orders')
    ->orderBy('created_at', 'desc')
    ->limit(3)
    ->get();

foreach($recentOrders as $order) {
    echo "- Order {$order->id}: {$order->status} (Created: {$order->created_at})\n";
}

// Check what statuses are expected vs actual
echo "\nExpected Status Mapping:\n";
echo "- 'pending' should show under 'Active'\n";
echo "- 'in_progress' should show under 'Active'\n";
echo "- 'completed' should show under 'Completed'\n";
echo "- 'cancelled' should show under 'Cancelled'\n";

echo "\nCurrent Status Analysis:\n";
$pendingCount = DB::table('manage_orders')->where('status', 'pending')->count();
$activeCount = DB::table('manage_orders')->where('status', 'Active')->count();
$inProgressCount = DB::table('manage_orders')->where('status', 'in_progress')->count();
$completedCount = DB::table('manage_orders')->where('status', 'completed')->count();

echo "- 'pending': {$pendingCount} orders\n";
echo "- 'Active': {$activeCount} orders\n";
echo "- 'in_progress': {$inProgressCount} orders\n";
echo "- 'completed': {$completedCount} orders\n";
