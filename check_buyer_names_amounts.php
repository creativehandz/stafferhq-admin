<?php

require_once 'vendor/autoload.php';

// Bootstrap the Laravel application
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING BUYER NAMES AND AMOUNTS ===\n\n";

// Check manage_orders table
echo "1. MANAGE_ORDERS TABLE:\n";
$manageOrders = DB::table('manage_orders')->get();
foreach ($manageOrders as $order) {
    echo "ID: {$order->id}\n";
    echo "  Buyer: '{$order->buyer}'\n";
    echo "  Gig: '{$order->gig}'\n";
    echo "  Total: {$order->total}\n";
    echo "  User ID: {$order->user_id}\n";
    echo "  Status: {$order->status}\n";
    echo "  Created: {$order->created_at}\n";
    echo "---\n";
}

echo "\n2. BUYER_CHECKOUT TABLE:\n";
$buyerCheckouts = DB::table('buyer_checkout')->get();
foreach ($buyerCheckouts as $checkout) {
    echo "ID: {$checkout->id}\n";
    echo "  User ID: {$checkout->user_id}\n";
    echo "  Package: '{$checkout->package_selected}'\n";
    echo "  Total Price: {$checkout->total_price}\n";
    echo "  Status: {$checkout->status}\n";
    echo "  Billing Name: {$checkout->billing_full_name}\n";
    echo "  Created: {$checkout->created_at}\n";
    echo "---\n";
}

echo "\n3. USERS TABLE (for buyer name lookup):\n";
$users = DB::table('users')->get();
foreach ($users as $user) {
    echo "ID: {$user->id} - Name: '{$user->name}' - Email: {$user->email}\n";
}

echo "\n4. CHECKING CONTROLLER OUTPUT:\n";
// Simulate the CheckoutController's index method transformation
echo "Current CheckoutController transformation for manage_orders:\n";

$currentUserId = 3; // Assuming seller user ID is 3
$manage_orders = DB::table('manage_orders')->where('user_id', $currentUserId)->get();

foreach ($manage_orders as $order) {
    echo "Order ID: {$order->id}\n";
    echo "  Raw buyer field: '{$order->buyer}'\n";
    echo "  Raw total field: " . (isset($order->total) ? $order->total : 'NULL') . "\n";
    echo "  Controller shows buyer as: '{$order->buyer}'\n";
    echo "  Controller shows total as: " . ($order->total ?? 0) . "\n";
    echo "---\n";
}

?>
