<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Set up the Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';

// Boot the application
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "🔍 Testing Checkout Flow - Checking Tables\n";
echo "=========================================\n\n";

try {
    // Check BuyerCheckout records
    echo "📋 BuyerCheckout Records:\n";
    $buyerCheckouts = DB::table('buyer_checkout')->get();
    foreach ($buyerCheckouts as $checkout) {
        echo "ID: {$checkout->id}, User: {$checkout->user_id}, Status: {$checkout->status}, Package: {$checkout->package_selected}, Price: {$checkout->total_price}\n";
    }
    echo "\nTotal BuyerCheckout records: " . $buyerCheckouts->count() . "\n\n";

    // Check ManageOrder records
    echo "📦 ManageOrder Records:\n";
    $orders = DB::table('manage_orders')->get();
    foreach ($orders as $order) {
        echo "ID: {$order->id}, Seller: {$order->user_id}, Buyer: {$order->buyer}, Gig: {$order->gig}, Status: {$order->status}, Total: {$order->total}\n";
    }
    echo "\nTotal ManageOrder records: " . $orders->count() . "\n\n";

    // Check Gigs
    echo "🎯 Available Gigs:\n";
    $gigs = DB::table('gigs')->get();
    foreach ($gigs as $gig) {
        echo "ID: {$gig->id}, Seller: {$gig->user_id}, Title: {$gig->gig_title}\n";
    }
    echo "\nTotal Gigs: " . $gigs->count() . "\n\n";

    // Check Users with roles
    echo "👥 Users and Roles:\n";
    $users = DB::table('users')->get();
    foreach ($users as $user) {
        $roleText = match($user->role) {
            1 => 'Buyer',
            2 => 'Seller', 
            3 => 'Admin',
            default => 'Unknown'
        };
        echo "ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role: {$roleText} ({$user->role})\n";
    }
    echo "\nTotal Users: " . $users->count() . "\n\n";

    echo "✅ Test completed successfully!\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
