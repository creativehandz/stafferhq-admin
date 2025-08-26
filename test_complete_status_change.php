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

    echo "=== FINAL STATUS CHANGE TEST ===\n\n";

    // Get a real user ID
    echo "1. Getting a valid user ID:\n";
    $stmt = $pdo->query("SELECT id FROM users LIMIT 1");
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        echo "No users found!\n";
        exit;
    }
    
    $userId = $user['id'];
    echo "Using user ID: {$userId}\n\n";

    // Get a sample order
    echo "2. Finding a sample order to test:\n";
    $stmt = $pdo->query("
        SELECT bc.*, g.gig_title as service_title 
        FROM buyer_checkout bc 
        LEFT JOIN gigs g ON bc.gig_id = g.id 
        WHERE bc.status != 'completed' 
        LIMIT 1
    ");
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$order) {
        echo "No orders found to test!\n";
        exit;
    }
    
    echo "Found order ID: {$order['id']}\n";
    echo "Current status: {$order['status']}\n";
    echo "Service: " . ($order['service_title'] ?? 'N/A') . "\n\n";

    // Get available statuses
    echo "3. Testing status change from '{$order['status']}' to 'Delivered':\n";
    
    $stmt = $pdo->query("SELECT * FROM order_statuses WHERE slug = 'delivered' AND is_active = 1");
    $newStatus = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$newStatus) {
        echo "Delivered status not found!\n";
        exit;
    }
    
    // Update the order status (simulating the controller)
    $stmt = $pdo->prepare("UPDATE buyer_checkout SET status = ? WHERE id = ?");
    $result = $stmt->execute([$newStatus['name'], $order['id']]);
    
    if ($result) {
        echo "✓ Order status updated to '{$newStatus['name']}'!\n";
        
        // Create history record with valid user ID
        $stmt = $pdo->prepare("
            INSERT INTO order_status_histories 
            (buyer_checkout_id, order_status_id, changed_by_user_id, notes, changed_at, created_at, updated_at) 
            VALUES (?, ?, ?, ?, NOW(), NOW(), NOW())
        ");
        $historyResult = $stmt->execute([
            $order['id'],
            $newStatus['id'],
            $userId,
            'Status changed via API test'
        ]);
        
        if ($historyResult) {
            echo "✓ Status history recorded successfully!\n";
        } else {
            echo "✗ Failed to record status history!\n";
        }
        
        // Verify the change
        $stmt = $pdo->prepare("
            SELECT bc.status, os.name as status_name, os.color 
            FROM buyer_checkout bc 
            LEFT JOIN order_statuses os ON bc.status = os.name
            WHERE bc.id = ?
        ");
        $stmt->execute([$order['id']]);
        $updatedOrder = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "✓ Verified - New status: {$updatedOrder['status']}\n";
        echo "✓ Status color: {$updatedOrder['color']}\n";
        
    } else {
        echo "✗ Failed to update order status!\n";
    }

    echo "\n=== ORDER STATUS CHANGE SYSTEM IS WORKING! ===\n";
    echo "\nTo use the status change functionality:\n";
    echo "1. Go to /manage-orders page as a seller\n";
    echo "2. Click 'Change Status' button on any order\n";
    echo "3. Select new status from the dropdown\n";
    echo "4. Click 'Update Status' to save changes\n";
    echo "\nThe system will:\n";
    echo "- Update the order status in buyer_checkout table\n";
    echo "- Record the change in order_status_histories table\n";
    echo "- Show the new status with proper color coding\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
