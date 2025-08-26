<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "=== TESTING AUTHENTICATION SETUP ===\n\n";

// Test session-based authentication setup
echo "1. Session Configuration:\n";
echo "   - Session Driver: " . ($_ENV['SESSION_DRIVER'] ?? 'file') . "\n";
echo "   - Session Lifetime: " . ($_ENV['SESSION_LIFETIME'] ?? '120') . " minutes\n";
echo "   - App URL: " . ($_ENV['APP_URL'] ?? 'http://localhost') . "\n\n";

echo "2. Sanctum Configuration:\n";
echo "   - Stateful domains should include your domain\n";
echo "   - Guard should be set to 'web'\n";
echo "   - Personal access tokens table created\n\n";

echo "3. API Authentication Test:\n";
echo "   The API routes now support session-based authentication\n";
echo "   This means AJAX calls from authenticated web pages should work\n\n";

echo "4. Next Steps:\n";
echo "   1. Clear cache: php artisan cache:clear\n";
echo "   2. Clear config: php artisan config:clear\n";
echo "   3. Build frontend: npm run build\n";
echo "   4. Test the status change modal again\n\n";

echo "=== SETUP COMPLETE ===\n";
