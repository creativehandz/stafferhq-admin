<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Category;

echo "=== Checking Categories Column ===\n\n";

// Get the buyer user
$buyer = User::where('email', 'buyer@towork.com')->first();

if (!$buyer) {
    echo "Buyer user not found!\n";
    exit;
}

echo "Buyer categories column content: '{$buyer->categories}'\n\n";

// Check all users and their categories
$users = User::all();
echo "All users and their categories:\n";
foreach ($users as $user) {
    echo "- {$user->email}: '{$user->categories}'\n";
}

echo "\n=== Setting Test Categories Using 'categories' Column ===\n";

// Set some test categories (Web Development and Mobile Development)
$testCategories = [134, 135, 125]; // Web Development, Mobile Development, AC Repair
$buyer->categories = json_encode($testCategories);
$buyer->save();

echo "Set categories for buyer: " . implode(', ', $testCategories) . "\n";
echo "Saved categories: {$buyer->categories}\n\n";

// Verify the data
$categoryIds = json_decode($buyer->categories, true);
$categoriesData = Category::whereIn('id', $categoryIds)->get();

echo "Selected categories:\n";
foreach ($categoriesData as $category) {
    echo "- {$category->name} (ID: {$category->id})\n";
}
