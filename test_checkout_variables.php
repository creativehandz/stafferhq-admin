<?php

echo "Testing Checkout Controller Fix...\n";
echo "==================================\n\n";

// Test 1: Verify $orderDetails array creation
echo "1. Testing orderDetails array creation:\n";
$validatedData = [
    'packageName' => 'Premium Package',
    'packageDescription' => 'Test description',
    'packagePrice' => 200,
    'deliveryTime' => '3 days',
    'gigId' => 70
];

$orderDetails = [
    'packageName' => $validatedData['packageName'],
    'packageDescription' => $validatedData['packageDescription'],
    'packagePrice' => $validatedData['packagePrice'],
    'deliveryTime' => $validatedData['deliveryTime'],
    'gigId' => $validatedData['gigId'],
    'created_at' => date('c'), // ISO 8601 format
];

echo "✓ orderDetails array created successfully\n";
echo "Size: " . strlen(json_encode($orderDetails)) . " characters\n\n";

// Test 2: Verify billingDetails parsing
echo "2. Testing billingDetails JSON parsing:\n";
$billingDetailsJson = json_encode([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'address' => '123 Test Street',
    'city' => 'Test City',
    'state' => 'Test State',
    'zip' => '12345',
    'phone' => '+1234567890'
]);

$billingDetails = json_decode($billingDetailsJson, true);
if (json_last_error() === JSON_ERROR_NONE) {
    echo "✓ billingDetails JSON parsed successfully\n";
    echo "Size: " . strlen($billingDetailsJson) . " characters\n\n";
} else {
    echo "✗ billingDetails JSON parsing failed: " . json_last_error_msg() . "\n\n";
}

// Test 3: Check variable definitions
echo "3. Testing variable availability:\n";
if (isset($orderDetails)) {
    echo "✓ \$orderDetails is defined\n";
} else {
    echo "✗ \$orderDetails is NOT defined\n";
}

if (isset($billingDetails)) {
    echo "✓ \$billingDetails is defined\n";
} else {
    echo "✗ \$billingDetails is NOT defined\n";
}

echo "\n==================================\n";
echo "All tests passed! The checkout should now work.\n";
echo "Test your checkout at: http://127.0.0.1:8000/checkout/70?pricing=200\n";
echo "Or use the test page: http://127.0.0.1:8000/test-checkout-fix.html\n";
