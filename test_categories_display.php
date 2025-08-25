<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Category;

echo "=== Testing Categories Display Functionality ===\n\n";

// Get the buyer user
$buyer = User::where('email', 'buyer@towork.com')->first();

if (!$buyer) {
    echo "Buyer user not found. Let me check all users:\n";
    $users = User::all();
    foreach ($users as $user) {
        echo "- {$user->email} (ID: {$user->id})\n";
    }
    exit;
}

echo "Found buyer: {$buyer->email} (ID: {$buyer->id})\n";
echo "Interested categories: {$buyer->interested_categories}\n\n";

// Check if interested_categories is set and not empty
if ($buyer->interested_categories) {
    $categoryIds = json_decode($buyer->interested_categories, true);
    
    if (is_array($categoryIds) && !empty($categoryIds)) {
        echo "Category IDs: " . implode(', ', $categoryIds) . "\n\n";
        
        // Get the actual category names
        $categories = Category::whereIn('id', $categoryIds)->get();
        
        echo "Category details:\n";
        foreach ($categories as $category) {
            echo "- {$category->name} (ID: {$category->id})\n";
        }
    } else {
        echo "No categories selected or invalid format.\n";
    }
} else {
    echo "No interested categories set for this user.\n";
}

// Also show all available categories
echo "\n=== All Available Categories ===\n";
$allCategories = Category::all();
foreach ($allCategories as $category) {
    echo "- {$category->name} (ID: {$category->id})\n";
}

echo "\n=== Testing Controller Logic ===\n";
// Simulate what the controller does
if ($buyer->interested_categories) {
    $categoryIds = json_decode($buyer->interested_categories, true);
    if (is_array($categoryIds) && !empty($categoryIds)) {
        $userCategories = Category::whereIn('id', $categoryIds)->get(['id', 'name']);
        echo "User categories for controller:\n";
        foreach ($userCategories as $cat) {
            echo "- {$cat->name}\n";
        }
    }
}
