<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->boot();

echo "=== BUYER PROFILE IMAGE DEBUG ===\n";

// Check buyer user
$buyer = App\Models\User::where('email', 'buyer@towork.com')->first();
if ($buyer) {
    echo "Buyer User Found:\n";
    echo "ID: {$buyer->id}\n";
    echo "Name: {$buyer->name}\n";
    echo "Email: {$buyer->email}\n";
    echo "Profile Image: " . ($buyer->profile_image ?: 'NULL') . "\n";
    echo "Profile Image Path: " . ($buyer->profile_image ? public_path($buyer->profile_image) : 'N/A') . "\n";
    
    // Check if file exists
    if ($buyer->profile_image && file_exists(public_path($buyer->profile_image))) {
        echo "File exists: YES\n";
    } else {
        echo "File exists: NO\n";
    }
} else {
    echo "Buyer user not found!\n";
}

echo "\n=== SELLER PROFILE IMAGE CHECK ===\n";

// Check seller user (from the logs, we know seller has profile image)
$seller = App\Models\User::where('email', 'seller@towork.com')->first();
if ($seller) {
    echo "Seller User Found:\n";
    echo "ID: {$seller->id}\n";
    echo "Name: {$seller->name}\n";
    echo "Email: {$seller->email}\n";
    echo "Profile Image: " . ($seller->profile_image ?: 'NULL') . "\n";
    echo "Profile Image Path: " . ($seller->profile_image ? public_path($seller->profile_image) : 'N/A') . "\n";
    
    // Check if file exists
    if ($seller->profile_image && file_exists(public_path($seller->profile_image))) {
        echo "File exists: YES\n";
    } else {
        echo "File exists: NO\n";
    }
} else {
    echo "Seller user not found!\n";
}

echo "\n=== STORAGE DIRECTORY CHECK ===\n";
$storageDir = public_path('storage/profile-images');
echo "Storage directory: {$storageDir}\n";
echo "Directory exists: " . (is_dir($storageDir) ? 'YES' : 'NO') . "\n";
echo "Directory writable: " . (is_writable($storageDir) ? 'YES' : 'NO') . "\n";

if (is_dir($storageDir)) {
    $files = glob($storageDir . '/*');
    echo "Files in directory: " . count($files) . "\n";
    foreach ($files as $file) {
        echo "  - " . basename($file) . "\n";
    }
}

echo "\n=== END DEBUG ===\n";
