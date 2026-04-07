<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    private function getCategoryIcon($categoryName)
    {
        $iconMap = [
            'electronics' => 'fa-laptop',
            'electronic' => 'fa-laptop',
            'phones' => 'fa-mobile-alt',
            'phone' => 'fa-mobile-alt',
            'mobile' => 'fa-mobile-alt',
            'computer' => 'fa-desktop',
            'laptop' => 'fa-laptop',
            'clothing' => 'fa-tshirt',
            'fashion' => 'fa-tshirt',
            'shirt' => 'fa-tshirt',
            'dress' => 'fa-female',
            'shoes' => 'fa-shoe-prints',
            'footwear' => 'fa-shoe-prints',
            'books' => 'fa-book',
            'book' => 'fa-book',
            'education' => 'fa-graduation-cap',
            'home' => 'fa-home',
            'furniture' => 'fa-couch',
            'decor' => 'fa-palette',
            'kitchen' => 'fa-utensils',
            'cooking' => 'fa-utensils',
            'food' => 'fa-utensils',
            'toys' => 'fa-gamepad',
            'games' => 'fa-gamepad',
            'sports' => 'fa-football-ball',
            'fitness' => 'fa-dumbbell',
            'health' => 'fa-heartbeat',
            'beauty' => 'fa-spa',
            'cosmetics' => 'fa-spa',
            'jewelry' => 'fa-gem',
            'accessories' => 'fa-glasses',
            'bags' => 'fa-shopping-bag',
            'watches' => 'fa-clock',
            'automotive' => 'fa-car',
            'car' => 'fa-car',
            'baby' => 'fa-baby',
            'kids' => 'fa-child',
            'children' => 'fa-child',
            'pets' => 'fa-paw',
            'animals' => 'fa-paw',
            'garden' => 'fa-leaf',
            'plants' => 'fa-seedling',
            'tools' => 'fa-tools',
            'hardware' => 'fa-wrench',
            'music' => 'fa-music',
            'instruments' => 'fa-guitar',
            'camera' => 'fa-camera',
            'photography' => 'fa-camera',
            'art' => 'fa-paint-brush',
            'crafts' => 'fa-paint-brush',
            'office' => 'fa-briefcase',
            'business' => 'fa-briefcase',
            'travel' => 'fa-plane',
            'luggage' => 'fa-suitcase',
            'outdoor' => 'fa-campground',
            'camping' => 'fa-campground',
        ];
        
        $categoryNameLower = strtolower($categoryName);
        
        // Check for exact matches first
        if (isset($iconMap[$categoryNameLower])) {
            return $iconMap[$categoryNameLower];
        }
        
        // Check for partial matches
        foreach ($iconMap as $key => $icon) {
            if (strpos($categoryNameLower, $key) !== false) {
                return $icon;
            }
        }
        
        // Default icon if no match found
        return 'fa-folder';
    }

    public function index()
    {
        $categories = Category::withCount('products')->get();
        
        // Add icons to categories
        $categories->each(function($category) {
            $category->icon = $this->getCategoryIcon($category->c_name);
        });
        
        return view('category', compact('categories'));
    }

    public function detail($slug = null)
    {
        $categories = Category::withCount('products')->get();
        
        // Add icons to categories
        $categories->each(function($category) {
            $category->icon = $this->getCategoryIcon($category->c_name);
        });
        
        if ($slug === null) {
            // Show all categories page
            return view('category', compact('categories'));
        }
        
        // Convert slug to different possible formats for matching
        $slugName = str_replace('-', ' ', $slug);
        $slugNameLower = strtolower($slugName);
        
        // Try multiple ways to find the category
        $currentCategory = null;
        
        // 1. Try exact match with spaces
        $currentCategory = Category::whereRaw('LOWER(c_name) = ?', [$slugNameLower])->first();
        
        // 2. Try partial match
        if (!$currentCategory) {
            $currentCategory = Category::whereRaw('LOWER(c_name) LIKE ?', ['%' . $slugNameLower . '%'])->first();
        }
        
        // 3. Try matching with hyphens
        if (!$currentCategory) {
            $currentCategory = Category::whereRaw('LOWER(c_name) = ?', [strtolower($slug)])->first();
        }
        
        // 4. Try case-insensitive match across all categories
        if (!$currentCategory) {
            $currentCategory = $categories->first(function($cat) use ($slugNameLower) {
                return strtolower(str_replace(' ', '-', $cat->c_name)) === strtolower($slug) ||
                       strtolower($cat->c_name) === $slugNameLower ||
                       strpos(strtolower($cat->c_name), $slugNameLower) !== false;
            });
        }
        
        if ($currentCategory) {
            $products = Product::with('category')->where('c_id', $currentCategory->c_id)->get();
        } else {
            $products = collect(); // Empty collection if category not found
        }
        
        return view('category-products', compact('categories', 'products', 'currentCategory'));
    }
}
