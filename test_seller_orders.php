<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CheckoutController;

echo "Testing Updated CheckoutController\n";
echo "==================================\n\n";

try {
    // Login as the seller (user ID 3)
    Auth::loginUsingId(3);
    echo "Logged in as user: " . Auth::user()->name . " (ID: " . Auth::id() . ")\n\n";
    
    // Create controller instance and call index method
    $controller = new CheckoutController();
    $response = $controller->index();
    
    // Get the JSON content
    $content = $response->getContent();
    $data = json_decode($content, true);
    
    echo "Total orders returned: " . count($data) . "\n\n";
    
    // Group by status
    $statusGroups = [];
    foreach($data as $order) {
        $status = $order['status'];
        if (!isset($statusGroups[$status])) {
            $statusGroups[$status] = [];
        }
        $statusGroups[$status][] = $order;
    }
    
    echo "Orders grouped by status:\n";
    foreach($statusGroups as $status => $orders) {
        echo "- {$status}: " . count($orders) . " orders\n";
        foreach($orders as $order) {
            $source = $order['source'] ?? 'unknown';
            $id = $order['id'];
            echo "  * ID: {$id} (from {$source})\n";
        }
    }
    
    echo "\nRecent orders (first 5):\n";
    for($i = 0; $i < min(5, count($data)); $i++) {
        $order = $data[$i];
        $orderDetails = json_decode($order['order_details'], true);
        $gig = $orderDetails['gig'] ?? $order['package_selected'] ?? 'Unknown';
        echo "- {$order['id']}: {$gig} - Status: {$order['status']} (from {$order['source']})\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "\nTest completed!\n";
