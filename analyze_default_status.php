<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Default Order Status Analysis\n";
echo "=============================\n\n";

echo "When a buyer places a new order, there are TWO different processes:\n\n";

echo "1. BUYER_CHECKOUT TABLE (BuyerCheckout model):\n";
echo "   - Created in: CheckoutController::processCheckout()\n";
echo "   - Default status field: 'pending'\n";
echo "   - Default order_status_id: 1 ('Order Placed' from order_statuses table)\n";
echo "   - Purpose: Tracks the checkout/payment process\n\n";

echo "2. MANAGE_ORDERS TABLE (ManageOrder model):\n";
echo "   - Created in: RequirementController::store() after requirements submitted\n";
echo "   - Default status: 'pending'\n";
echo "   - Purpose: Tracks the actual work order for the seller\n\n";

echo "PROCESS FLOW:\n";
echo "=============\n";
echo "1. Buyer visits checkout page → CheckoutController::processCheckout()\n";
echo "2. BuyerCheckout record created with:\n";
echo "   - status = 'pending'\n";
echo "   - order_status_id = 1 (Order Placed)\n\n";
echo "3. Buyer submits requirements → RequirementController::store()\n";
echo "4. ManageOrder record created with:\n";
echo "   - status = 'pending'\n";
echo "   - Links to seller (user_id = gig owner)\n\n";

// Let's verify by checking the actual default values
echo "VERIFICATION FROM DATABASE:\n";
echo "===========================\n";

echo "\nOrder Placed status (ID 1) details:\n";
$orderPlacedStatus = DB::table('order_statuses')->where('id', 1)->first();
if ($orderPlacedStatus) {
    echo "- ID: {$orderPlacedStatus->id}\n";
    echo "- Name: '{$orderPlacedStatus->name}'\n";
    echo "- Slug: '{$orderPlacedStatus->slug}'\n";
    echo "- Color: {$orderPlacedStatus->color}\n";
}

echo "\nRecent orders and their initial statuses:\n";

echo "\nBUYER_CHECKOUT table (most recent 3):\n";
$recentBuyerCheckout = DB::table('buyer_checkout')
    ->orderBy('created_at', 'desc')
    ->limit(3)
    ->get(['id', 'status', 'order_status_id', 'created_at']);

foreach($recentBuyerCheckout as $order) {
    $statusName = DB::table('order_statuses')->where('id', $order->order_status_id)->value('name') ?? 'Unknown';
    echo "- Order {$order->id}: status='{$order->status}', order_status_id={$order->order_status_id} ('{$statusName}'), created: {$order->created_at}\n";
}

echo "\nMANAGE_ORDERS table (most recent 3):\n";
$recentManageOrders = DB::table('manage_orders')
    ->orderBy('created_at', 'desc')
    ->limit(3)
    ->get(['id', 'status', 'created_at']);

foreach($recentManageOrders as $order) {
    echo "- Order {$order->id}: status='{$order->status}', created: {$order->created_at}\n";
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "SUMMARY:\n";
echo str_repeat("=", 60) . "\n";
echo "✓ DEFAULT STATUS for new orders: 'pending'\n";
echo "✓ BUYER_CHECKOUT also gets order_status_id = 1 ('Order Placed')\n";
echo "✓ MANAGE_ORDERS only uses the status field = 'pending'\n";
echo "✓ Both tables use 'pending' as the initial status\n";
echo "\nThis explains why your manage-orders page needed the status mapping\n";
echo "from 'pending' → 'Active' to show new orders in the Active tab.\n";
