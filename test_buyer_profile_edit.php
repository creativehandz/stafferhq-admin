<?php

// Test script to verify buyer profile functionality
// Run this file to test if the buyer profile edit system works

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\User;
use App\Models\Category;

echo "=== Buyer Profile Edit System Test ===\n\n";

// Check if Category table has data
try {
    $categories = Category::take(5)->get();
    echo "✓ Categories found: " . $categories->count() . " categories available\n";
    foreach ($categories as $category) {
        echo "  - {$category->name}\n";
    }
} catch (Exception $e) {
    echo "✗ Error accessing categories: " . $e->getMessage() . "\n";
}

echo "\n";

// Check if User model has required fields
try {
    $userFillable = (new User())->getFillable();
    $requiredFields = ['name', 'email', 'phone', 'website', 'company_size', 'location', 'social_links', 'categories'];
    
    echo "✓ User model fillable fields:\n";
    foreach ($requiredFields as $field) {
        if (in_array($field, $userFillable)) {
            echo "  ✓ {$field}\n";
        } else {
            echo "  ✗ {$field} (missing)\n";
        }
    }
} catch (Exception $e) {
    echo "✗ Error checking User model: " . $e->getMessage() . "\n";
}

echo "\n";

// Check if buyer@towork.com user exists
try {
    $buyerUser = User::where('email', 'buyer@towork.com')->first();
    if ($buyerUser) {
        echo "✓ Buyer test user found:\n";
        echo "  - Name: {$buyerUser->name}\n";
        echo "  - Email: {$buyerUser->email}\n";
        echo "  - Phone: " . ($buyerUser->phone ?: 'Not set') . "\n";
        echo "  - Location: " . ($buyerUser->location ?: 'Not set') . "\n";
        echo "  - Website: " . ($buyerUser->website ?: 'Not set') . "\n";
        echo "  - Company Size: " . ($buyerUser->company_size ?: 'Not set') . "\n";
        echo "  - Categories: " . ($buyerUser->categories ?: 'None selected') . "\n";
        echo "  - Social Links: " . ($buyerUser->social_links ?: 'None set') . "\n";
    } else {
        echo "✗ Buyer test user not found\n";
    }
} catch (Exception $e) {
    echo "✗ Error checking buyer user: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";
echo "\nTo test the buyer profile edit functionality:\n";
echo "1. Login as buyer@towork.com (password: password)\n";
echo "2. Visit: http://127.0.0.1:8000/buyer-profile\n";
echo "3. Click 'Edit Profile' button\n";
echo "4. Fill out the form and submit\n";
echo "5. Verify changes are saved\n";
