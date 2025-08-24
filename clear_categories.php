<?php

require_once 'vendor/autoload.php';

// Load Laravel configuration
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

echo "=== CLEARING CATEGORIES DATA FROM USERS TABLE ===\n\n";

// Get all users with categories data
$usersWithCategories = User::whereNotNull('categories')->get();

echo "Found " . $usersWithCategories->count() . " users with categories data:\n\n";

foreach ($usersWithCategories as $user) {
    echo "User ID: " . $user->id . " - " . $user->name . "\n";
    echo "Current categories: " . $user->categories . "\n";
    
    // Clear the categories field
    $user->categories = null;
    $user->save();
    
    echo "✅ Categories cleared for user: " . $user->name . "\n\n";
}

echo "=== VERIFICATION ===\n";
$remainingUsers = User::whereNotNull('categories')->count();
echo "Users with categories remaining: " . $remainingUsers . "\n";

if ($remainingUsers == 0) {
    echo "✅ All categories data successfully removed from users table!\n";
} else {
    echo "⚠️ Some users still have categories data.\n";
}

?>
