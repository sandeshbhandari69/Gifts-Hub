<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductdetailController extends Controller
{
    public function index($slug)
    {
        // Try to find product by slug (product name)
        $product = Product::with('category')
            ->where('p_name', 'like', '%' . str_replace('-', ' ', $slug) . '%')
            ->orWhereRaw('LOWER(p_name) = ?', [strtolower(str_replace('-', ' ', $slug))])
            ->first();
        
        if (!$product) {
            // Fallback: try to find by slug conversion
            $products = Product::all();
            foreach ($products as $p) {
                if (Str::slug($p->p_name) === $slug) {
                    $product = $p;
                    break;
                }
            }
        }
        
        if (!$product) {
            abort(404, 'Product not found');
        }
        
        // Get related products from same category
        $relatedProducts = Product::with('category')
            ->where('c_id', $product->c_id)
            ->where('p_id', '!=', $product->p_id)
            ->take(4)
            ->get();
        
        // Get reviews for this product
        $reviewController = new \App\Http\Controllers\ReviewController();
        $reviews = $reviewController->getProductReviews($product->p_id);

        return view('product-detail1', compact('product', 'relatedProducts', 'reviews'));
    }
}
