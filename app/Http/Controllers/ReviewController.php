<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReviewController extends Controller
{
    public function submit(Request $request)
    {
        // Debug: Log incoming data
        \Log::info('Review submit attempt', $request->all());
        
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
        
        // Debug: Log the created review
        \Log::info('Created review', $review);
        
        // Add review to the beginning of the array
        array_unshift($reviews, $review);
        
        // Store reviews in session (limit to last 50 reviews to prevent session bloat)
        if (count($reviews) > 50) {
            $reviews = array_slice($reviews, 0, 50);
        }
        
        Session::put('reviews', $reviews);
        
        // Debug: Log session data
        \Log::info('Reviews in session', Session::get('reviews', []));
        
        return redirect()->back()->with('success', 'Your review has been submitted successfully!');
    }
    
    public function getProductReviews($productId)
    {
        // Debug: Log the product ID being searched
        \Log::info('Getting reviews for product ID: ' . $productId);
        
        $reviews = Session::get('reviews', []);
        
        // Debug: Log all reviews in session
        \Log::info('All reviews in session', $reviews);
        
        $productReviews = array_filter($reviews, function($review) use ($productId) {
            // Handle both string and integer comparisons for robustness
            return $review['product_id'] == $productId;
        });
        
        // Debug: Log filtered reviews
        \Log::info('Filtered reviews for product', array_values($productReviews));
        
        return collect(array_values($productReviews));
    }
    
    public function delete(Request $request)
    {
        $reviewId = $request->input('review_id');
        $reviews = Session::get('reviews', []);
        
        // Filter out the review to delete
        $updatedReviews = array_filter($reviews, function($review) use ($reviewId) {
            return $review['id'] !== $reviewId;
        });
        
        Session::put('reviews', array_values($updatedReviews));
        
        return redirect()->back()->with('success', 'Review deleted successfully!');
    }
    
    public function update(Request $request)
    {
        $reviewId = $request->input('review_id');
        $reviews = Session::get('reviews', []);
        
        // Find and update the review
        foreach ($reviews as $key => $review) {
            if ($review['id'] === $reviewId) {
                $reviews[$key]['name'] = $request->input('name');
                $reviews[$key]['email'] = $request->input('email');
                $reviews[$key]['rating'] = $request->input('rating');
                $reviews[$key]['comment'] = $request->input('comment');
                $reviews[$key]['updated_at'] = now()->format('M d, Y');
                break;
            }
        }
        
        Session::put('reviews', $reviews);
        
        return redirect()->back()->with('success', 'Review updated successfully!');
    }
}
