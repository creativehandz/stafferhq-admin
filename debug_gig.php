<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Gig;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

echo "=== SELLER SERVICES/GIGS DATABASE ANALYSIS ===\n\n";

// 1. Check table structure
echo "1. GIGS TABLE STRUCTURE:\n";
echo "========================\n";
$columns = DB::select("DESCRIBE gigs");
foreach ($columns as $column) {
    echo "- {$column->Field} ({$column->Type}) - {$column->Null} - {$column->Key}\n";
}

echo "\n2. TOTAL GIGS COUNT:\n";
echo "===================\n";
$totalGigs = Gig::count();
echo "Total gigs in database: {$totalGigs}\n";

if ($totalGigs > 0) {
    echo "\n3. ALL GIGS WITH DETAILS:\n";
    echo "========================\n";
    
    $gigs = Gig::with('user')->get();
    
    foreach ($gigs as $index => $gig) {
        echo "Gig #" . ($index + 1) . ":\n";
        echo "  ID: {$gig->id}\n";
        echo "  User ID: {$gig->user_id}\n";
        echo "  Seller: " . ($gig->user ? $gig->user->name . " ({$gig->user->email})" : "Unknown") . "\n";
        echo "  Title: " . ($gig->gig_title ?: 'No title') . "\n";
        echo "  Description: " . ($gig->gig_description ?: 'No description') . "\n";
        echo "  Category ID: " . ($gig->category_id ?: 'None') . "\n";
        echo "  Subcategory ID: " . ($gig->subcategory_id ?: 'None') . "\n";
        echo "  Status: " . ($gig->status ?: 'None') . "\n";
        echo "  Keywords: " . ($gig->positive_keywords ?: 'None') . "\n";
        echo "  Requirements: " . ($gig->requirements ?: 'None') . "\n";
        echo "  FAQs: " . ($gig->faqs ?: 'None') . "\n";
        
        // Parse pricing if it exists
        if ($gig->pricing) {
            echo "  Pricing: " . $gig->pricing . "\n";
            $pricing = json_decode($gig->pricing, true);
            if (is_array($pricing)) {
                foreach ($pricing as $package => $details) {
                    echo "    {$package}: ";
                    if (is_array($details)) {
                        echo "Price: " . ($details['price'] ?? 'N/A') . ", ";
                        echo "Description: " . ($details['description'] ?? 'N/A') . ", ";
                        echo "Delivery: " . ($details['delivery_time'] ?? 'N/A') . "\n";
                    } else {
                        echo "{$details}\n";
                    }
                }
            }
        } else {
            echo "  Pricing: None\n";
        }
        
        echo "  Clicks: " . ($gig->clicks ?: 0) . "\n";
        echo "  Orders: " . ($gig->orders ?: 0) . "\n";
        echo "  Cancellations: " . ($gig->cancellations ?: 0) . "\n";
        echo "  Created: {$gig->created_at}\n";
        echo "  Updated: {$gig->updated_at}\n";
        echo "  -----------------------------------------\n";
    }
    
    echo "\n4. GIGS BY SELLER:\n";
    echo "==================\n";
    
    $sellers = User::where('role', 2)->get(); // Assuming role 2 is seller
    foreach ($sellers as $seller) {
        $sellerGigs = Gig::where('user_id', $seller->id)->count();
        echo "- {$seller->name} ({$seller->email}): {$sellerGigs} gig(s)\n";
    }
    
} else {
    echo "\n❌ No gigs found in the database.\n";
    echo "Sellers may not have created any services yet.\n";
}

echo "\n5. RECENT ACTIVITY:\n";
echo "==================\n";
$recentGigs = Gig::orderBy('created_at', 'desc')->take(5)->with('user')->get();
if ($recentGigs->count() > 0) {
    foreach ($recentGigs as $gig) {
        echo "- {$gig->gig_title} by " . ($gig->user ? $gig->user->name : 'Unknown') . " (Created: {$gig->created_at})\n";
    }
} else {
    echo "No recent gigs found.\n";
}

echo "\n✅ Analysis complete!\n";
