<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OrderController;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');
$request = Request::capture();
$kernel->bootstrap();

echo "Testing OrderController Authentication\n";
echo "=====================================\n\n";

try {
    // Test without authentication
    echo "1. Testing without authentication:\n";
    echo "Auth::check(): " . (Auth::check() ? 'true' : 'false') . "\n";
    echo "Auth::id(): " . (Auth::id() ?? 'null') . "\n\n";
    
    // Manually set user for testing
    echo "2. Manually setting user ID 3 for testing:\n";
    Auth::loginUsingId(3);
    echo "Auth::check(): " . (Auth::check() ? 'true' : 'false') . "\n";
    echo "Auth::id(): " . (Auth::id() ?? 'null') . "\n";
    echo "Auth::user()->name: " . (Auth::user()->name ?? 'null') . "\n\n";
    
    // Test the controller
    echo "3. Testing OrderController::getOrdersByStatus():\n";
    $controller = new OrderController();
    
    // Create a mock request
    $request = new Request();
    $response = $controller->getOrdersByStatus();
    
    echo "Response type: " . get_class($response) . "\n";
    
    // Get the data that would be passed to Inertia
    $reflection = new ReflectionClass($response);
    $propsProperty = $reflection->getProperty('props');
    $propsProperty->setAccessible(true);
    $props = $propsProperty->getValue($response);
    
    echo "Inertia component: " . $response->component . "\n";
    echo "Data passed to component:\n";
    
    if (isset($props['orders'])) {
        echo "- orders count: " . count($props['orders']) . "\n";
        echo "- first 3 orders:\n";
        foreach (array_slice($props['orders'], 0, 3) as $i => $order) {
            echo "  Order " . ($i + 1) . ": {$order['gig']} - {$order['buyer']} ({$order['status']})\n";
        }
    }
    
    if (isset($props['stats'])) {
        echo "- stats:\n";
        foreach ($props['stats'] as $key => $value) {
            echo "  {$key}: {$value}\n";
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "\nTest completed!\n";
