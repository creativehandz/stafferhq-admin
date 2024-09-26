<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function getCategoriesWithSubcategories() {
        $categories = Category::with('subcategories')->get();
        return response()->json($categories);
    }
    
}
