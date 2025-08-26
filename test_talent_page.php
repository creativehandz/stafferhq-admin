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

    echo "=== TESTING TALENT PAGE DATA ===\n";
    
    // Test the query used in the talent() method
    $stmt = $pdo->prepare("
        SELECT 
            g.*,
            u.name as user_name,
            u.email as user_email,
            c.name as category_name,
            s.name as subcategory_name
        FROM gigs g 
        LEFT JOIN users u ON g.user_id = u.id 
        LEFT JOIN categories c ON g.category_id = c.id 
        LEFT JOIN subcategories s ON g.subcategory_id = s.id 
        WHERE g.status = 'active' 
        ORDER BY g.created_at DESC 
        LIMIT 5
    ");
    
    $stmt->execute();
    $gigs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Found " . count($gigs) . " active gigs for talent page:\n\n";
    
    foreach ($gigs as $gig) {
        echo "=== GIG ID: " . $gig['id'] . " ===\n";
        echo "Title: " . $gig['gig_title'] . "\n";
        echo "Description: " . substr($gig['gig_description'], 0, 100) . "...\n";
        echo "Seller: " . $gig['user_name'] . " (" . $gig['user_email'] . ")\n";
        echo "Category: " . ($gig['category_name'] ?: 'N/A') . "\n";
        echo "Subcategory: " . ($gig['subcategory_name'] ?: 'N/A') . "\n";
        
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
        echo "Created: " . $gig['created_at'] . "\n";
        echo "------------------------\n";
    }

    // Check if categories and subcategories tables exist
    echo "\n=== CHECKING RELATED TABLES ===\n";
    
    try {
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM categories");
        $categoryCount = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "Categories table: " . $categoryCount['count'] . " records\n";
    } catch (Exception $e) {
        echo "Categories table: ERROR - " . $e->getMessage() . "\n";
    }
    
    try {
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM subcategories");
        $subcategoryCount = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "Subcategories table: " . $subcategoryCount['count'] . " records\n";
    } catch (Exception $e) {
        echo "Subcategories table: ERROR - " . $e->getMessage() . "\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
