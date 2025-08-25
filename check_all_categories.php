<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Category;

echo "=== ALL AVAILABLE CATEGORIES ===\n\n";

$categories = Category::orderBy('name')->get();

echo "📋 COMPLETE CATEGORY LIST:\n";
echo "==========================\n";
foreach ($categories as $category) {
    echo "ID {$category->id}: {$category->name}\n";
}

echo "\n🎯 CATEGORIES CURRENTLY USED BY GIGS:\n";
echo "====================================\n";
$usedCategoryIds = [125, 126, 127, 128];
foreach ($usedCategoryIds as $id) {
    $category = $categories->where('id', $id)->first();
    if ($category) {
        echo "✅ ID {$id}: {$category->name}\n";
    }
}

echo "\n💡 POTENTIAL BETTER CATEGORY MATCHES:\n";
echo "====================================\n";
echo "Based on the service titles, here are some observations:\n\n";

echo "🔌 ELECTRICAL SERVICES (currently in 'AC Repair' - ID 125):\n";
echo "- Residential Electrical Wiring Installation\n";
echo "- Commercial Electrical Panel Upgrade\n";
echo "- Emergency Electrical Repair Service\n";
echo "- LED Lighting Installation & Setup\n";
echo "- Electrical Safety Inspection & Testing\n";
echo "- Appliance Installation & Hookup Service\n";
echo "- Home Safety System Installation\n";
echo "- Generator Installation & Backup Power Setup\n";
echo "👆 These might be better in a dedicated 'Electrical' category\n\n";

echo "❄️ HVAC SERVICES (currently in 'AC Repair' - ID 125):\n";
echo "- Central Air Conditioning Installation\n";
echo "- Furnace Repair & Maintenance Service\n";
echo "- Ductwork Installation & Repair\n";
echo "- Smart Thermostat Installation & Setup\n";
echo "- HVAC System Inspection & Tune-up\n";
echo "👆 These are correctly categorized as HVAC/AC services\n\n";

echo "🔧 PLUMBING SERVICES (currently in 'Plumber' - ID 126):\n";
echo "- Complete Bathroom Plumbing Installation\n";
echo "- Kitchen Sink & Dishwasher Hookup\n";
echo "- Emergency Plumbing Leak Repair\n";
echo "- Water Heater Installation & Replacement\n";
echo "- Drain Cleaning & Unclogging Service\n";
echo "👆 These are correctly categorized\n\n";

echo "🏗️ OTHER SERVICES:\n";
echo "- Industrial Equipment Repair (Iron Worker - ID 128) ✅ Correct\n";
echo "- Garage Door Installation (Carpenter - ID 127) ✅ Reasonable\n";

echo "\n📊 CATEGORY USAGE SUMMARY:\n";
echo "=========================\n";
echo "Total services: 20\n";
echo "- AC Repair/HVAC: 13 services (65%)\n";
echo "- Plumber: 5 services (25%)\n";
echo "- Carpenter: 1 service (5%)\n";
echo "- Iron Worker: 1 service (5%)\n";

echo "\n✅ Analysis complete!\n";
