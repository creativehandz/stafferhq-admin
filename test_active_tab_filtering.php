<?php

require_once 'vendor/autoload.php';

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\BuyerCheckout;
use Illuminate\Support\Facades\Auth;

echo "=== TESTING ACTIVE TAB FILTERING ===\n\n";

// Simulate logged in seller (user ID 3)
Auth::loginUsingId(3);
$sellerId = Auth::id();

echo "Testing for seller ID: {$sellerId}\n\n";

// Get all orders for this seller
$orders = BuyerCheckout::whereHas('gig', function($query) use ($sellerId) {
        $query->where('user_id', $sellerId);
    })
    ->with(['gig', 'user'])
    ->orderBy('created_at', 'desc')
    ->get();

echo "Total orders: " . $orders->count() . "\n\n";

// Check order statuses
$statusCounts = [];
foreach ($orders as $order) {
    $status = $order->status;
    $statusCounts[$status] = ($statusCounts[$status] ?? 0) + 1;
}

echo "Order status breakdown:\n";
foreach ($statusCounts as $status => $count) {
    echo "   {$status}: {$count} orders\n";
}

echo "\n=== ACTIVE TAB FILTERING ===\n";
echo "Orders that should appear in Active tab:\n";
echo "(Status: 'Active', 'active', or 'Order Accepted')\n\n";

$activeOrders = $orders->filter(function($order) {
    return in_array($order->status, ['Active', 'active', 'Order Accepted']);
});

foreach ($activeOrders as $order) {
    $buyer = $order->user;
    $buyerName = $buyer ? $buyer->name : 'Unknown Buyer';
    $gig = $order->gig;
    $gigTitle = $gig ? $gig->gig_title : 'Unknown Gig';
    
    echo "   Order ID: {$order->id}\n";
    echo "   Status: {$order->status}\n";
    echo "   Buyer: {$buyerName}\n";
    echo "   Gig: {$gigTitle}\n";
    echo "   Total: ₹{$order->total_price}\n";
    echo "   ---\n";
}

echo "\nActive tab should show: " . $activeOrders->count() . " orders\n";

?>
