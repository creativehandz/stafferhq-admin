<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    
  // Fetch all categories along with their subcategories
  public function getAllCategoriesWithSubCategories()
  {
      // Fetch all categories with their related subcategories
      $categories = Category::with('subCategories')->get();

      return Inertia::render('Categories', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'categories' => $categories
    ]);
  }

  public function getCategoryDetail($categoryId) {
    $category = Category::where('id', $categoryId)->with('subCategories')->firstOrFail();
    return Inertia::render('CategoryDetail', [
      'canLogin' => Route::has('login'),
      'canRegister' => Route::has('register'),
      'category' => $category,
    ]);
  }
}
