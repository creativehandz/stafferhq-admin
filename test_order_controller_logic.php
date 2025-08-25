<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

use App\Models\ManageOrder;
use Illuminate\Support\Facades\DB;

echo "Testing OrderController Logic\n";
echo "=============================\n\n";

try {
    // Simulate being logged in as user 3 (seller)
    $userId = 3;
    echo "Simulating logged in user ID: {$userId}\n\n";
    
    // Test the forUser scope
    $ordersViaModel = ManageOrder::forUser($userId)->get();
    echo "Orders via ManageOrder::forUser({$userId}): " . count($ordersViaModel) . "\n";
    
    // Group by status
    $ordersByStatus = [
        'pending' => $ordersViaModel->where('status', 'pending'),
        'in_progress' => $ordersViaModel->where('status', 'in_progress'),
        'completed' => $ordersViaModel->where('status', 'completed'),
        'cancelled' => $ordersViaModel->where('status', 'cancelled'),
    ];
    
    echo "\nOrders grouped by status:\n";
    foreach ($ordersByStatus as $status => $orders) {
        echo "- {$status}: " . count($orders) . " orders\n";
        foreach ($orders as $order) {
            echo "  * {$order->gig} - {$order->buyer}\n";
        }
    }
    
    // Test the scopes
    echo "\nTesting scopes:\n";
    echo "- overdue(): " . ManageOrder::forUser($userId)->overdue()->count() . "\n";
    echo "- dueSoon(): " . ManageOrder::forUser($userId)->dueSoon()->count() . "\n";
    
    // Stats calculation
    $stats = [
        'total' => $ordersViaModel->count(),
        'pending' => $ordersViaModel->where('status', 'pending')->count(),
        'in_progress' => $ordersViaModel->where('status', 'in_progress')->count(),
        'completed' => $ordersViaModel->where('status', 'completed')->count(),
        'overdue' => ManageOrder::forUser($userId)->overdue()->count(),
        'due_soon' => ManageOrder::forUser($userId)->dueSoon()->count(),
    ];
    
    echo "\nStats for dashboard:\n";
    foreach ($stats as $key => $value) {
        echo "- {$key}: {$value}\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "\nTest completed!\n";
