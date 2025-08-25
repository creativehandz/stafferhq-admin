<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Gig;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

echo "=== GIGS CATEGORY ANALYSIS ===\n\n";

// 1. Get all gigs with their category information
$gigs = Gig::all();
$totalGigs = $gigs->count();

echo "📊 CATEGORY STATUS OVERVIEW:\n";
echo "============================\n";
echo "Total gigs: {$totalGigs}\n\n";

// 2. Check category field status
$gigsWithCategories = $gigs->whereNotNull('category_id')->where('category_id', '!=', '');
$gigsWithoutCategories = $gigs->where(function($gig) {
    return is_null($gig->category_id) || $gig->category_id === '';
});

echo "Gigs WITH categories: " . $gigsWithCategories->count() . "\n";
echo "Gigs WITHOUT categories: " . $gigsWithoutCategories->count() . "\n\n";

// 3. Check subcategory field status
$gigsWithSubcategories = $gigs->whereNotNull('subcategory_id')->where('subcategory_id', '!=', '');
$gigsWithoutSubcategories = $gigs->where(function($gig) {
    return is_null($gig->subcategory_id) || $gig->subcategory_id === '';
});

echo "Gigs WITH subcategories: " . $gigsWithSubcategories->count() . "\n";
echo "Gigs WITHOUT subcategories: " . $gigsWithoutSubcategories->count() . "\n\n";

// 4. List all unique category IDs used
$uniqueCategoryIds = $gigs->pluck('category_id')->unique()->filter();
echo "📋 UNIQUE CATEGORY IDs USED:\n";
echo "============================\n";
foreach ($uniqueCategoryIds as $categoryId) {
    $count = $gigs->where('category_id', $categoryId)->count();
    echo "Category ID {$categoryId}: {$count} gig(s)\n";
}

// 5. Get actual category names from categories table
echo "\n🏷️ CATEGORY ID TO NAME MAPPING:\n";
echo "===============================\n";
$categories = Category::whereIn('id', $uniqueCategoryIds)->get();
foreach ($categories as $category) {
    $gigCount = $gigs->where('category_id', $category->id)->count();
    echo "ID {$category->id}: {$category->name} ({$gigCount} gig(s))\n";
}

// 6. Check for invalid category IDs (IDs that don't exist in categories table)
$validCategoryIds = $categories->pluck('id')->toArray();
$invalidCategoryIds = $uniqueCategoryIds->diff($validCategoryIds);

if ($invalidCategoryIds->count() > 0) {
    echo "\n⚠️ INVALID CATEGORY IDs FOUND:\n";
    echo "==============================\n";
    foreach ($invalidCategoryIds as $invalidId) {
        $gigCount = $gigs->where('category_id', $invalidId)->count();
        echo "Invalid ID {$invalidId}: {$gigCount} gig(s) using non-existent category\n";
    }
} else {
    echo "\n✅ All category IDs are valid!\n";
}

// 7. Detailed breakdown by gig
echo "\n📝 DETAILED GIG CATEGORY BREAKDOWN:\n";
echo "===================================\n";

foreach ($gigs as $index => $gig) {
    echo "Gig #" . ($index + 1) . " (ID: {$gig->id}):\n";
    echo "  Title: " . ($gig->gig_title ?: 'No title') . "\n";
    echo "  Category ID: " . ($gig->category_id ?: 'NONE') . "\n";
    
    if ($gig->category_id) {
        $category = $categories->where('id', $gig->category_id)->first();
        echo "  Category Name: " . ($category ? $category->name : 'INVALID ID') . "\n";
    } else {
        echo "  Category Name: NO CATEGORY ASSIGNED\n";
    }
    
    echo "  Subcategory ID: " . ($gig->subcategory_id ?: 'NONE') . "\n";
    echo "  Status: " . ($gig->status ?: 'None') . "\n";
    echo "  ---\n";
}

// 8. Summary statistics
echo "\n📈 SUMMARY STATISTICS:\n";
echo "=====================\n";
$percentageWithCategories = ($gigsWithCategories->count() / $totalGigs) * 100;
$percentageWithSubcategories = ($gigsWithSubcategories->count() / $totalGigs) * 100;

echo "Category Coverage: " . number_format($percentageWithCategories, 1) . "% ({$gigsWithCategories->count()}/{$totalGigs})\n";
echo "Subcategory Coverage: " . number_format($percentageWithSubcategories, 1) . "% ({$gigsWithSubcategories->count()}/{$totalGigs})\n";

if ($gigsWithoutCategories->count() > 0) {
    echo "\n❌ ACTION REQUIRED:\n";
    echo "==================\n";
    echo "There are {$gigsWithoutCategories->count()} gig(s) without categories.\n";
    echo "These gigs need to be assigned proper categories for better organization.\n";
} else {
    echo "\n✅ EXCELLENT!\n";
    echo "=============\n";
    echo "All gigs have categories assigned!\n";
}

echo "\n✅ Analysis complete!\n";
