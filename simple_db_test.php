<?php

// Simple database connection test
try {
    $host = 'localhost';
    $dbname = 'u707645493_stafferhqadmin';
    $username = 'u707645493_stafferhqadmin';
    $password = 'StafferHQ2024!';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== DATABASE CONNECTION TEST ===" . PHP_EOL;
    echo "✓ Connected to database successfully" . PHP_EOL . PHP_EOL;
    
    // Check buyer_checkout table structure
    echo "=== BUYER_CHECKOUT TABLE SCHEMA ===" . PHP_EOL;
    $stmt = $pdo->query("DESCRIBE buyer_checkout");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        echo "- {$column['Field']}: {$column['Type']} " . 
             ($column['Null'] === 'YES' ? '(nullable)' : '(not null)') . 
             ($column['Default'] !== null ? " default: {$column['Default']}" : '') . PHP_EOL;
    }
    
    echo PHP_EOL . "=== CHECKING FOREIGN KEYS ===" . PHP_EOL;
    
    // Check if users table has data
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $userCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "Users table: {$userCount} records" . PHP_EOL;
    
    // Check if gigs table has data
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM gigs");
    $gigCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    echo "Gigs table: {$gigCount} records" . PHP_EOL;
    
    // Check order_statuses table
    try {
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM order_statuses");
        $statusCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        echo "Order statuses table: {$statusCount} records" . PHP_EOL;
        
        if ($statusCount > 0) {
            echo PHP_EOL . "Available order statuses:" . PHP_EOL;
            $stmt = $pdo->query("SELECT id, name FROM order_statuses");
            $statuses = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($statuses as $status) {
                echo "  - {$status['name']} (id: {$status['id']})" . PHP_EOL;
            }
        }
    } catch (PDOException $e) {
        echo "Order statuses table: NOT FOUND" . PHP_EOL;
    }
    
    echo PHP_EOL . "=== TESTING SIMPLE INSERT ===" . PHP_EOL;
    
    // Test a simple insert
    $testData = [
        'user_id' => 4,  // Use an existing user ID
        'order_details' => '{"packageDescription":"Test","deliveryTime":"7 days"}',
        'package_selected' => 'Basic Package',
        'total_price' => 100.00,
        'gig_id' => 70,  // Use the gig ID from the URL
        'billing_details' => 'Test billing details',
        'status' => 'Order Placed'
    ];
    
    $sql = "INSERT INTO buyer_checkout (user_id, order_details, package_selected, total_price, gig_id, billing_details, status, created_at, updated_at) 
            VALUES (:user_id, :order_details, :package_selected, :total_price, :gig_id, :billing_details, :status, NOW(), NOW())";
    
    $stmt = $pdo->prepare($sql);
    
    try {
        $result = $stmt->execute($testData);
        $lastId = $pdo->lastInsertId();
        echo "✓ Test insert successful, ID: {$lastId}" . PHP_EOL;
        
        // Clean up test data
        $pdo->exec("DELETE FROM buyer_checkout WHERE id = {$lastId}");
        echo "✓ Test record cleaned up" . PHP_EOL;
        
    } catch (PDOException $e) {
        echo "✗ Insert failed: " . $e->getMessage() . PHP_EOL;
    }
    
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage() . PHP_EOL;
}
