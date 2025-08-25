<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Category;

echo "=== Testing Controller Data Output ===\n\n";

// Get the buyer user
$buyer = User::where('email', 'buyer@towork.com')->first();

if (!$buyer) {
    echo "Buyer user not found!\n";
    exit;
}

echo "User Categories JSON: {$buyer->categories}\n\n";

// Simulate what the controller does
$userCategories = collect();
if ($buyer->categories) {
    $categoryIds = json_decode($buyer->categories, true);
    if (is_array($categoryIds) && !empty($categoryIds)) {
        $userCategories = Category::whereIn('id', $categoryIds)->get(['id', 'name']);
    }
}

echo "Controller Output (userCategories):\n";
echo json_encode($userCategories->toArray(), JSON_PRETTY_PRINT);

echo "\n\n=== Simulating Inertia Response ===\n";
$responseData = [
    'user' => [
        'id' => $buyer->id,
        'name' => $buyer->name,
        'email' => $buyer->email,
        'categories' => $buyer->categories
    ],
    'userCategories' => $userCategories
];

echo json_encode($responseData, JSON_PRETTY_PRINT);
