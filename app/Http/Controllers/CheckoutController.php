<?php
// app/Http/Controllers/CheckoutController.php

namespace App\Http\Controllers;

use App\Mail\BuyerOrderConfirmation;
use App\Mail\SellerOrderNotification;
use App\Models\Notification;
use App\Models\OrderStatus;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\BuyerCheckout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    // Store selected package details in session
    public function storePackage(Request $request)
    {
        $request->validate([
            'packageName' => 'required|string',
            'packagePrice' => 'required|numeric',
            'packageDescription' => 'nullable|string',
            'deliveryTime' => 'nullable|string',
            // 'revisions' => 'nullable|numeric',
            'gigId' => 'nullable|numeric',
        ]);

        // Store data in session
        session([
            'packageName' => $request->packageName,
            'packagePrice' => $request->packagePrice,
            'packageDescription' => $request->packageDescription,
            'deliveryTime' => $request->deliveryTime,
            // 'revisions' => $request->revisions,
            'gigId' => $request->gigId,
        ]);

        return response()->json(['message' => 'Package details stored in session'], 200);
    }

    public function showCheckout(Request $request)
    {
        // Get the package data from the session
        $package = session()->only(['packageName', 'packagePrice', 'packageDescription', 'deliveryTime', 
        // 'revisions', 
        'gigId']);

        if (empty($package)) {
            $package = [
                'packageName' => '',
                'packagePrice' => 0,
                'packageDescription' => '',
                'deliveryTime' => '',
                // 'revisions' => 0,
                'gigId' => 0,
            ];
        }

        // Return the Inertia view, passing the package data as props
        return Inertia::render('Jobs/Checkout', [
            'package' => $package
        ]);
    }
    // CheckoutController
    public function store(Request $request)
    {
        // Debug: Log incoming request data with detailed info
        \Log::info('🔍 Checkout Request Full Debug:', [
            'method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'all_data' => $request->all(),
            'input_data' => $request->input(),
            'json_data' => $request->json() ? $request->json()->all() : null,
            'raw_content' => $request->getContent(),
            'has_json' => $request->isJson(),
            'required_fields_check' => [
                'packageName' => $request->has('packageName') ? $request->get('packageName') : 'MISSING',
                'packageDescription' => $request->has('packageDescription') ? $request->get('packageDescription') : 'MISSING',
                'packagePrice' => $request->has('packagePrice') ? $request->get('packagePrice') : 'MISSING',
                'deliveryTime' => $request->has('deliveryTime') ? $request->get('deliveryTime') : 'MISSING',
                'gigId' => $request->has('gigId') ? $request->get('gigId') : 'MISSING',
                'billingDetails' => $request->has('billingDetails') ? $request->get('billingDetails') : 'MISSING',
            ]
        ]);

        // Try validation with detailed error catching
        try {
            $validatedData = $request->validate([
                'packageName' => 'required|string',
                'packageDescription' => 'required|string',
                'packagePrice' => 'required|numeric',
                'deliveryTime' => 'required|string',
                'gigId' => 'required|integer',
                'billingDetails' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('🚨 Validation Failed:', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'error' => 'Validation failed',
                'details' => $e->errors()
            ], 422);
        }

        // Handle billing details - convert any format to individual fields
        $billingDetailsRaw = $validatedData['billingDetails'];
        $billingFields = $this->processBillingDetails($billingDetailsRaw);

        // Prepare order details array
        $orderDetails = [
            'packageName' => $validatedData['packageName'],
            'packageDescription' => $validatedData['packageDescription'],
            'packagePrice' => $validatedData['packagePrice'],
            'deliveryTime' => $validatedData['deliveryTime'],
            'gigId' => $validatedData['gigId'],
            'created_at' => now()->toISOString(),
        ];

        // Get the default "Order Placed" status
                // Get order placed status
        $orderPlacedStatus = OrderStatus::where('name', 'Order Placed')->first();
        if (!$orderPlacedStatus) {
            return response()->json(['error' => 'Order status not found'], 500);
        }

        // Store data to the database
        // Create checkout record
        $buyerCheckout = BuyerCheckout::create([
            'user_id' => auth()->id(),
            'gig_id' => $validatedData['gigId'],
            'order_details' => $orderDetails,
            'billing_details' => $billingDetailsRaw, // Keep original for backward compatibility
            'package_selected' => $validatedData['packageName'],
            'total_price' => $validatedData['packagePrice'],
            'status' => $orderPlacedStatus->name, // Use the status name instead of hardcoded 'pending'
            'order_status_id' => $orderPlacedStatus->id,
            // Individual billing fields
            'billing_full_name' => $billingFields['name'] ?? null,
            'billing_company_name' => $billingFields['company'] ?? null,
            'billing_email' => $billingFields['email'] ?? null,
            'billing_phone' => $billingFields['phone'] ?? null,
            'billing_address' => $billingFields['address'] ?? null,
            'billing_city' => $billingFields['city'] ?? null,
            'billing_state' => $billingFields['state'] ?? null,
            'billing_country' => $billingFields['country'] ?? null,
            'billing_postal_code' => $billingFields['postal_code'] ?? $billingFields['zip'] ?? null,
            'billing_citizen_resident' => $this->convertToBoolean($billingFields['citizen_resident'] ?? null),
            'billing_tax_category' => $billingFields['tax_category'] ?? null,
            'billing_want_invoices' => $this->convertToBoolean($billingFields['want_invoices'] ?? null),
        ]);

        // Create initial status history entry if status was set
        if ($orderPlacedStatus) {
            try {
                $buyerCheckout->statusHistory()->create([
                    'order_status_id' => $orderPlacedStatus->id,
                    'changed_by_user_id' => Auth::id(),
                    'notes' => 'Order placed by buyer',
                    'changed_at' => now(),
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to create status history:', [
                    'error' => $e->getMessage(),
                    'buyer_checkout_id' => $buyerCheckout->id,
                    'order_status_id' => $orderPlacedStatus->id
                ]);
                // Continue even if status history fails
            }
        }

            // Fetch the seller's email based on the gig_id
            $gig = DB::table('gigs')->where('id', $validatedData['gigId'])->first();
            $seller = DB::table('users')->where('id', $gig->user_id)->first();
            $sellerEmail = $seller->email;
        
            // Send email to the seller
            Mail::to($sellerEmail)->send(new SellerOrderNotification($buyerCheckout));

            // Create notification for the seller
            Notification::create([
                'user_id' => $seller->id,
                'title' => 'New Order Received',
                'message' => 'You have received a new order for "' . $validatedData['packageName'] . '" worth $' . number_format($validatedData['packagePrice'], 2),
                'type' => 'order',
                'data' => json_encode([
                    'order_id' => $buyerCheckout->id,
                    'gig_id' => $validatedData['gigId'],
                    'package_name' => $validatedData['packageName'],
                    'package_price' => $validatedData['packagePrice'],
                    'buyer_name' => Auth::user()->name,
                    'buyer_email' => Auth::user()->email,
                ]),
                'route' => '/dashboard/orders/' . $buyerCheckout->id,
                'is_read' => false
            ]);

                // Fetch the buyer's email (currently authenticated user)
            $buyerEmail = Auth::user()->email;

            // Send email to the buyer
            Mail::to($buyerEmail)->send(new BuyerOrderConfirmation($buyerCheckout));
            

        // Return buyer_checkout_id in the response
        return response()->json([
            'message' => 'Checkout data stored successfully',
            'buyer_checkout_id' => $buyerCheckout->id,  // Return the checkout ID
        ], 200);
    }
    // Method to show all checkout data
    public function index()
    {
        // Get the currently authenticated user ID
        $currentUserId = Auth::id();
        
        // Retrieve checkout data from buyer_checkout table
        $buyer_checkout = BuyerCheckout::with(['user', 'orderStatus'])->get();

        // Transform buyer_checkout data
        $buyerCheckoutData = $buyer_checkout->map(function ($checkout) {
            return [
                'id' => 'bc_' . $checkout->id, // Prefix to distinguish from manage_orders
                'user_id' => $checkout->user_id,
                'order_details' => $checkout->order_details,
                'package_selected' => $checkout->package_selected,
                'total_price' => $checkout->total_price,
                'gig_id' => $checkout->gig_id,
                'billing_details' => $checkout->billing_details,
                'created_at' => $checkout->created_at,
                'updated_at' => $checkout->updated_at,
                'user' => $checkout->user,
                'status' => $checkout->getCurrentStatusName(),
                'status_info' => $checkout->orderStatus ? [
                    'id' => $checkout->orderStatus->id,
                    'name' => $checkout->orderStatus->name,
                    'slug' => $checkout->orderStatus->slug,
                    'color' => $checkout->orderStatus->color,
                    'description' => $checkout->orderStatus->description,
                ] : null,
                'source' => 'buyer_checkout'
            ];
        });

        // Get manage_orders data for the current seller
        $manage_orders = \App\Models\ManageOrder::forUser($currentUserId)->get();
        
        // Transform manage_orders data to match the expected format
        $manageOrdersData = $manage_orders->map(function ($order) {
            // Keep original status - no mapping needed
            $originalStatus = $order->status;
            
            // Find corresponding order status info from order_statuses table
            $orderStatus = \App\Models\OrderStatus::where('name', $originalStatus)->first();
            
            // If no matching status found in order_statuses table, create a default
            if (!$orderStatus) {
                $orderStatus = (object)[
                    'id' => 0,
                    'name' => $originalStatus,
                    'slug' => strtolower($originalStatus),
                    'color' => '#6B7280', // Default gray color
                    'description' => 'Order status'
                ];
            }
            
            // Try to get real buyer information from buyer_checkout table
            $realBuyer = null;
            $realBuyerName = $order->buyer; // Default to stored name
            
            // Look for corresponding buyer_checkout record with similar details
            $buyerCheckout = \App\Models\BuyerCheckout::where('package_selected', $order->gig)
                ->where('total_price', $order->total)
                ->where('status', $originalStatus)
                ->first();
            
            if ($buyerCheckout && $buyerCheckout->user) {
                $realBuyerName = $buyerCheckout->user->name;
                $realBuyer = $buyerCheckout->user;
            }
            
            return [
                'id' => 'mo_' . $order->id, // Prefix to distinguish from buyer_checkout
                'user_id' => $order->user_id,
                'order_details' => json_encode([
                    'gig' => $order->gig,
                    'buyer' => $realBuyerName, // Use real buyer name
                    'description' => $order->description ?? 'Order from seller dashboard'
                ]),
                'package_selected' => $order->gig ?? 'Basic',
                'total_price' => $order->total ?? 0, // Use 'total' field instead of 'amount'
                'gig_id' => $order->gig_id ?? null,
                'billing_details' => json_encode([
                    'buyer_name' => $realBuyerName // Use real buyer name
                ]),
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
                'user' => $realBuyer ?? ['id' => $order->user_id, 'name' => $realBuyerName], // Use real buyer info
                'status' => $originalStatus, // Keep the original status from database
                'status_info' => [
                    'id' => $orderStatus->id,
                    'name' => $orderStatus->name,
                    'slug' => $orderStatus->slug,
                    'color' => $orderStatus->color,
                    'description' => $orderStatus->description,
                ],
                'source' => 'manage_orders'
            ];
        });

        // Combine both data sources
        $allOrders = $buyerCheckoutData->concat($manageOrdersData);
        
        // Sort by created_at descending (newest first)
        $sortedOrders = $allOrders->sortByDesc('created_at')->values();

        return response()->json($sortedOrders);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $buyerCheckout = BuyerCheckout::findOrFail($id);
        
        // Find the order status by name
        $orderStatus = \App\Models\OrderStatus::where('name', $request->status)->first();
        
        if (!$orderStatus) {
            return response()->json(['error' => 'Invalid status'], 400);
        }

        // Update status using the new method that creates history
        $buyerCheckout->updateStatus(
            $orderStatus->id,
            Auth::id(),
            $request->notes,
            $request->metadata ?? null
        );

        return response()->json([
            'message' => 'Status updated successfully',
            'status' => $orderStatus->name,
            'status_info' => [
                'id' => $orderStatus->id,
                'name' => $orderStatus->name,
                'slug' => $orderStatus->slug,
                'color' => $orderStatus->color,
                'description' => $orderStatus->description,
            ]
        ]);
    }

    /**
     * Process billing details from any format into structured array
     */
    private function processBillingDetails($billingDetailsRaw)
    {
        \Log::info('🔍 Processing Billing Details:', [
            'type' => gettype($billingDetailsRaw),
            'value' => $billingDetailsRaw
        ]);
        
        if (is_array($billingDetailsRaw)) {
            // Already an array, just normalize the keys
            return $this->normalizeBillingKeys($billingDetailsRaw);
        }
        
        if (is_string($billingDetailsRaw)) {
            // Check if it's a formatted text string
            if (strpos($billingDetailsRaw, ':') !== false && strpos($billingDetailsRaw, '\n') !== false) {
                return $this->parseFormattedBillingText($billingDetailsRaw);
            }
            
            // Try to decode as JSON
            $decoded = json_decode($billingDetailsRaw, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $this->normalizeBillingKeys($decoded);
            }
        }
        
        \Log::error('❌ Could not process billing details:', [
            'type' => gettype($billingDetailsRaw),
            'value' => $billingDetailsRaw
        ]);
        
        return [];
    }
    
    /**
     * Normalize billing keys to standard format
     */
    private function normalizeBillingKeys($billingArray)
    {
        $normalized = [];
        
        foreach ($billingArray as $key => $value) {
            $normalizedKey = $this->normalizeKey($key);
            $normalized[$normalizedKey] = $value;
        }
        
        return $normalized;
    }
    
    /**
     * Convert string values to boolean
     */
    private function convertToBoolean($value)
    {
        if (is_bool($value)) {
            return $value;
        }
        
        if (is_string($value)) {
            return in_array(strtolower($value), ['yes', 'true', '1', 'on']);
        }
        
        return null;
    }

    /**
     * Parse formatted billing text into structured array
     */
    private function parseFormattedBillingText($formattedText)
    {
        $billingDetails = [];
        
        // Replace literal \n with actual newlines
        $text = str_replace('\\n', "\n", $formattedText);
        
        // Split by lines
        $lines = explode("\n", $text);
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            
            // Split by colon to get key and value
            $parts = explode(':', $line, 2);
            if (count($parts) === 2) {
                $key = trim($parts[0]);
                $value = trim($parts[1]);
                
                // Convert key to a more standard format
                $normalizedKey = $this->normalizeKey($key);
                $billingDetails[$normalizedKey] = $value;
            }
        }
        
        return $billingDetails;
    }
    
    /**
     * Normalize keys to standard format
     */
    private function normalizeKey($key)
    {
        $keyMap = [
            'Full Name' => 'name',
            'Company Name' => 'company',
            'Country' => 'country',
            'State' => 'state',
            'Address' => 'address',
            'City' => 'city',
            'Postal Code' => 'postal_code',
            'Citizen/Resident' => 'citizen_resident',
            'Tax Category' => 'tax_category',
            'Want Invoices' => 'want_invoices',
            'email' => 'email',
            'phone' => 'phone',
            'zip' => 'postal_code',
        ];
        
        return $keyMap[$key] ?? strtolower(str_replace([' ', '/'], ['_', '_'], $key));
    }


}
