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

    echo "=== TESTING API ORDER STATUSES ENDPOINT ===\n\n";

    // Test what the API endpoint returns
    echo "1. Direct database query (what API should return):\n";
    $stmt = $pdo->query("SELECT * FROM order_statuses WHERE is_active = 1 ORDER BY sort_order");
    $statuses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Found " . count($statuses) . " active statuses:\n";
    foreach ($statuses as $status) {
        echo "   - ID: {$status['id']}, Name: '{$status['name']}', Slug: '{$status['slug']}', Color: {$status['color']}\n";
    }

    echo "\n2. Testing API response format:\n";
    echo "API endpoint: GET /api/order-statuses\n";
    echo "Expected JSON response:\n";
    echo json_encode($statuses, JSON_PRETTY_PRINT) . "\n";

    echo "\n3. Frontend expects this structure:\n";
    echo "- Each status should have: id, name, slug, color, description\n";
    echo "- Array should be filtered to remove 'Order Placed' status\n";
    echo "- Modal should show " . (count($statuses) - 1) . " status options\n";

    echo "\n=== DEBUGGING TIPS ===\n";
    echo "1. Open browser developer tools\n";
    echo "2. Go to /manage-orders page\n";
    echo "3. Check Network tab for /api/order-statuses request\n";
    echo "4. Verify the response contains the above data\n";
    echo "5. Check Console tab for any JavaScript errors\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
