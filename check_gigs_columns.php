<?php
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$pdo = new PDO(
    "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_DATABASE'],
    $_ENV['DB_USERNAME'],
    $_ENV['DB_PASSWORD']
);
$stmt = $pdo->query('DESCRIBE gigs');
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "Gigs table columns:\n";
foreach ($columns as $column) {
    echo $column['Field'] . "\n";
}
?>
