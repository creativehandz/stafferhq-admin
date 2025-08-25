<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Minimal Laravel bootstrap
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

echo "Testing ManageOrder Controller Fix\n";
echo "===================================\n\n";

try {
    // Check if ManageOrder model can be loaded
    $manageOrderClass = new ReflectionClass('App\Models\ManageOrder');
    echo "✓ ManageOrder model found\n";
    
    // Get all orders in manage_orders table
    $allOrders = DB::table('manage_orders')->get();
    echo "Total orders in manage_orders table: " . count($allOrders) . "\n\n";
    
    // Show recent orders with details
    $recentOrders = DB::table('manage_orders')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();
    
    echo "Recent Orders:\n";
    foreach ($recentOrders as $order) {
        echo "- Order ID: {$order->id}\n";
        echo "  User ID: {$order->user_id}\n";
        echo "  Buyer: {$order->buyer}\n";
        echo "  Gig: {$order->gig}\n";
        echo "  Status: {$order->status}\n";
        echo "  Created: {$order->created_at}\n\n";
    }
    
    // Check users table to see available users
    $users = DB::table('users')
        ->select('id', 'name', 'email', 'role')
        ->limit(5)
        ->get();
    
    echo "Available Users:\n";
    foreach ($users as $user) {
        echo "- ID: {$user->id}, Name: {$user->name}, Role: {$user->role}\n";
    }
    echo "\n";
    
    // Test with a specific user ID (seller)
    $sellerId = $users->where('role', 'seller')->first()->id ?? 1;
    echo "Testing with seller ID: {$sellerId}\n";
    
    $sellerOrders = DB::table('manage_orders')
        ->where('user_id', $sellerId)
        ->get();
    
    echo "Orders for seller {$sellerId}: " . count($sellerOrders) . "\n";
    
    foreach ($sellerOrders as $order) {
        echo "- {$order->gig} ({$order->status})\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "\nTest completed!\n";
