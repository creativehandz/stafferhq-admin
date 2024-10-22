<?php
// app/Http/Controllers/CheckoutController.php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\BuyerCheckout;
use Illuminate\Support\Facades\Auth;

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
        BuyerCheckout::create([
            'user_id' => Auth::id(), // Get the logged-in user's ID
            'order_details' => json_encode([
                'packageDescription' => $validatedData['packageDescription'],
                'deliveryTime' => $validatedData['deliveryTime'],
                'revisions' => $validatedData['revisions']
            ]), // Store order details as JSON
            'package_selected' => $validatedData['packageName'],
            'total_price' => $validatedData['packagePrice'],
            'gig_id' => $validatedData['gigId'],
            'billing_details' => $validatedData['billingDetails'],
        ]);

        return response()->json([
            'message' => 'Checkout data stored successfully',
        ], 200);
    }
}
