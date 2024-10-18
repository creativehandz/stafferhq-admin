<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\BuyerCheckout;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validated = $request->validate([
                // 'user_id' => 'required|numeric',
                'order_details' => 'required|array', // Ensure it's an array
                'package_selected' => 'required|string|max:255',
                'total_price' => 'required|numeric', // Use numeric for decimals
                'gig_id' => 'required|numeric',
            ]);

            dd($validated);

            // Store the checkout data
            $checkout = BuyerCheckout::create([
                //'user_id' => $validated['user_id'],
                'order_details' => json_encode($validated['order_details']), // Store as JSON
                'package_selected' => $validated['package_selected'],
                'total_price' => $validated['total_price'],
                'gig_id' => $validated['gig_id'],
            ]);

            return response()->json(['success' => true, 'checkout' => $checkout], 201);
        } catch (ValidationException $e) {
            // Catch validation errors and return as JSON
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // General error handling
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
