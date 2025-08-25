<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Fixing Seller Profile Image Path ===\n";

// Get User 3 (seller)
$seller = App\Models\User::find(3);
if ($seller) {
    echo "Current seller info:\n";
    echo "Name: {$seller->name}\n";
    echo "Email: {$seller->email}\n";
    echo "Current profile image: {$seller->profile_image}\n";
    
    // Check if the file exists in the correct location
    $currentPath = $seller->profile_image;
    $correctPath = "storage/" . $currentPath;
    
    echo "Checking file paths:\n";
    echo "Current path: {$currentPath}\n";
    echo "Correct path: {$correctPath}\n";
    
    $currentFullPath = public_path($currentPath);
    $correctFullPath = public_path($correctPath);
    
    echo "Current full path exists: " . (file_exists($currentFullPath) ? 'YES' : 'NO') . "\n";
    echo "Correct full path exists: " . (file_exists($correctFullPath) ? 'YES' : 'NO') . "\n";
    
    // Update the path if the correct path exists
    if (file_exists($correctFullPath)) {
        $seller->profile_image = $correctPath;
        $seller->save();
        echo "✅ Updated profile image path to: {$correctPath}\n";
    } else {
        echo "❌ Correct path file doesn't exist, checking if we need to move the file\n";
        
        // Check if file exists in storage/profile-images directory
        $filename = basename($currentPath);
        $storageProfilePath = "storage/profile-images/{$filename}";
        $storageProfileFullPath = public_path($storageProfilePath);
        
        echo "Checking storage profile path: {$storageProfilePath}\n";
        echo "Storage profile path exists: " . (file_exists($storageProfileFullPath) ? 'YES' : 'NO') . "\n";
        
        if (file_exists($storageProfileFullPath)) {
            $seller->profile_image = $storageProfilePath;
            $seller->save();
            echo "✅ Updated profile image path to: {$storageProfilePath}\n";
        } else {
            echo "❌ File not found in expected locations\n";
        }
    }
} else {
    echo "❌ Seller user (ID 3) not found\n";
}

echo "=====================================\n";
?>
