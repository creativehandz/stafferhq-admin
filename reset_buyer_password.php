<?php

require_once 'vendor/autoload.php';

// Load Laravel configuration
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== RESETTING PASSWORD FOR BUYER ACCOUNT ===\n\n";

$email = 'buyer@towork.com';
$newPassword = 'password'; // Default password

// Find the user
$user = User::where('email', $email)->first();

if ($user) {
    echo "Found user: " . $user->name . " (" . $user->email . ")\n";
    echo "Current Role: " . $user->role . " (";
    
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
    echo ")\n\n";
    
    // Update the password
    $user->password = Hash::make($newPassword);
    $user->save();
    
    echo "✅ Password successfully reset!\n\n";
    echo "=== NEW LOGIN CREDENTIALS ===\n";
    echo "Email: " . $email . "\n";
    echo "Password: " . $newPassword . "\n";
    echo "Role: Buyer\n\n";
    
    echo "You can now login at: http://localhost:8000/login\n\n";
    
    // Verify the password reset worked
    if (Hash::check($newPassword, $user->password)) {
        echo "✅ Password verification successful - reset completed!\n";
    } else {
        echo "❌ Password verification failed - something went wrong!\n";
    }
    
} else {
    echo "❌ User with email '" . $email . "' not found in database.\n";
    echo "Available users:\n";
    
    $allUsers = User::all();
    foreach ($allUsers as $existingUser) {
        echo "- " . $existingUser->email . " (" . $existingUser->name . ")\n";
    }
}

?>
