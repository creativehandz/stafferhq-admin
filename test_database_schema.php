<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    echo "=== BUYER_CHECKOUT TABLE SCHEMA ===" . PHP_EOL;
    
    // Check if table exists
    if (Schema::hasTable('buyer_checkout')) {
        echo "✓ buyer_checkout table exists" . PHP_EOL . PHP_EOL;
        
        // Get table schema
        $columns = DB::select("DESCRIBE buyer_checkout");
        
        echo "Columns:" . PHP_EOL;
        foreach ($columns as $column) {
            echo "- {$column->Field}: {$column->Type} " . 
                 ($column->Null === 'YES' ? '(nullable)' : '(not null)') . 
                 ($column->Default !== null ? " default: {$column->Default}" : '') . PHP_EOL;
        }
        
        echo PHP_EOL . "=== TESTING BASIC INSERT ===" . PHP_EOL;
        
        // Test basic data structure
        $testData = [
            'user_id' => 1,
            'order_details' => json_encode([
                'packageDescription' => 'Test package',
                'deliveryTime' => '7 days'
            ]),
            'package_selected' => 'Basic Package',
            'total_price' => 100.00,
            'gig_id' => 1,
            'billing_details' => 'Test billing details string',
            'status' => 'Order Placed',
            'created_at' => now(),
            'updated_at' => now()
        ];
        
        echo "Test data prepared..." . PHP_EOL;
        
        // Try to insert
        try {
            $result = DB::table('buyer_checkout')->insert($testData);
            echo "✓ Insert successful" . PHP_EOL;
            
            // Get the last inserted record
            $lastRecord = DB::table('buyer_checkout')->orderBy('id', 'desc')->first();
            echo "Last record ID: " . $lastRecord->id . PHP_EOL;
            
            // Clean up test data
            DB::table('buyer_checkout')->where('id', $lastRecord->id)->delete();
            echo "✓ Test record cleaned up" . PHP_EOL;
            
        } catch (Exception $e) {
            echo "✗ Insert failed: " . $e->getMessage() . PHP_EOL;
        }
        
    } else {
        echo "✗ buyer_checkout table does not exist!" . PHP_EOL;
    }
    
    echo PHP_EOL . "=== CHECKING RELATED TABLES ===" . PHP_EOL;
    
    // Check users table
    if (Schema::hasTable('users')) {
        $userCount = DB::table('users')->count();
        echo "✓ users table exists with {$userCount} records" . PHP_EOL;
    } else {
        echo "✗ users table missing" . PHP_EOL;
    }
    
    // Check gigs table  
    if (Schema::hasTable('gigs')) {
        $gigCount = DB::table('gigs')->count();
        echo "✓ gigs table exists with {$gigCount} records" . PHP_EOL;
    } else {
        echo "✗ gigs table missing" . PHP_EOL;
    }
    
    // Check order_statuses table
    if (Schema::hasTable('order_statuses')) {
        $statusCount = DB::table('order_statuses')->count();
        echo "✓ order_statuses table exists with {$statusCount} records" . PHP_EOL;
        
        // Show available statuses
        $statuses = DB::table('order_statuses')->get();
        echo "Available statuses:" . PHP_EOL;
        foreach ($statuses as $status) {
            echo "  - {$status->name} (id: {$status->id})" . PHP_EOL;
        }
    } else {
        echo "✗ order_statuses table missing" . PHP_EOL;
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
    echo "Stack trace:" . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
}
