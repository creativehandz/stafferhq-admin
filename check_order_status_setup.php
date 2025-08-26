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

    echo "=== CHECKING ORDER STATUS FUNCTIONALITY ===\n\n";

    // Check if order_statuses table exists
    echo "1. Checking order_statuses table:\n";
    try {
        $stmt = $pdo->query("DESCRIBE order_statuses");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "Table exists with columns: ";
        foreach ($columns as $column) {
            echo $column['Field'] . " ";
        }
        echo "\n\n";
    } catch (Exception $e) {
        echo "Table does not exist: " . $e->getMessage() . "\n\n";
    }

    // Check existing order statuses
    echo "2. Existing order statuses:\n";
    try {
        $stmt = $pdo->query("SELECT * FROM order_statuses WHERE is_active = 1 ORDER BY sort_order");
        $statuses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($statuses)) {
            echo "No order statuses found. Creating default statuses...\n";
            
            // Create default order statuses
            $defaultStatuses = [
                ['name' => 'Order Placed', 'slug' => 'order-placed', 'color' => '#6366F1', 'description' => 'Order has been placed and is pending acceptance', 'sort_order' => 1, 'is_initial' => 1],
                ['name' => 'In Progress', 'slug' => 'in-progress', 'color' => '#F59E0B', 'description' => 'Work is currently in progress', 'sort_order' => 2],
                ['name' => 'In Review', 'slug' => 'in-review', 'color' => '#8B5CF6', 'description' => 'Work is completed and under review', 'sort_order' => 3],
                ['name' => 'Delivered', 'slug' => 'delivered', 'color' => '#059669', 'description' => 'Work has been delivered to the client', 'sort_order' => 4],
                ['name' => 'Completed', 'slug' => 'completed', 'color' => '#10B981', 'description' => 'Order has been completed successfully', 'sort_order' => 5, 'is_final' => 1],
                ['name' => 'Cancelled', 'slug' => 'cancelled', 'color' => '#EF4444', 'description' => 'Order has been cancelled', 'sort_order' => 6, 'is_final' => 1],
                ['name' => 'Refunded', 'slug' => 'refunded', 'color' => '#6B7280', 'description' => 'Order has been refunded', 'sort_order' => 7, 'is_final' => 1],
            ];
            
            foreach ($defaultStatuses as $status) {
                $status['is_active'] = 1;
                $status['is_initial'] = $status['is_initial'] ?? 0;
                $status['is_final'] = $status['is_final'] ?? 0;
                $status['created_at'] = date('Y-m-d H:i:s');
                $status['updated_at'] = date('Y-m-d H:i:s');
                
                $placeholders = ':' . implode(', :', array_keys($status));
                $pdo->prepare("INSERT INTO order_statuses (" . implode(', ', array_keys($status)) . ") VALUES ($placeholders)")
                   ->execute($status);
            }
            
            echo "Default statuses created successfully!\n\n";
            
            // Fetch the created statuses
            $stmt = $pdo->query("SELECT * FROM order_statuses WHERE is_active = 1 ORDER BY sort_order");
            $statuses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        foreach ($statuses as $status) {
            echo "ID: {$status['id']}, Name: {$status['name']}, Slug: {$status['slug']}, Color: {$status['color']}\n";
        }
        echo "\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n\n";
    }

    // Check current order statuses in buyer_checkout
    echo "3. Current order statuses in buyer_checkout:\n";
    try {
        $stmt = $pdo->query("SELECT DISTINCT status, COUNT(*) as count FROM buyer_checkout GROUP BY status");
        $currentStatuses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($currentStatuses as $status) {
            echo "Status: {$status['status']}, Count: {$status['count']}\n";
        }
        echo "\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n\n";
    }

    // Check if order_status_histories table exists
    echo "4. Checking order_status_histories table:\n";
    try {
        $stmt = $pdo->query("DESCRIBE order_status_histories");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "Table exists with columns: ";
        foreach ($columns as $column) {
            echo $column['Field'] . " ";
        }
        echo "\n\n";
    } catch (Exception $e) {
        echo "Table does not exist: " . $e->getMessage() . "\n";
        echo "Creating order_status_histories table...\n";
        
        // Create the table
        $pdo->exec("
            CREATE TABLE order_status_histories (
                id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                buyer_checkout_id BIGINT UNSIGNED NOT NULL,
                order_status_id BIGINT UNSIGNED NOT NULL,
                changed_by_user_id BIGINT UNSIGNED NOT NULL,
                notes TEXT NULL,
                metadata JSON NULL,
                changed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL,
                PRIMARY KEY (id),
                INDEX idx_buyer_checkout_id (buyer_checkout_id),
                INDEX idx_order_status_id (order_status_id),
                INDEX idx_changed_by_user_id (changed_by_user_id),
                INDEX idx_changed_at (changed_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        
        echo "Table created successfully!\n\n";
    }

    echo "=== STATUS CHANGE FUNCTIONALITY IS READY ===\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
