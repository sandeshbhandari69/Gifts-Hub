<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function list($slug)
    {
        $cartItems = Session::get('cart', []);
        return view('cart-list', ['cartItems' => $cartItems]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'image' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        // Check if this is a "Buy Now" request - clear cart first
        if ($request->has('redirect_to') && $request->redirect_to === 'checkout') {
            // Clear existing cart for Buy Now
            Session::forget('cart');
            $cart = [];
        } else {
            $cart = Session::get('cart', []);
        }
        
        // Check if product already exists in cart
        $existingItemIndex = -1;
        foreach ($cart as $index => $item) {
            if ($item['id'] === $request->id) {
                $existingItemIndex = $index;
                break;
            }
        }
        
        if ($existingItemIndex !== -1) {
            // Update quantity if item exists
            $cart[$existingItemIndex]['quantity'] += $request->quantity;
        } else {
            // Add new item if it doesn't exist
            $cart[] = [
                'id' => $request->id,
                'name' => $request->name,
                'price' => $request->price,
                'image' => $request->image,
                'quantity' => $request->quantity
            ];
        }

        Session::put('cart', $cart);

        // Check if this is a "Buy Now" request
        if ($request->has('redirect_to') && $request->redirect_to === 'checkout') {
            return redirect()->route('checkout', ['slug' => 'products'])->with('success', 'Product added to cart successfully!');
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function updateQuantity(Request $request)
    {
        Log::info('Update quantity request received', $request->all());
        
        $request->validate([
            'id' => 'required',
            'action' => 'required|in:increase,decrease'
        ]);

        $cart = Session::get('cart', []);
        $itemId = $request->id;
        $action = $request->action;
        $updatedQuantity = 1;
        $foundItem = false;
        
        Log::info('Cart items before update', $cart);
        Log::info('Looking for item ID: ' . $itemId);

        foreach ($cart as $key => $item) {
            if ($item['id'] === $itemId) {
                $foundItem = true;
                Log::info('Found item at key: ' . $key, $item);
                
                if ($action === 'increase') {
                    $cart[$key]['quantity']++;
                    Log::info('Increased quantity to: ' . $cart[$key]['quantity']);
                } elseif ($action === 'decrease' && $cart[$key]['quantity'] > 1) {
                    $cart[$key]['quantity']--;
                    Log::info('Decreased quantity to: ' . $cart[$key]['quantity']);
                }
                $updatedQuantity = $cart[$key]['quantity'];
                break;
            }
        }
        
        Log::info('Item found: ' . ($foundItem ? 'yes' : 'no'));
        Log::info('Updated quantity: ' . $updatedQuantity);

        Session::put('cart', $cart);
        Log::info('Cart after update', Session::get('cart'));
        
        if ($foundItem) {
            return response()->json(['success' => true, 'quantity' => $updatedQuantity]);
        } else {
            Log::error('Item not found in cart');
            return response()->json(['success' => false, 'message' => 'Item not found in cart']);
        }
    }

    public function remove(Request $request)
    {
        $cart = Session::get('cart', []);
        $id = $request->id;

        $cart = array_filter($cart, function($item) use ($id) {
            return $item['id'] !== $id;
        });

        Session::put('cart', array_values($cart));
        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    public function clear()
    {
        Session::forget('cart');
        return redirect()->back()->with('success', 'Cart cleared!');
    }
}