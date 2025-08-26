<?php

require_once 'vendor/autoload.php';

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\BuyerCheckout;
use App\Models\ManageOrder;

echo "=== CHECKING ORDER ID 16 ===\n\n";

// Check if order 16 exists in BuyerCheckout
echo "1. Checking BuyerCheckout table for ID 16:\n";
$buyerCheckout = BuyerCheckout::find(16);
if ($buyerCheckout) {
    echo "   Found: ID {$buyerCheckout->id}, Status: {$buyerCheckout->status}, User: {$buyerCheckout->user_id}\n";
} else {
    echo "   NOT FOUND in BuyerCheckout table\n";
}

// Check if order 16 exists in ManageOrder
echo "\n2. Checking ManageOrder table for ID 16:\n";
$manageOrder = ManageOrder::find(16);
if ($manageOrder) {
    echo "   Found: ID {$manageOrder->id}, Status: {$manageOrder->status}, User: {$manageOrder->user_id}\n";
} else {
    echo "   NOT FOUND in ManageOrder table\n";
}

// Show all IDs in BuyerCheckout
echo "\n3. All IDs in BuyerCheckout table:\n";
$allCheckouts = BuyerCheckout::orderBy('id')->get(['id', 'status', 'user_id']);
foreach ($allCheckouts as $checkout) {
    echo "   ID: {$checkout->id}, Status: {$checkout->status}, User: {$checkout->user_id}\n";
}

// Show all IDs in ManageOrder
echo "\n4. All IDs in ManageOrder table:\n";
$allOrders = ManageOrder::orderBy('id')->get(['id', 'status', 'user_id']);
foreach ($allOrders as $order) {
    echo "   ID: {$order->id}, Status: {$order->status}, User: {$order->user_id}\n";
}

echo "\n=== ROUTE ANALYSIS ===\n";
echo "The error suggests that the OrderStatusController is trying to find\n";
echo "BuyerCheckout with ID 16, but it doesn't exist.\n";
echo "This means the frontend is sending order ID 16, but that ID\n";
echo "might be from the ManageOrder table instead of BuyerCheckout.\n";

?>
