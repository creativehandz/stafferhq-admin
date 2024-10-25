<?php
// app/Http/Controllers/CheckoutController.php

namespace App\Http\Controllers;

use App\Mail\BuyerOrderConfirmation;
use App\Mail\SellerOrderNotification;
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
            'revisions' => 'nullable|numeric',
            'gigId' => 'nullable|numeric',
        ]);

        // Store data in session
        session([
            'packageName' => $request->packageName,
            'packagePrice' => $request->packagePrice,
            'packageDescription' => $request->packageDescription,
            'deliveryTime' => $request->deliveryTime,
            'revisions' => $request->revisions,
            'gigId' => $request->gigId,
        ]);

        return response()->json(['message' => 'Package details stored in session'], 200);
    }

    public function showCheckout(Request $request)
    {
        // Get the package data from the session
        $package = session()->only(['packageName', 'packagePrice', 'packageDescription', 'deliveryTime', 'revisions', 'gigId']);

        if (empty($package)) {
            $package = [
                'packageName' => '',
                'packagePrice' => 0,
                'packageDescription' => '',
                'deliveryTime' => '',
                'revisions' => 0,
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
        // Validate incoming data
        $validatedData = $request->validate([
            'packageName' => 'required|string',
            'packageDescription' => 'required|string',
            'packagePrice' => 'required|numeric',
            'deliveryTime' => 'required|string',
            'revisions' => 'required|integer',
            'gigId' => 'required|integer',
            'billingDetails' => 'required|string',
        ]);

        // Store data to the database
        $buyerCheckout = BuyerCheckout::create([
            'user_id' => Auth::id(), // Get the logged-in user's ID
            'order_details' => json_encode([
                'packageDescription' => $validatedData['packageDescription'],
                'deliveryTime' => $validatedData['deliveryTime'],
                'revisions' => $validatedData['revisions'],
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

}
