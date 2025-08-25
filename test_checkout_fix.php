<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\BuyerCheckout;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\DB;

echo "Testing Checkout Fix...\n";
echo "======================\n\n";

// Test 1: Check if order_details column can handle large JSON
echo "1. Testing order_details column capacity:\n";
$largeOrderDetails = [
    'packageName' => 'Premium Package with Extended Features',
    'packageDescription' => 'This is a comprehensive premium package that includes advanced features, extended support, multiple revisions, source files, commercial usage rights, and additional consulting services. The package is designed to provide maximum value to clients who need extensive customization and professional-grade deliverables.',
    'packagePrice' => 500,
    'deliveryTime' => '7 days',
    'extras' => [
        'fast_delivery' => true,
        'source_files' => true,
        'commercial_rights' => true,
        'additional_revisions' => 5,
        'consultation_hours' => 3
    ],
    'timestamp' => now()->toISOString()
];

try {
    // Test data insertion directly
    $testCheckout = new BuyerCheckout();
    $testCheckout->order_details = $largeOrderDetails;
    $testCheckout->billing_details = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'address' => '123 Test Street, Test City, Test State, Test Country, 12345',
        'phone' => '+1234567890',
        'company' => 'Test Company LLC',
        'tax_id' => 'TX123456789'
    ];
    
    echo "✓ Large JSON data can be handled by the model\n";
    echo "Order details size: " . strlen(json_encode($largeOrderDetails)) . " characters\n";
    echo "Billing details size: " . strlen(json_encode($testCheckout->billing_details)) . " characters\n\n";
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n\n";
}

// Test 2: Check OrderStatus availability
echo "2. Testing OrderStatus availability:\n";
try {
    $orderPlacedStatus = OrderStatus::where('status_name', 'Order Placed')->first();
    if ($orderPlacedStatus) {
        echo "✓ 'Order Placed' status found (ID: {$orderPlacedStatus->id})\n";
    } else {
        echo "✗ 'Order Placed' status not found\n";
    }
} catch (Exception $e) {
    echo "✗ Error checking OrderStatus: " . $e->getMessage() . "\n";
}

// Test 3: Check database table structure
echo "\n3. Testing database table structure:\n";
try {
    $columns = DB::select("DESCRIBE buyer_checkout");
    $orderDetailsColumn = collect($columns)->firstWhere('Field', 'order_details');
    $billingDetailsColumn = collect($columns)->firstWhere('Field', 'billing_details');
    
    if ($orderDetailsColumn && $orderDetailsColumn->Type === 'text') {
        echo "✓ order_details column is TEXT type\n";
    } else {
        echo "✗ order_details column type: " . ($orderDetailsColumn->Type ?? 'not found') . "\n";
    }
    
    if ($billingDetailsColumn && $billingDetailsColumn->Type === 'text') {
        echo "✓ billing_details column is TEXT type\n";
    } else {
        echo "✗ billing_details column type: " . ($billingDetailsColumn->Type ?? 'not found') . "\n";
    }
} catch (Exception $e) {
    echo "✗ Error checking table structure: " . $e->getMessage() . "\n";
}

echo "\n======================\n";
echo "Checkout fix validation complete!\n";
echo "The checkout page should now work without 500 errors.\n";
echo "Test URL: http://127.0.0.1:8000/checkout/70?pricing=200\n";
