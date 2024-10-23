<?php
namespace App\Http\Controllers;

use App\Models\BillingDetail;
use Illuminate\Http\Request;

class BillingDetailsController extends Controller
{
    // Method to store billing details
    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'buyer_checkout_id' => 'required|exists:buyer_checkout,id',
            'full_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'is_citizen' => 'required|string|max:5', // Example: 'Yes' or 'No'
            'tax_category' => 'required|string|max:255',
            'want_invoices' => 'boolean',
        ]);

        // Create a new BillingDetail record
        BillingDetail::create($validatedData);

        // Return a response to the frontend
        return response()->json([
            'message' => 'Billing details saved successfully!',
        ]);
    }
}
