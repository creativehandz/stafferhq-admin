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

    echo "=== CHECKING AVAILABLE TABLES ===\n";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    foreach ($tables as $table) {
        if (strpos($table, 'categor') !== false || strpos($table, 'sub') !== false) {
            echo "Found table: $table\n";
        }
    }

    echo "\n=== TESTING SIMPLIFIED TALENT PAGE DATA ===\n";
    
    // Test without subcategories join
    $stmt = $pdo->prepare("
        SELECT 
            g.*,
            u.name as user_name,
            u.email as user_email,
            c.name as category_name
        FROM gigs g 
        LEFT JOIN users u ON g.user_id = u.id 
        LEFT JOIN categories c ON g.category_id = c.id 
        WHERE g.status = 'active' 
        ORDER BY g.created_at DESC 
        LIMIT 3
    ");
    
    $stmt->execute();
    $gigs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Found " . count($gigs) . " active gigs for talent page:\n\n";
    
    foreach ($gigs as $gig) {
        echo "=== GIG ID: " . $gig['id'] . " ===\n";
        echo "Title: " . $gig['gig_title'] . "\n";
        echo "Seller: " . $gig['user_name'] . " (" . $gig['user_email'] . ")\n";
        echo "Category: " . ($gig['category_name'] ?: 'N/A') . "\n";
        
        // Parse pricing JSON
        $pricing = json_decode($gig['pricing'], true);
        if ($pricing) {
            $prices = [];
            if (isset($pricing['basic']['price'])) $prices[] = $pricing['basic']['price'];
            if (isset($pricing['standard']['price'])) $prices[] = $pricing['standard']['price'];
            if (isset($pricing['premium']['price'])) $prices[] = $pricing['premium']['price'];
            
            $minPrice = !empty($prices) ? min($prices) : 0;
            echo "Starting Price: ₹" . number_format($minPrice) . "\n";
        }
        
        echo "Status: " . $gig['status'] . "\n";
        echo "------------------------\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
