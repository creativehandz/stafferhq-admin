<?php

require_once 'vendor/autoload.php';

// Bootstrap the Laravel application
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== ANALYZING BUYER ORDERS FOR ALL-CONTRACTS PAGE ===\n\n";

// Get buyer user (role = 1)
$buyerUser = DB::table('users')->where('role', 1)->first();
if (!$buyerUser) {
    echo "❌ No buyer user found!\n";
    exit;
}

echo "Found buyer: {$buyerUser->name} (ID: {$buyerUser->id}, Email: {$buyerUser->email})\n\n";

// Check buyer_checkout table for orders placed by this buyer
echo "1. ORDERS IN BUYER_CHECKOUT TABLE:\n";
$buyerCheckouts = DB::table('buyer_checkout')
    ->where('user_id', $buyerUser->id)
    ->leftJoin('users as seller', function($join) {
        $join->on('buyer_checkout.gig_id', '=', 'seller.id')
             ->orWhere(function($query) {
                 // Try to find seller via gig table if gig_id exists
                 $query->whereExists(function($subQuery) {
                     $subQuery->select(DB::raw(1))
                              ->from('gigs')
                              ->whereColumn('gigs.id', 'buyer_checkout.gig_id')
                              ->whereColumn('gigs.user_id', 'seller.id');
                 });
             });
    })
    ->select('buyer_checkout.*', 'seller.name as seller_name', 'seller.email as seller_email')
    ->get();

if ($buyerCheckouts->count() > 0) {
    foreach ($buyerCheckouts as $order) {
        echo "Order ID: {$order->id}\n";
        echo "  Package: {$order->package_selected}\n";
        echo "  Price: \${$order->total_price}\n";
        echo "  Status: {$order->status}\n";
        echo "  Seller: " . ($order->seller_name ?: 'Unknown') . "\n";
        echo "  Created: {$order->created_at}\n";
        echo "---\n";
    }
} else {
    echo "No orders found in buyer_checkout table for this buyer.\n";
}

// Also check if there are any orders in manage_orders where buyer name matches
echo "\n2. ORDERS IN MANAGE_ORDERS TABLE (where buyer name might match):\n";
$manageOrders = DB::table('manage_orders')
    ->where('buyer', 'like', '%' . $buyerUser->name . '%')
    ->orWhere('buyer', 'like', '%' . explode('@', $buyerUser->email)[0] . '%')
    ->leftJoin('users as seller', 'manage_orders.user_id', '=', 'seller.id')
    ->select('manage_orders.*', 'seller.name as seller_name', 'seller.email as seller_email')
    ->get();

if ($manageOrders->count() > 0) {
    foreach ($manageOrders as $order) {
        echo "Order ID: {$order->id}\n";
        echo "  Gig: {$order->gig}\n";
        echo "  Buyer: {$order->buyer}\n";
        echo "  Total: \${$order->total}\n";
        echo "  Status: {$order->status}\n";
        echo "  Seller: " . ($order->seller_name ?: 'Unknown') . "\n";
        echo "  Created: {$order->created_at}\n";
        echo "---\n";
    }
} else {
    echo "No matching orders found in manage_orders table.\n";
}

echo "\n3. GIGS TABLE (to understand seller relationships):\n";
$gigs = DB::table('gigs')
    ->leftJoin('users', 'gigs.user_id', '=', 'users.id')
    ->select('gigs.id', 'gigs.gig_title', 'gigs.user_id', 'users.name as seller_name')
    ->limit(5)
    ->get();

foreach ($gigs as $gig) {
    echo "Gig ID: {$gig->id} - {$gig->gig_title} (Seller: {$gig->seller_name})\n";
}

echo "\n=== RECOMMENDATIONS FOR IMPLEMENTATION ===\n";
echo "✅ Use buyer_checkout table as primary data source\n";
echo "✅ Join with gigs table to get seller information\n";
echo "✅ Join with users table to get seller names\n";
echo "✅ Display: Package name, price, seller info, status, dates\n";
echo "✅ Filter by current logged-in buyer (Auth::id())\n";

?>
