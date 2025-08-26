<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    // Database connection
    $pdo = new PDO(
        "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_DATABASE'],
        $_ENV['DB_USERNAME'],
        $_ENV['DB_PASSWORD']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== TESTING ORDER STATUS CHANGE ===\n\n";

    // Get a sample order
    echo "1. Finding a sample order to test:\n";
    $stmt = $pdo->query("
        SELECT bc.*, g.gig_title as service_title 
        FROM buyer_checkout bc 
        LEFT JOIN gigs g ON bc.gig_id = g.id 
        WHERE bc.status != 'completed' 
        LIMIT 1
    ");
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$order) {
        echo "No non-completed orders found. Creating a test order...\n";
        // You might need to create a test order here
        echo "Please ensure you have some orders in the system first.\n";
        exit;
    }
    
    echo "Found order ID: {$order['id']}\n";
    echo "Current status: {$order['status']}\n";
    echo "Service: {$order['service_title']}\n";
    echo "Amount: ₹{$order['amount']}\n\n";

    // Get available statuses
    echo "2. Available statuses for selection:\n";
    $stmt = $pdo->query("SELECT * FROM order_statuses WHERE is_active = 1 ORDER BY sort_order");
    $statuses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($statuses as $index => $status) {
        echo "[{$index}] {$status['name']} ({$status['slug']}) - {$status['description']}\n";
    }
    echo "\n";

    // Simulate changing status (like the controller would do)
    echo "3. Testing status change to 'In Progress':\n";
    
    // Find the "started-work" status (equivalent to "In Progress")
    $newStatusSlug = 'started-work';
    $newStatus = null;
    foreach ($statuses as $status) {
        if ($status['slug'] === $newStatusSlug) {
            $newStatus = $status;
            break;
        }
    }
    
    if (!$newStatus) {
        echo "Status '{$newStatusSlug}' not found!\n";
        exit;
    }
    
    // Update the order status
    $stmt = $pdo->prepare("UPDATE buyer_checkout SET status = ? WHERE id = ?");
    $result = $stmt->execute([$newStatus['name'], $order['id']]);
    
    if ($result) {
        echo "✓ Order status updated successfully!\n";
        
        // Create history record
        $stmt = $pdo->prepare("
            INSERT INTO order_status_histories 
            (buyer_checkout_id, order_status_id, changed_by_user_id, notes, changed_at, created_at, updated_at) 
            VALUES (?, ?, ?, ?, NOW(), NOW(), NOW())
        ");
        $historyResult = $stmt->execute([
            $order['id'],
            $newStatus['id'],
            1, // Assuming user ID 1 for test
            'Status changed via test script'
        ]);
        
        if ($historyResult) {
            echo "✓ Status history recorded successfully!\n";
        }
        
        // Verify the change
        $stmt = $pdo->prepare("SELECT status FROM buyer_checkout WHERE id = ?");
        $stmt->execute([$order['id']]);
        $updatedStatus = $stmt->fetchColumn();
        
        echo "New status: {$updatedStatus}\n";
        
    } else {
        echo "✗ Failed to update order status!\n";
    }

    echo "\n=== STATUS CHANGE TEST COMPLETE ===\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
