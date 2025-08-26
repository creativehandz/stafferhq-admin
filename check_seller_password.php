<?php

require_once 'vendor/autoload.php';

// Bootstrap the Laravel application
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING SELLER@TOWORK.COM USER ===\n\n";

$user = DB::table('users')->where('email', 'seller@towork.com')->first();

if ($user) {
    echo "User found:\n";
    echo "ID: {$user->id}\n";
    echo "Name: {$user->name}\n";
    echo "Email: {$user->email}\n";
    echo "Password Hash: {$user->password}\n";
    echo "Created: {$user->created_at}\n";
} else {
    echo "User seller@towork.com not found in database.\n\n";
    
    echo "Let me check all users:\n";
    $allUsers = DB::table('users')->get();
    foreach ($allUsers as $u) {
        echo "- ID: {$u->id}, Email: {$u->email}, Name: {$u->name}\n";
    }
}

echo "\n=== CHECKING FOR DEFAULT TEST PASSWORD ===\n";
echo "If this user was created with default Laravel settings, the password might be:\n";
echo "- 'password' (common default)\n";
echo "- 'secret'\n";
echo "- '12345678'\n";
echo "\nYou can also reset the password if needed.\n";

?>
