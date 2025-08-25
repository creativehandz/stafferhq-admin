<?php
// app/Http/Controllers/CheckoutController.php

namespace App\Http\Controllers;

use App\Mail\BuyerOrderConfirmation;
use App\Mail\SellerOrderNotification;
use App\Models\Notification;
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
            'json_data' => $request->json()->all(),
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

        // Validate incoming data
        $validatedData = $request->validate([
            'packageName' => 'required|string',
            'packageDescription' => 'required|string',
            'packagePrice' => 'required|numeric',
            'deliveryTime' => 'required|string',
            // 'revisions' => 'required|integer',
            'gigId' => 'required|integer',
            'billingDetails' => 'required|string',
        ]);

        // Store data to the database
        $buyerCheckout = BuyerCheckout::create([
            'user_id' => Auth::id(), // Get the logged-in user's ID
            'order_details' => json_encode([
                'packageDescription' => $validatedData['packageDescription'],
                'deliveryTime' => $validatedData['deliveryTime'],
                // 'revisions' => $validatedData['revisions'],
            ]), // Store order details as JSON
            'package_selected' => $validatedData['packageName'],
            'total_price' => $validatedData['packagePrice'],
            'gig_id' => $validatedData['gigId'],
            'billing_details' => $validatedData['billingDetails'],
        ]);

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
        // Retrieve all checkout data
        $buyer_checkout = BuyerCheckout::with('user')->get();

        // Render the data using Inertia
        return response()->json($buyer_checkout);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:active,paused,denied',
        ]);

        $buyerCheckout = BuyerCheckout::findOrFail($id);
        $buyerCheckout->status = $request->status;
        $buyerCheckout->save();

        return response()->json(['message' => 'Status updated successfully']);
    }


}
