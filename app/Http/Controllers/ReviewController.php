<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReviewController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
            'product_id' => 'required',
            'product_name' => 'required'
        ]);

        // Get existing reviews from session or create empty array
        $reviews = Session::get('reviews', []);
        
        // Create new review
        $review = [
            'id' => uniqid(),
            'product_id' => $request->product_id,
            'product_name' => $request->product_name,
            'name' => $request->name,
            'email' => $request->email,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'created_at' => now()->format('M d, Y'),
            'status' => 'approved' // Auto-approve for demo
        ];
        
        // Add review to the beginning of the array
        array_unshift($reviews, $review);
        
        // Store reviews in session (limit to last 50 reviews to prevent session bloat)
        if (count($reviews) > 50) {
            $reviews = array_slice($reviews, 0, 50);
        }
        
        Session::put('reviews', $reviews);
        
        return redirect()->back()->with('success', 'Your review has been submitted successfully!');
    }
    
    public function getProductReviews($productId)
    {
        $reviews = Session::get('reviews', []);
        $productReviews = array_filter($reviews, function($review) use ($productId) {
            // Handle both string and integer comparisons for robustness
            return $review['product_id'] == $productId;
        });
        
        return array_values($productReviews);
    }
}
