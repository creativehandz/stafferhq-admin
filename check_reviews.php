<?php

require_once 'vendor/autoload.php';

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Review;
use App\Models\BuyerCheckout;

echo "=== CHECKING BUYER REVIEWS ===\n\n";

// Check buyer to seller reviews
echo "1. Buyer to Seller Reviews:\n";
$buyerReviews = Review::where('review_type', 'buyer_to_seller')
    ->with(['reviewer', 'reviewee'])
    ->get();

foreach ($buyerReviews as $review) {
    echo "   Order ID: {$review->order_id}\n";
    echo "   Rating: {$review->rating}/5\n";
    echo "   Review: " . substr($review->review_text, 0, 80) . "...\n";
    echo "   Reviewer: {$review->reviewer->name}\n";
    echo "   Reviewee: {$review->reviewee->name}\n";
    echo "   ---\n";
}

echo "\n2. Checking completed orders with reviews:\n";
$completedOrders = BuyerCheckout::whereIn('status', ['Completed', 'completed'])
    ->with(['buyerReviews', 'buyerReviews.reviewer'])
    ->get();

foreach ($completedOrders as $order) {
    echo "   Order ID: {$order->id}\n";
    echo "   Status: {$order->status}\n";
    echo "   Has buyer review: " . ($order->hasBuyerReview() ? 'Yes' : 'No') . "\n";
    
    if ($order->hasBuyerReview()) {
        $review = $order->buyerReviews->first();
        echo "   Review rating: {$review->rating}/5\n";
        echo "   Review text: " . substr($review->review_text, 0, 50) . "...\n";
    }
    echo "   ---\n";
}

echo "\n=== REVIEW CHECK COMPLETE ===\n";

?>
