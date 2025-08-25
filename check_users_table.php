<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== Checking Users Table Structure ===\n\n";

// Get table structure
$columns = DB::select("DESCRIBE users");

echo "Current columns in users table:\n";
foreach ($columns as $column) {
    echo "- {$column->Field} ({$column->Type}) - {$column->Null} - {$column->Key}\n";
}

echo "\n=== Checking if interested_categories column exists ===\n";
$hasColumn = Schema::hasColumn('users', 'interested_categories');
echo "Has interested_categories column: " . ($hasColumn ? 'YES' : 'NO') . "\n";
