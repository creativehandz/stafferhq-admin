<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Http\Request;
use App\Http\Controllers\RequirementController;
use Illuminate\Support\Facades\Auth;

// Set up the Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';

// Boot the application
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "🚀 Testing Requirements Submission - Completing Checkout\n";
echo "======================================================\n\n";

try {
    // Authenticate as the buyer (user_id: 4)
    Auth::loginUsingId(4);
    echo "✅ Authenticated as buyer (user_id: 4)\n";

    // Create a mock request for requirements submission
    $request = new Request();
    $request->merge([
        'requirements' => 'I need residential electrical wiring for a 3-bedroom house. Please include installation of outlets in all rooms and proper grounding.',
        'buyer_checkout_id' => 97,
    ]);

    echo "📝 Submitting requirements for BuyerCheckout ID: 97\n";
    echo "Requirements: " . $request->requirements . "\n\n";

    // Create the controller and call store method
    $controller = new RequirementController();
    $response = $controller->store($request);

    echo "🎉 Response: " . $response->getContent() . "\n\n";

    // Check the updated state
    echo "📊 Checking Updated State:\n";
    echo "=========================\n\n";

    // Check BuyerCheckout status
    $buyerCheckout = \App\Models\BuyerCheckout::find(97);
    echo "📋 BuyerCheckout ID 97 Status: {$buyerCheckout->status}\n";

    // Check if ManageOrder was created
    $newOrders = \App\Models\ManageOrder::where('user_id', 3)->get();
    echo "📦 ManageOrders for Seller (user_id: 3):\n";
    foreach ($newOrders as $order) {
        echo "  - ID: {$order->id}, Buyer: {$order->buyer}, Gig: {$order->gig}, Status: {$order->status}, Total: {$order->total}, Due: {$order->due_on}\n";
    }

    echo "\n✅ Test completed successfully!\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
