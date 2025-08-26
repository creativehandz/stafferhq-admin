<?php

require_once 'vendor/autoload.php';

// Bootstrap the Laravel application
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING USER ROLES ===\n\n";

$users = DB::table('users')->select('id', 'name', 'email', 'role')->get();

echo "Current users and their roles:\n";
foreach ($users as $user) {
    echo "ID: {$user->id}, Email: {$user->email}, Role: {$user->role}\n";
}

echo "\nRole analysis:\n";
$roleCount = DB::table('users')->selectRaw('role, COUNT(*) as count')->groupBy('role')->get();
foreach ($roleCount as $role) {
    echo "Role {$role->role}: {$role->count} users\n";
}

?>
