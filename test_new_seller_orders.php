<?php

require_once 'vendor/autoload.php';

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\BuyerCheckout;
use App\Models\Gig;
use Illuminate\Support\Facades\Auth;

echo "=== TESTING SELLER ORDERS ===\n\n";

// Simulate logged in seller (user ID 3 is a seller)
Auth::loginUsingId(3);
$sellerId = Auth::id();

echo "1. Testing for seller ID: {$sellerId}\n\n";

// Test the query from OrderController
echo "2. BuyerCheckout orders for this seller:\n";
$orders = BuyerCheckout::whereHas('gig', function($query) use ($sellerId) {
        $query->where('user_id', $sellerId);
    })
    ->with(['orderStatus', 'gig', 'gig.user', 'user'])
    ->orderBy('created_at', 'desc')
    ->get();

if ($orders->count() > 0) {
    foreach ($orders as $checkout) {
        $buyer = $checkout->user;
        $buyerName = $buyer ? $buyer->name : 'Unknown Buyer';
        
        $gig = $checkout->gig;
        $gigTitle = $gig ? $gig->gig_title : 'Unknown Gig';
        
        echo "   Order ID: {$checkout->id}\n";
        echo "   Buyer: {$buyerName}\n";
        echo "   Gig: {$gigTitle}\n";
        echo "   Status: {$checkout->status}\n";
        echo "   Total: ₹{$checkout->total_price}\n";
        echo "   ---\n";
    }
} else {
    echo "   No orders found for this seller.\n";
}

echo "\n3. Available gigs for this seller:\n";
$gigs = Gig::where('user_id', $sellerId)->get(['id', 'gig_title']);
foreach ($gigs as $gig) {
    echo "   Gig ID: {$gig->id}, Title: {$gig->gig_title}\n";
}

echo "\n4. All BuyerCheckout orders (checking gig relationships):\n";
$allCheckouts = BuyerCheckout::with(['gig'])->get(['id', 'gig_id', 'status']);
foreach ($allCheckouts as $checkout) {
    $gigOwner = $checkout->gig ? $checkout->gig->user_id : 'No gig';
    echo "   Order ID: {$checkout->id}, Gig ID: {$checkout->gig_id}, Gig Owner: {$gigOwner}, Status: {$checkout->status}\n";
}

?>
