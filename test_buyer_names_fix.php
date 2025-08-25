<?php

require_once 'vendor/autoload.php';

// Bootstrap the Laravel application
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING BUYER NAMES AND AMOUNTS FIX ===\n\n";

// Simulate the CheckoutController's index method
$currentUserId = 3; // Seller user ID

// Get manage_orders data for the current seller
$manage_orders = DB::table('manage_orders')->where('user_id', $currentUserId)->get();

echo "BEFORE FIX (what was showing):\n";
foreach ($manage_orders as $order) {
    echo "Order {$order->id}: Buyer = '{$order->buyer}', Amount = " . ($order->amount ?? 'NULL') . "\n";
}

echo "\nAFTER FIX (what should show now):\n";
foreach ($manage_orders as $order) {
    // Simulate the new logic from CheckoutController
    $realBuyerName = $order->buyer; // Default to stored name
    
    // Look for corresponding buyer_checkout record with similar details
    $buyerCheckout = DB::table('buyer_checkout')
        ->leftJoin('users', 'buyer_checkout.user_id', '=', 'users.id')
        ->where('buyer_checkout.package_selected', $order->gig)
        ->where('buyer_checkout.total_price', $order->total)
        ->where('buyer_checkout.status', $order->status)
        ->select('buyer_checkout.*', 'users.name as buyer_name')
        ->first();
    
    if ($buyerCheckout && $buyerCheckout->buyer_name) {
        $realBuyerName = $buyerCheckout->buyer_name;
    }
    
    echo "Order {$order->id}: Buyer = '{$realBuyerName}', Total = {$order->total}\n";
    echo "  Details: Package='{$order->gig}', Status='{$order->status}'\n";
    if ($buyerCheckout) {
        echo "  Matched with buyer_checkout ID {$buyerCheckout->id} (User: {$buyerCheckout->buyer_name})\n";
    } else {
        echo "  No matching buyer_checkout found - using original name\n";
    }
    echo "---\n";
}

echo "\nFRONTEND DISPLAY:\n";
echo "The Vue component will now show:\n";
foreach ($manage_orders as $order) {
    $realBuyerName = $order->buyer;
    
    $buyerCheckout = DB::table('buyer_checkout')
        ->leftJoin('users', 'buyer_checkout.user_id', '=', 'users.id')
        ->where('buyer_checkout.package_selected', $order->gig)
        ->where('buyer_checkout.total_price', $order->total)
        ->where('buyer_checkout.status', $order->status)
        ->select('buyer_checkout.*', 'users.name as buyer_name')
        ->first();
    
    if ($buyerCheckout && $buyerCheckout->buyer_name) {
        $realBuyerName = $buyerCheckout->buyer_name;
    }
    
    echo "- Buyer: {$realBuyerName} | Package: {$order->gig} | Total: \${$order->total} | Status: {$order->status}\n";
}

?>
