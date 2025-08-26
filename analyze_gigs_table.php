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

    echo "=== GIGS TABLE STRUCTURE ===\n";
    $stmt = $pdo->query("DESCRIBE gigs");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        echo $column['Field'] . " | " . $column['Type'] . " | " . $column['Null'] . " | " . $column['Key'] . "\n";
    }

    echo "\n=== SAMPLE GIGS DATA ===\n";
    $stmt = $pdo->query("SELECT * FROM gigs LIMIT 5");
    $gigs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($gigs)) {
        echo "No gigs found in the table.\n";
    } else {
        foreach ($gigs as $gig) {
            print_r($gig);
            echo "------------------------\n";
        }
    }

    echo "\n=== TOTAL GIGS COUNT ===\n";
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM gigs");
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Total gigs: " . $count['total'] . "\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
