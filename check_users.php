<?php

require_once 'vendor/autoload.php';

// Load Laravel configuration
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

echo "=== CHECKING EXISTING USERS IN DATABASE ===\n\n";

// Get all users from database
$users = User::all();

if ($users->count() > 0) {
    echo "Found " . $users->count() . " users in the database:\n\n";
    
    foreach ($users as $user) {
        echo "=============================================\n";
        echo "User ID: " . $user->id . "\n";
        echo "Name: " . $user->name . "\n";
        echo "Email: " . $user->email . "\n";
        echo "Role: " . $user->role . " (";
        
        // Determine role type
        switch($user->role) {
            case 1:
                echo "Buyer";
                break;
            case 2:
                echo "Seller";
                break;
            case 3:
                echo "Admin";
                break;
            default:
                echo "Unknown";
        }
        echo ")\n";
        
        echo "Created: " . $user->created_at . "\n";
        echo "Updated: " . $user->updated_at . "\n";
        echo "Email Verified: " . ($user->email_verified_at ? "Yes" : "No") . "\n";
        echo "=============================================\n\n";
    }
    
    // Show buyers specifically
    $buyers = User::where('role', 1)->get();
    if ($buyers->count() > 0) {
        echo "\n=== BUYER ACCOUNTS (Role = 1) ===\n";
        foreach ($buyers as $buyer) {
            echo "Email: " . $buyer->email . "\n";
            echo "Name: " . $buyer->name . "\n";
            echo "Password: Since passwords are hashed, use 'password' as default\n\n";
        }
    } else {
        echo "\n❌ No buyer accounts found in database.\n";
        echo "You may need to register a new buyer account.\n\n";
    }
    
} else {
    echo "❌ No users found in the database.\n";
    echo "You may need to run seeders or register accounts manually.\n\n";
}

?>
