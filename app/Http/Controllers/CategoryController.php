<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function detail($slug = null)
    {
        $categories = Category::withCount('products')->get();
        
        if ($slug === null) {
            // Show all categories page
            return view('category', compact('categories'));
        }
        
        // Show products for specific category
        $currentCategory = Category::where('c_name', 'like', '%' . str_replace('-', ' ', $slug) . '%')->first();
        
        if (!$currentCategory) {
            // Try exact match
            $currentCategory = Category::whereRaw('LOWER(c_name) = ?', [strtolower(str_replace('-', ' ', $slug))])->first();
        }
        
        if ($currentCategory) {
            $products = Product::with('category')->where('c_id', $currentCategory->c_id)->get();
        } else {
            $products = collect(); // Empty collection if category not found
        }
        
        return view('category-products', compact('categories', 'products', 'currentCategory'));
    }
}
