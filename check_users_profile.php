<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Users with Profile Images ===\n";

$users = App\Models\User::whereNotNull('profile_image')->get();
if ($users->count() > 0) {
    foreach ($users as $user) {
        echo "User ID: {$user->id}\n";
        echo "Name: {$user->name}\n";
        echo "Email: {$user->email}\n";
        echo "Profile image: {$user->profile_image}\n";
        
        if ($user->profile_image) {
            $fullPath = public_path($user->profile_image);
            echo "Full path: {$fullPath}\n";
            echo "File exists: " . (file_exists($fullPath) ? 'YES' : 'NO') . "\n";
        }
        echo "---\n";
    }
} else {
    echo "No users with profile images found.\n";
    
    // Check all users
    $allUsers = App\Models\User::all();
    echo "\nAll users in database:\n";
    foreach ($allUsers as $user) {
        echo "ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Profile: " . ($user->profile_image ?: 'NULL') . "\n";
    }
}

echo "===============================\n";
?>
