<?php

// app/Http/Controllers/RequirementController.php

namespace App\Http\Controllers;

use App\Models\Requirement;
use App\Models\BuyerCheckout;
use App\Models\ManageOrder;
use App\Models\Gig;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class RequirementController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'requirements' => 'required|string|max:2500',
            'file' => 'nullable|file|mimes:jpg,png,pdf,docx,txt|max:2048', // Adjust file types as needed
            'buyer_checkout_id' => 'required|exists:buyer_checkout,id', // Ensure it exists in buyer_checkouts
        ]);

        // Handle file upload if present
        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public'); // Save the file in 'storage/app/public/uploads'
        }

        // Store the form data in the database
        Requirement::create([
            'requirements' => $validatedData['requirements'],
            'file_path' => $filePath,
            'buyer_checkout_id' => $validatedData['buyer_checkout_id'],
        ]);

        // Get the BuyerCheckout record to create corresponding ManageOrder
        $buyerCheckout = BuyerCheckout::with('user')->findOrFail($validatedData['buyer_checkout_id']);
        
        // Get the gig to find the seller
        $gig = Gig::findOrFail($buyerCheckout->gig_id);
        
        // Parse order details from JSON
        $orderDetails = json_decode($buyerCheckout->order_details, true);
        
        // Calculate due date (add delivery time to current date)
        $deliveryTime = $orderDetails['deliveryTime'] ?? '7 days';
        $dueDate = now();
        
        // Parse delivery time to add to due date
        if (preg_match('/(\d+)\s*day/i', $deliveryTime, $matches)) {
            $days = (int)$matches[1];
            $dueDate = now()->addDays($days);
        } elseif (preg_match('/(\d+)\s*week/i', $deliveryTime, $matches)) {
            $weeks = (int)$matches[1];
            $dueDate = now()->addWeeks($weeks);
        } else {
            // Default to 7 days if parsing fails
            $dueDate = now()->addDays(7);
        }

        // Create ManageOrder for the seller
        ManageOrder::create([
            'user_id' => $gig->user_id, // Seller's ID
            'buyer' => $buyerCheckout->user->name, // Buyer's name
            'gig' => $buyerCheckout->package_selected, // Package/gig name
            'due_on' => $dueDate,
            'total' => $buyerCheckout->total_price,
            'note' => $validatedData['requirements'], // Store requirements as note
            'status' => 'pending' // New order starts as pending
        ]);

        // Update BuyerCheckout status to completed
        $buyerCheckout->update(['status' => 'completed']);

        return response()->json(['message' => 'Requirements submitted successfully! Order has been created for the seller.'], 200);
    }
}
