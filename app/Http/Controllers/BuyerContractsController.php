<?php

namespace App\Http\Controllers;

use App\Models\BuyerCheckout;
use App\Models\User;
use App\Models\Gig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class BuyerContractsController extends Controller
{
    /**
     * Display all contracts for the authenticated buyer
     */
    public function index(): Response
    {
        $buyerId = Auth::id();
        
        // Get all orders placed by the current buyer from buyer_checkout table
        $contracts = BuyerCheckout::where('user_id', $buyerId)
            ->with(['orderStatus', 'gig', 'gig.user']) // Load relationships
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($checkout) {
                // Get seller information
                $seller = null;
                $sellerName = 'Unknown Seller';
                $sellerImage = null;
                
                if ($checkout->gig && $checkout->gig->user) {
                    $seller = $checkout->gig->user;
                    $sellerName = $seller->name;
                    $sellerImage = $seller->profile_image;
                } else {
                    // Fallback: try to get seller info from gig_id directly
                    if ($checkout->gig_id) {
                        $gig = Gig::with('user')->find($checkout->gig_id);
                        if ($gig && $gig->user) {
                            $seller = $gig->user;
                            $sellerName = $gig->user->name;
                            $sellerImage = $gig->user->profile_image;
                        }
                    }
                }
                
                // Parse order details if it's JSON
                $orderDetails = [];
                if ($checkout->order_details) {
                    $orderDetails = is_string($checkout->order_details) 
                        ? json_decode($checkout->order_details, true) 
                        : $checkout->order_details;
                }
                
                // Determine contract title - prioritize gig title over package name
                $contractTitle = $checkout->package_selected; // fallback
                $serviceTitle = null;
                
                if ($checkout->gig && $checkout->gig->gig_title) {
                    $serviceTitle = $checkout->gig->gig_title;
                    $contractTitle = $checkout->gig->gig_title;
                } elseif (isset($orderDetails['packageName'])) {
                    $contractTitle = $orderDetails['packageName'];
                }
                
                // Get delivery time
                $deliveryTime = null;
                if (isset($orderDetails['deliveryTime'])) {
                    $deliveryTime = $orderDetails['deliveryTime'];
                }
                
                // Determine status color and button text
                $statusInfo = $this->getStatusInfo($checkout->status);
                
                return [
                    'id' => $checkout->id,
                    'title' => $contractTitle,
                    'service_title' => $serviceTitle, // The main gig title
                    'package_selected' => $checkout->package_selected, // Package name (Basic, Standard, Premium)
                    'total_price' => $checkout->total_price,
                    'status' => $checkout->status,
                    'status_info' => $statusInfo,
                    'seller' => [
                        'id' => $seller ? $seller->id : null,
                        'name' => $sellerName,
                        'email' => $seller ? $seller->email : null,
                        'profile_image' => $sellerImage,
                        'profile_image_url' => $this->getProfileImageUrl($sellerImage),
                    ],
                    'delivery_time' => $deliveryTime,
                    'created_at' => $checkout->created_at,
                    'updated_at' => $checkout->updated_at,
                    'order_details' => $orderDetails,
                    'gig_id' => $checkout->gig_id,
                    'can_activate_milestone' => in_array($checkout->status, ['active', 'pending']),
                    'can_rehire' => in_array($checkout->status, ['completed', 'delivered']),
                ];
            });
        
        return Inertia::render('AllContracts', [
            'contracts' => $contracts,
            'totalContracts' => $contracts->count(),
            'activeContracts' => $contracts->where('status', 'active')->count(),
            'completedContracts' => $contracts->whereIn('status', ['completed', 'delivered'])->count(),
        ]);
    }
    
    /**
     * Get status information including color and display text
     */
    private function getStatusInfo($status)
    {
        $statusMap = [
            'pending' => [
                'color' => '#f59e0b', // yellow
                'bg_color' => '#fef3c7',
                'text' => 'Pending',
                'button_text' => 'Activate Milestone'
            ],
            'active' => [
                'color' => '#10b981', // green
                'bg_color' => '#d1fae5',
                'text' => 'Active',
                'button_text' => 'Activate Milestone'
            ],
            'completed' => [
                'color' => '#6b7280', // gray
                'bg_color' => '#f3f4f6',
                'text' => 'Completed',
                'button_text' => 'Rehire'
            ],
            'delivered' => [
                'color' => '#6b7280', // gray
                'bg_color' => '#f3f4f6',
                'text' => 'Delivered',
                'button_text' => 'Rehire'
            ],
            'Order Placed' => [
                'color' => '#3b82f6', // blue
                'bg_color' => '#dbeafe',
                'text' => 'Order Placed',
                'button_text' => 'Activate Milestone'
            ],
        ];
        
        return $statusMap[$status] ?? [
            'color' => '#6b7280',
            'bg_color' => '#f3f4f6',
            'text' => ucfirst($status),
            'button_text' => 'View Details'
        ];
    }
    
    /**
     * Get profile image URL with proper path handling
     */
    private function getProfileImageUrl($profileImage)
    {
        if (!$profileImage) {
            return 'https://www.svgrepo.com/show/497407/profile-circle.svg';
        }
        
        // If the path already starts with storage/, use it as is
        if (str_starts_with($profileImage, 'storage/')) {
            return "/{$profileImage}";
        }
        
        // If it starts with profile-images/, add storage/ prefix
        if (str_starts_with($profileImage, 'profile-images/')) {
            return "/storage/{$profileImage}";
        }
        
        // If it's just a filename, assume it's in storage/profile-images/
        return "/storage/profile-images/{$profileImage}";
    }
    
    /**
     * Activate milestone for a contract
     */
    public function activateMilestone(Request $request, $contractId)
    {
        $buyerId = Auth::id();
        
        $contract = BuyerCheckout::where('id', $contractId)
            ->where('user_id', $buyerId)
            ->firstOrFail();
        
        // Update status to active if it's pending or order placed
        if (in_array($contract->status, ['pending', 'Order Placed'])) {
            $contract->status = 'active';
            $contract->save();
            
            return redirect()->back()->with('success', 'Milestone activated successfully!');
        }
        
        return redirect()->back()->with('error', 'Cannot activate milestone for this contract.');
    }
}
