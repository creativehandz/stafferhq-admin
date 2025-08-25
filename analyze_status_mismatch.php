<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Status Mapping Analysis\n";
echo "======================\n\n";

echo "Frontend expects these statuses (from Vue component):\n";
echo "- Priority\n";
echo "- Active\n";
echo "- Late\n";
echo "- Delivered\n";
echo "- Completed\n";
echo "- Cancelled\n";
echo "- Starred\n\n";

echo "Current manage_orders table statuses:\n";
$manageOrderStatuses = DB::table('manage_orders')
    ->select('status', DB::raw('count(*) as count'))
    ->groupBy('status')
    ->get();

foreach($manageOrderStatuses as $status) {
    echo "- '{$status->status}': {$status->count} orders\n";
}

echo "\nCurrent buyer_checkout table statuses:\n";
$buyerCheckoutStatuses = DB::table('buyer_checkout')
    ->select('status', DB::raw('count(*) as count'))
    ->groupBy('status')
    ->get();

foreach($buyerCheckoutStatuses as $status) {
    echo "- '{$status->status}': {$status->count} orders\n";
}

echo "\nOrder statuses table (if exists):\n";
try {
    $orderStatusTable = DB::table('order_statuses')->get(['id', 'name', 'slug', 'color']);
    foreach($orderStatusTable as $status) {
        echo "- ID {$status->id}: '{$status->name}' (slug: {$status->slug}, color: {$status->color})\n";
    }
} catch (Exception $e) {
    echo "order_statuses table doesn't exist or error: " . $e->getMessage() . "\n";
}

echo "\nRECOMMENDATION:\n";
echo "The issue is that:\n";
echo "1. Frontend calls /seller-orders (CheckoutController) which returns buyer_checkout data\n";
echo "2. But the /manage-orders route (OrderController) returns manage_orders data\n";
echo "3. The new orders are in manage_orders table with 'pending' status\n";
echo "4. Frontend expects 'Active' status for active orders\n\n";

echo "Solution: Update manage_orders 'pending' status to 'Active' to match frontend expectations\n";
