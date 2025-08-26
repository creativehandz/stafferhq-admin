<?php

require_once 'vendor/autoload.php';

// Bootstrap the Laravel application
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING COMMON PASSWORDS FOR seller@towork.com ===\n\n";

$user = App\Models\User::where('email', 'seller@towork.com')->first();

if (!$user) {
    echo "User not found!\n";
    exit;
}

$commonPasswords = [
    'password',
    'password123', 
    '12345678',
    'secret',
    'admin',
    'seller',
    'test',
    'towork123'
];

echo "Testing common passwords against the hash: {$user->password}\n\n";

foreach ($commonPasswords as $password) {
    if (Hash::check($password, $user->password)) {
        echo "✅ FOUND! Password is: '{$password}'\n";
        exit;
    } else {
        echo "❌ Not '{$password}'\n";
    }
}

echo "\n🔍 None of the common passwords matched.\n";
echo "The password might be custom or you may need to reset it.\n\n";

echo "To reset the password, you can run:\n";
echo "php artisan tinker\n";
echo "Then: \$user = App\\Models\\User::where('email', 'seller@towork.com')->first();\n";
echo "Then: \$user->password = Hash::make('newpassword');\n";
echo "Then: \$user->save();\n";

?>
