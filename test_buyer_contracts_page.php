<?php

require_once 'vendor/autoload.php';

// Bootstrap the Laravel application
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING BUYER CONTRACTS PAGE DATA ===\n\n";

// Test what the BuyerContractsController would fetch
$buyer_id = 4; // Current logged in buyer

echo "Testing data for buyer ID: $buyer_id\n\n";

// Check buyer_checkout table structure first
echo "1. BUYER_CHECKOUT TABLE STRUCTURE:\n";
$columns = DB::select("DESCRIBE buyer_checkout");
foreach ($columns as $column) {
    echo "  - {$column->Field} ({$column->Type})\n";
}

echo "\n2. BUYER CONTRACTS DATA:\n";
$contracts = DB::table('buyer_checkout')
    ->where('user_id', $buyer_id)
    ->orderBy('created_at', 'desc')
    ->get();

echo "Found " . count($contracts) . " contracts for buyer ID $buyer_id\n\n";

foreach ($contracts as $contract) {
    echo "Contract ID: " . $contract->id . "\n";
    echo "Package: " . $contract->package_selected . "\n";
    echo "Amount: $" . $contract->total_price . "\n";
    echo "Status: " . $contract->status . "\n";
    echo "Gig ID: " . ($contract->gig_id ?: 'N/A') . "\n";
    echo "Created: " . $contract->created_at . "\n";
    
    // Try to get order details
    if ($contract->order_details) {
        $details = json_decode($contract->order_details, true);
        if (is_array($details) && !empty($details)) {
            echo "Order Details:\n";
            foreach ($details as $key => $value) {
                if (is_array($value) || is_object($value)) {
                    $value = json_encode($value);
                }
                echo "  - {$key}: {$value}\n";
            }
        } else {
            echo "Order Details: " . $contract->order_details . "\n";
        }
    }
    echo "---\n";
}

echo "\n3. STATUS MAPPING TEST:\n";
$statuses = ['active', 'pending', 'completed', 'Order Placed', 'cancelled'];

foreach ($statuses as $status) {
    switch ($status) {
        case 'active':
            $color = '#10B981';
            $bg_color = '#ECFDF5';
            $text = 'Active';
            $button_text = 'Activate Milestone';
            break;
        case 'pending':
        case 'Order Placed':
            $color = '#F59E0B';
            $bg_color = '#FFFBEB';
            $text = 'Pending';
            $button_text = 'Activate Milestone';
            break;
        case 'completed':
            $color = '#6B7280';
            $bg_color = '#F9FAFB';
            $text = 'Completed';
            $button_text = 'Rehire';
            break;
        default:
            $color = '#DC2626';
            $bg_color = '#FEF2F2';
            $text = 'Unknown';
            $button_text = 'Contact Support';
    }
    
    echo "Status '$status' -> Display: '$text', Color: $color, Button: '$button_text'\n";
}

echo "\n4. CONTROLLER FUNCTIONALITY TEST:\n";
echo "The BuyerContractsController should return all the above contracts in JSON format\n";
echo "for the authenticated buyer when visiting /all-contracts\n\n";

echo "=== TEST COMPLETE ===\n";

?>