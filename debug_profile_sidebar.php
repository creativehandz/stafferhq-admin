<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Profile Image Debug ===\n";

// Get the current user (assuming user ID 1 for testing)
$user = App\Models\User::find(1);
if ($user) {
    echo "User found: {$user->name}\n";
    echo "Profile image: " . ($user->profile_image ?: 'NULL') . "\n";
    
    if ($user->profile_image) {
        $fullPath = public_path($user->profile_image);
        echo "Full path: {$fullPath}\n";
        echo "File exists: " . (file_exists($fullPath) ? 'YES' : 'NO') . "\n";
        
        // Check if it's accessible via web
        $webPath = url($user->profile_image);
        echo "Web URL: {$webPath}\n";
        
        // List profile images directory
        $profileDir = public_path('storage/profile-images');
        echo "Profile images directory: {$profileDir}\n";
        echo "Directory exists: " . (is_dir($profileDir) ? 'YES' : 'NO') . "\n";
        
        if (is_dir($profileDir)) {
            echo "Files in directory:\n";
            $files = scandir($profileDir);
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    echo "  - {$file}\n";
                }
            }
        }
    }
} else {
    echo "No user found with ID 1\n";
}

echo "========================\n";
?>
