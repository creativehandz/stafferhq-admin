<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\BuyerCheckout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Store a new review
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:buyer_checkout,id',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string|max:1000',
            'review_criteria' => 'nullable|array',
            'review_type' => 'required|in:buyer_to_seller,seller_to_buyer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get the order
            $order = BuyerCheckout::findOrFail($request->order_id);
            $currentUserId = Auth::id();
            
            // Determine reviewer and reviewee based on review type
            if ($request->review_type === 'seller_to_buyer') {
                // Seller reviewing buyer
                // Verify the current user is the seller (gig owner)
                if ($order->gig->user_id !== $currentUserId) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You are not authorized to review this buyer'
                    ], 403);
                }
                
                $reviewerId = $currentUserId; // seller
                $revieweeId = $order->user_id; // buyer
                
                // Check if seller already reviewed this buyer for this order
                if ($order->hasSellerReview()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You have already reviewed this buyer'
                    ], 409);
                }
                
            } else {
                // Buyer reviewing seller
                // Verify the current user is the buyer
                if ($order->user_id !== $currentUserId) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You are not authorized to review this seller'
                    ], 403);
                }
                
                $reviewerId = $currentUserId; // buyer
                $revieweeId = $order->gig->user_id; // seller
                
                // Check if buyer already reviewed this seller for this order
                if ($order->hasBuyerReview()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You have already reviewed this seller'
                    ], 409);
                }
            }
            
            // Create the review
            $review = Review::create([
                'order_id' => $request->order_id,
                'reviewer_id' => $reviewerId,
                'reviewee_id' => $revieweeId,
                'review_type' => $request->review_type,
                'rating' => $request->rating,
                'review_text' => $request->review_text,
                'review_criteria' => $request->review_criteria,
                'is_public' => true,
                'is_featured' => false,
                'reviewed_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Review submitted successfully',
                'review' => $review->load(['reviewer', 'reviewee'])
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating review: ' . $e->getMessage()
            ], 500);
        }
    }
}
