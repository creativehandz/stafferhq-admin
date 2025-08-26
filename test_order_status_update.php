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

    echo "=== TESTING ORDER STATUS UPDATE ===\n\n";

    // Get a sample order to test with
    echo "1. Finding a sample order to test:\n";
    $stmt = $pdo->query("
        SELECT bc.id, bc.status, bc.user_id, g.gig_title 
        FROM buyer_checkout bc 
        LEFT JOIN gigs g ON bc.gig_id = g.id 
        WHERE bc.status = 'pending' 
        LIMIT 1
    ");
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$order) {
        echo "No pending orders found. Trying with any order...\n";
        $stmt = $pdo->query("
            SELECT bc.id, bc.status, bc.user_id, g.gig_title 
            FROM buyer_checkout bc 
            LEFT JOIN gigs g ON bc.gig_id = g.id 
            LIMIT 1
        ");
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    if (!$order) {
        echo "No orders found!\n";
        exit;
    }
    
    echo "Order ID: {$order['id']}\n";
    echo "Current Status: {$order['status']}\n";
    echo "Service: " . ($order['gig_title'] ?? 'N/A') . "\n\n";

    // Get "Order Accepted" status
    echo "2. Finding 'Order Accepted' status:\n";
    $stmt = $pdo->query("SELECT * FROM order_statuses WHERE name = 'Order Accepted' OR slug = 'order-accepted'");
    $targetStatus = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$targetStatus) {
        echo "Order Accepted status not found!\n";
        exit;
    }
    
    echo "Target Status ID: {$targetStatus['id']}\n";
    echo "Target Status Name: {$targetStatus['name']}\n";
    echo "Target Status Color: {$targetStatus['color']}\n\n";

    // Simulate the API call logic
    echo "3. Simulating API PUT /api/orders/{$order['id']}/status:\n";
    echo "Request body: { status_id: {$targetStatus['id']} }\n\n";

    // Update the order status
    $stmt = $pdo->prepare("UPDATE buyer_checkout SET status = ?, updated_at = NOW() WHERE id = ?");
    $updateResult = $stmt->execute([$targetStatus['name'], $order['id']]);
    
    if ($updateResult) {
        echo "✅ Order status updated in database\n";
        
        // Create history record
        $stmt = $pdo->prepare("
            INSERT INTO order_status_histories 
            (buyer_checkout_id, order_status_id, changed_by_user_id, notes, changed_at, created_at, updated_at) 
            VALUES (?, ?, ?, ?, NOW(), NOW(), NOW())
        ");
        
        // Use the order's user_id as the changer
        $historyResult = $stmt->execute([
            $order['id'],
            $targetStatus['id'],
            $order['user_id'],
            'Status changed via debug test'
        ]);
        
        if ($historyResult) {
            echo "✅ Status history recorded\n";
        }
        
        // Verify the change
        $stmt = $pdo->prepare("SELECT status FROM buyer_checkout WHERE id = ?");
        $stmt->execute([$order['id']]);
        $newStatus = $stmt->fetchColumn();
        
        echo "✅ Verified new status: {$newStatus}\n\n";
        
        // Simulate API response
        $apiResponse = [
            'success' => true,
            'message' => 'Order status updated successfully',
            'order_id' => $order['id'],
            'status_info' => $targetStatus,
            'previous_status' => $order['status']
        ];
        
        echo "4. Expected API Response:\n";
        echo json_encode($apiResponse, JSON_PRETTY_PRINT) . "\n\n";
        
    } else {
        echo "❌ Failed to update order status\n";
    }

    echo "=== TESTING COMPLETE ===\n";
    echo "\nNow try the status change in your browser with developer tools open.\n";
    echo "Check the Console and Network tabs for any errors.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
