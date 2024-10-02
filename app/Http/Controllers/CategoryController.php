<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
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
  
  // Method to get categories along with their subcategories
  public function getCategoriesWithSubcategories()
  {
      // Fetch categories with subcategories using Eloquent relationships
      $categories = Category::with('subCategories')->get();

      // Return the data to the frontend (you can use inertia or normal response based on your setup)
      return Inertia::render('Categories', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'categories' => $categories
    ]);
  }

  public function getAllCategoriesWithSubCategories()
  {
    $categories = Category::with('subCategories')->get();
    return $categories;
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
