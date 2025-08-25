<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Order Statuses in Database\n";
echo "=========================\n\n";

try {
    // Check if order_statuses table exists and get all statuses
    $statuses = DB::table('order_statuses')->orderBy('id')->get();
    
    echo "Total statuses in order_statuses table: " . count($statuses) . "\n\n";
    
    echo "Complete list of statuses:\n";
    echo "ID | Name              | Slug              | Color     | Description\n";
    echo "---|-------------------|-------------------|-----------|---------------------------\n";
    
    foreach($statuses as $status) {
        $description = $status->description ?? 'No description';
        printf("%-2d | %-17s | %-17s | %-9s | %s\n", 
            $status->id, 
            $status->name, 
            $status->slug, 
            $status->color,
            $description
        );
    }
    
    echo "\nStatus categories breakdown:\n";
    
    // Group by similar types
    $workflowStatuses = ['Order Placed', 'Order Received', 'Order Accepted', 'Started Work'];
    $activeStatuses = ['Priority', 'Active', 'Late'];
    $finalStatuses = ['Delivered', 'Completed', 'Cancelled'];
    $specialStatuses = ['Starred'];
    
    echo "\nWorkflow Statuses (Order Processing):\n";
    foreach($statuses as $status) {
        if(in_array($status->name, $workflowStatuses)) {
            echo "- {$status->name} (ID: {$status->id})\n";
        }
    }
    
    echo "\nActive Work Statuses:\n";
    foreach($statuses as $status) {
        if(in_array($status->name, $activeStatuses)) {
            echo "- {$status->name} (ID: {$status->id})\n";
        }
    }
    
    echo "\nFinal Statuses:\n";
    foreach($statuses as $status) {
        if(in_array($status->name, $finalStatuses)) {
            echo "- {$status->name} (ID: {$status->id})\n";
        }
    }
    
    echo "\nSpecial Statuses:\n";
    foreach($statuses as $status) {
        if(in_array($status->name, $specialStatuses)) {
            echo "- {$status->name} (ID: {$status->id})\n";
        }
    }
    
    // Check which statuses are actually being used
    echo "\n" . str_repeat("=", 50) . "\n";
    echo "USAGE ANALYSIS\n";
    echo str_repeat("=", 50) . "\n";
    
    echo "\nStatuses used in buyer_checkout table:\n";
    $buyerCheckoutStatuses = DB::table('buyer_checkout')
        ->select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->orderBy('count', 'desc')
        ->get();
    
    foreach($buyerCheckoutStatuses as $status) {
        echo "- '{$status->status}': {$status->count} orders\n";
    }
    
    echo "\nStatuses used in manage_orders table:\n";
    $manageOrderStatuses = DB::table('manage_orders')
        ->select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->orderBy('count', 'desc')
        ->get();
    
    foreach($manageOrderStatuses as $status) {
        echo "- '{$status->status}': {$status->count} orders\n";
    }

} catch (Exception $e) {
    echo "Error accessing order_statuses table: " . $e->getMessage() . "\n";
    
    // Try to check if table exists
    try {
        $tables = DB::select("SHOW TABLES LIKE 'order_statuses'");
        if(empty($tables)) {
            echo "The 'order_statuses' table does not exist.\n";
        }
    } catch (Exception $e2) {
        echo "Cannot check if table exists: " . $e2->getMessage() . "\n";
    }
}

echo "\n";
