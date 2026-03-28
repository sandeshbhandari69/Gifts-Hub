<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view wishlist');
        }
        
        $wishlists = Wishlist::where('user_id', Auth::id())->get();
        return view('wishlist', compact('wishlists'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to add to wishlist');
        }

        $request->validate([
            'product_name' => 'required',
            'product_price' => 'required',
            'product_image' => 'required',
        ]);

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_image' => $request->product_image,
        ]);

        return back()->with('success', 'Product added to wishlist!');
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::findOrFail($id);
        
        if ($wishlist->user_id == Auth::id()) {
            $wishlist->delete();
            return back()->with('success', 'Product removed from wishlist!');
        }

        return back()->with('error', 'Unauthorized access');
    }
}
