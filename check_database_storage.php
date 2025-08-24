<?php

require_once 'vendor/autoload.php';

// Load Laravel configuration
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

echo "=== CHECKING DATABASE STORAGE FORMAT ===\n\n";

// Get a user with categories
$user = User::whereNotNull('categories')->first();

if ($user) {
    echo "User ID: " . $user->id . "\n";
    echo "User Name: " . $user->name . "\n\n";
    
    echo "Raw categories from database:\n";
    echo "'" . $user->categories . "'\n\n";
    
    echo "Data type of categories field: " . gettype($user->categories) . "\n\n";
    
    echo "Decoded categories:\n";
    $decoded = json_decode($user->categories, true);
    print_r($decoded);
    
    echo "\nData types of individual elements:\n";
    if (is_array($decoded)) {
        foreach ($decoded as $index => $category) {
            echo "Index $index: Value = $category, Type = " . gettype($category) . "\n";
        }
    }
    
    echo "\n=== TESTING JSON ENCODE BEHAVIOR ===\n";
    
    // Test string array
    $stringArray = ["134", "135", "127"];
    echo "String array: " . json_encode($stringArray) . "\n";
    
    // Test integer array  
    $intArray = [134, 135, 127];
    echo "Integer array: " . json_encode($intArray) . "\n";
    
} else {
    echo "No user found with categories data.\n";
}

?>
