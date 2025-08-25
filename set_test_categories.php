<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Category;

echo "=== Setting Test Categories for Buyer ===\n\n";

// Get the buyer user
$buyer = User::where('email', 'buyer@towork.com')->first();

if (!$buyer) {
    echo "Buyer user not found!\n";
    exit;
}

// Set some test categories (Web Development and Mobile Development)
$testCategories = [134, 135, 125]; // Web Development, Mobile Development, AC Repair
$buyer->interested_categories = json_encode($testCategories);
$buyer->save();

echo "Set categories for buyer: " . implode(', ', $testCategories) . "\n";
echo "Saved interested_categories: {$buyer->interested_categories}\n\n";

// Verify the data
$categoryIds = json_decode($buyer->interested_categories, true);
$categories = Category::whereIn('id', $categoryIds)->get();

echo "Selected categories:\n";
foreach ($categories as $category) {
    echo "- {$category->name} (ID: {$category->id})\n";
}

echo "\n=== Testing What Controller Will Return ===\n";
$userCategories = Category::whereIn('id', $categoryIds)->get(['id', 'name']);
echo "Controller data:\n";
echo json_encode($userCategories->toArray(), JSON_PRETTY_PRINT);
