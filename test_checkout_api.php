<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Set up the Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';

// Boot the application
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "🧪 Testing Checkout API Request\n";
echo "==============================\n\n";

try {
    // Authenticate as the buyer (user_id: 4)
    Auth::loginUsingId(4);
    echo "✅ Authenticated as buyer (user_id: 4)\n\n";

    // Create a mock request with sample data (simulating what frontend might send)
    $testPayload = [
        'packageName' => 'Basic Package',
        'packageDescription' => 'Basic electrical wiring service',
        'packagePrice' => 150.00,
        'deliveryTime' => '2 days',
        'gigId' => 55,
        'billingDetails' => 'Full Name: Test User\nCompany: Test Company\nCountry: Malaysia',
        // Extra fields that might come from form
        'fullName' => 'Test User',
        'companyName' => 'Test Company',
        'country' => 'Malaysia',
        'state' => 'Johor',
        'address' => 'Test Address',
        'city' => 'Test City',
        'postalCode' => '12345',
        'isCitizen' => 'yes',
        'taxCategory' => 'Taxable',
        'wantInvoices' => true
    ];

    echo "📦 Test Payload:\n";
    foreach ($testPayload as $key => $value) {
        echo "  - $key: " . (is_bool($value) ? ($value ? 'true' : 'false') : $value) . "\n";
    }
    echo "\n";

    // Make HTTP request using Laravel's test features
    $request = Request::create('/checkout', 'POST', $testPayload);
    $request->headers->set('X-Requested-With', 'XMLHttpRequest');
    $request->headers->set('Content-Type', 'application/json');

    // Set the authenticated user for this request
    $request->setUserResolver(function () {
        return Auth::user();
    });

    // Create the controller and call store method
    $controller = new \App\Http\Controllers\CheckoutController();
    
    try {
        $response = $controller->store($request);
        echo "✅ Checkout Response: " . $response->getContent() . "\n";
    } catch (\Illuminate\Validation\ValidationException $e) {
        echo "❌ Validation Error:\n";
        foreach ($e->errors() as $field => $errors) {
            echo "  - $field: " . implode(', ', $errors) . "\n";
        }
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
