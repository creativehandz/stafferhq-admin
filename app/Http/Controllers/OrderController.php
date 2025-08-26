<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BuyerCheckout;
use App\Models\Gig;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function getOrdersByStatus(): Response
    {
        $sellerId = Auth::id();
        
        // Get orders for the currently authenticated seller from buyer_checkout table
        // where the gig belongs to this seller
        $orders = BuyerCheckout::whereHas('gig', function($query) use ($sellerId) {
                $query->where('user_id', $sellerId);
            })
            ->with(['orderStatus', 'gig', 'gig.user', 'user', 'buyerReviews', 'buyerReviews.reviewer', 'sellerReviews', 'sellerReviews.reviewer']) // Load relationships
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($checkout) {
                // Get buyer information
                $buyer = $checkout->user;
                $buyerName = $buyer ? $buyer->name : 'Unknown Buyer';
                
                // Get gig information
                $gig = $checkout->gig;
                $gigTitle = $gig ? $gig->gig_title : 'Unknown Gig';
                
                // Parse order details if it's JSON
                $orderDetails = [];
                if ($checkout->order_details) {
                    $orderDetails = is_string($checkout->order_details) 
                        ? json_decode($checkout->order_details, true) 
                        : $checkout->order_details;
                }
                
                // Get delivery time
                $deliveryTime = null;
                if (isset($orderDetails['deliveryTime'])) {
                    $deliveryTime = $orderDetails['deliveryTime'];
                }
                
                return [
                    'id' => $checkout->id,
                    'buyer' => $buyerName,
                    'gig' => $gigTitle,
                    'package_selected' => $checkout->package_selected,
                    'total_price' => $checkout->total_price,
                    'status' => $checkout->status,
                    'order_details' => $orderDetails,
                    'delivery_time' => $deliveryTime,
                    'due_on' => $deliveryTime, // Use delivery time as due date
                    'total' => $checkout->total_price,
                    'note' => isset($orderDetails['note']) ? $orderDetails['note'] : null,
                    'created_at' => $checkout->created_at,
                    'updated_at' => $checkout->updated_at,
                    'user_id' => $checkout->user_id, // buyer user ID
                    'gig_id' => $checkout->gig_id,
                    'buyer_review' => $checkout->buyerReviews->first(), // Get buyer's review of seller
                    'has_buyer_review' => $checkout->hasBuyerReview(),
                    'seller_review' => $checkout->sellerReviews->first(), // Get seller's review of buyer
                    'has_seller_review' => $checkout->hasSellerReview(),
                ];
            });

        // Group orders by status for better display
        $ordersByStatus = [
            'pending' => $orders->where('status', 'pending'),
            'active' => $orders->where('status', 'active'),
            'completed' => $orders->where('status', 'completed'),
            'delivered' => $orders->where('status', 'delivered'),
        ];

        return Inertia::render('Talent/YourActiveContracts', [
            'orders' => $orders,
            'ordersByStatus' => $ordersByStatus,
            'stats' => [
                'total' => $orders->count(),
                'pending' => $orders->where('status', 'pending')->count(),
                'active' => $orders->where('status', 'active')->count(),
                'completed' => $orders->where('status', 'completed')->count(),
                'delivered' => $orders->where('status', 'delivered')->count(),
                'overdue' => 0, // Will implement later if needed
                'due_soon' => 0, // Will implement later if needed
            ]
        ]);
    }
    
    /**
     * Get orders for AJAX calls (returns JSON)
     */
    public function getSellerOrdersJson()
    {
        $sellerId = Auth::id();
        
        // Get orders for the currently authenticated seller from buyer_checkout table
        $orders = BuyerCheckout::whereHas('gig', function($query) use ($sellerId) {
                $query->where('user_id', $sellerId);
            })
            ->with(['orderStatus', 'gig', 'gig.user', 'user', 'buyerReviews', 'buyerReviews.reviewer', 'sellerReviews', 'sellerReviews.reviewer']) // Load relationships
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($checkout) {
                // Get buyer information
                $buyer = $checkout->user;
                $buyerName = $buyer ? $buyer->name : 'Unknown Buyer';
                
                // Get gig information
                $gig = $checkout->gig;
                $gigTitle = $gig ? $gig->gig_title : 'Unknown Gig';
                
                // Parse order details if it's JSON
                $orderDetails = [];
                if ($checkout->order_details) {
                    $orderDetails = is_string($checkout->order_details) 
                        ? json_decode($checkout->order_details, true) 
                        : $checkout->order_details;
                }
                
                // Get delivery time
                $deliveryTime = null;
                if (isset($orderDetails['deliveryTime'])) {
                    $deliveryTime = $orderDetails['deliveryTime'];
                }
                
                return [
                    'id' => $checkout->id,
                    'order_details' => json_encode($orderDetails),
                    'billing_details' => json_encode([
                        'buyer_name' => $buyerName
                    ]),
                    'package_selected' => $checkout->package_selected,
                    'total_price' => $checkout->total_price,
                    'status' => $checkout->status,
                    'source' => 'buyer_checkout',
                    'buyer_review' => $checkout->buyerReviews->first(), // Get buyer's review of seller
                    'has_buyer_review' => $checkout->hasBuyerReview(),
                    'seller_review' => $checkout->sellerReviews->first(), // Get seller's review of buyer
                    'has_seller_review' => $checkout->hasSellerReview(),
                    'user' => [
                        'id' => $buyer ? $buyer->id : null,
                        'name' => $buyerName
                    ]
                ];
            });

        return response()->json($orders);
    }
}
