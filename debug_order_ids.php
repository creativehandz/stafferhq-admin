<?php

require_once 'vendor/autoload.php';

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ManageOrder;
use App\Models\BuyerCheckout;

echo "=== DEBUGGING ORDER IDS ===\n\n";

// Check ManageOrder table
echo "1. ManageOrder table:\n";
$manageOrders = ManageOrder::limit(5)->get();
foreach ($manageOrders as $order) {
    echo "   ID: {$order->id} (type: " . gettype($order->id) . ")\n";
    echo "   Buyer: {$order->buyer}\n";
    echo "   Status: {$order->status}\n";
    echo "   ---\n";
}

echo "\n2. BuyerCheckout table:\n";
$buyerCheckouts = BuyerCheckout::limit(5)->get();
foreach ($buyerCheckouts as $checkout) {
    echo "   ID: {$checkout->id} (type: " . gettype($checkout->id) . ")\n";
    echo "   User ID: {$checkout->user_id}\n";
    echo "   Status: {$checkout->status}\n";
    echo "   ---\n";
}

// Check if there's any transformation happening
echo "\n3. Checking for ID transformations:\n";
$sampleOrder = ManageOrder::first();
if ($sampleOrder) {
    echo "   Raw ID: {$sampleOrder->id}\n";
    echo "   Attributes: " . json_encode($sampleOrder->getAttributes()) . "\n";
    echo "   To Array: " . json_encode($sampleOrder->toArray()) . "\n";
}

?>
