<?php

require_once 'vendor/autoload.php';

// Boot Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->handle(
    Illuminate\Http\Request::capture()
);

use App\Models\BuyerCheckout;
use App\Models\Review;

echo "=== Checking Seller Review Data ===\n\n";

// Get completed orders
$completedOrders = BuyerCheckout::whereHas('gig', function($query) {
    // Get orders for any seller - we'll check the first one
})
->with(['orderStatus', 'gig', 'gig.user', 'user', 'buyerReviews', 'sellerReviews'])
->where('status', 'Completed')
->get();

echo "Found " . $completedOrders->count() . " completed orders\n\n";

foreach ($completedOrders as $order) {
    echo "Order ID: " . $order->id . "\n";
    echo "Buyer: " . ($order->user ? $order->user->name : 'Unknown') . "\n";
    echo "Seller: " . ($order->gig && $order->gig->user ? $order->gig->user->name : 'Unknown') . "\n";
    echo "Status: " . $order->status . "\n";
    
    // Check buyer reviews (buyer reviewing seller)
    $buyerReviews = $order->buyerReviews;
    echo "Buyer Reviews: " . $buyerReviews->count() . "\n";
    if ($buyerReviews->count() > 0) {
        foreach ($buyerReviews as $review) {
            echo "  - Rating: " . $review->rating . "/5\n";
            echo "  - Text: " . substr($review->review_text, 0, 50) . "...\n";
        }
    }
    
    // Check seller reviews (seller reviewing buyer)
    $sellerReviews = $order->sellerReviews;
    echo "Seller Reviews: " . $sellerReviews->count() . "\n";
    if ($sellerReviews->count() > 0) {
        foreach ($sellerReviews as $review) {
            echo "  - Rating: " . $review->rating . "/5\n";
            echo "  - Text: " . substr($review->review_text, 0, 50) . "...\n";
        }
    }
    
    echo "Has Buyer Review: " . ($order->hasBuyerReview() ? 'Yes' : 'No') . "\n";
    echo "Has Seller Review: " . ($order->hasSellerReview() ? 'Yes' : 'No') . "\n";
    
    echo "---\n\n";
}

echo "=== Review Type Statistics ===\n";
$buyerToSellerReviews = Review::where('review_type', 'buyer_to_seller')->count();
$sellerToBuyerReviews = Review::where('review_type', 'seller_to_buyer')->count();

echo "Total buyer_to_seller reviews: " . $buyerToSellerReviews . "\n";
echo "Total seller_to_buyer reviews: " . $sellerToBuyerReviews . "\n";

?>
