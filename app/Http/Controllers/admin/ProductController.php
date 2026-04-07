<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Inventory;

class ProductController extends Controller
{
        public function addproduct()
    {
        $category = Category::all();
        return view('admin/add-product', compact('category'));
    }

    public function storeproduct(Request $request)
    {
        $request->validate([
            'p_name' => 'required',
            'p_price' => 'required',
            'c_id' => 'required',
            'p_stock' => 'required',
            'p_description' => 'required',
            'p_image' => 'required|image',
            'status' => 'required|in:active,inactive,out_of_stock,discontinued',
        ]);

        $imagePath = $request->file('p_image')->store('products', 'public');

        Product::create([
            'p_name' => $request->p_name,
            'p_price' => $request->p_price,
            'c_id' => $request->c_id,
            'p_stock' => $request->p_stock,
            'p_description' => $request->p_description,
            'p_image' => $imagePath,
            'status' => $request->status,
        ]);

        // Automatically create inventory entry for new product
        $product = Product::latest()->first();
        Inventory::create([
            'product_id' => $product->p_id,
            'location' => 'Warehouse 1', // Default location
            'available_quantity' => $request->p_stock,
            'reserved_quantity' => 0,
            'on_hand_quantity' => $request->p_stock,
            'unit_cost' => 0, // Default cost
            'description' => 'Auto-created inventory entry for ' . $request->p_name,
        ]);

        return redirect()->route('admin.view-product')->with('success', 'Product added successfully!');
    }

    public function viewproduct()
    {
        $products = Product::all();
        return view('admin/view-product', compact('products'));
    }
     public function editproduct($p_id)
    {
        $product = Product::findOrFail($p_id);
        $category = Category::all();
        return view('admin/edit-product', compact('product' , 'category'));
    }

    public function updateproduct(Request $request, $p_id)
    {
        $product = Product::findOrFail($p_id);

        $request->validate([
            'p_name' => 'required|string|max:255',
            'p_price' => 'required|numeric|min:0',
            'c_id' => 'required|exists:categories,c_id',
            'p_stock' => 'required|integer|min:0',
            'p_description' => 'required|string',
            'p_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,out_of_stock,discontinued',
        ]);

        $data = [
            'p_name' => $request->p_name,
            'p_price' => $request->p_price,
            'c_id' => $request->c_id,
            'p_stock' => $request->p_stock,
            'p_description' => $request->p_description,
            'status' => $request->status,
        ];

        if ($request->hasFile('p_image')) {
            $imagePath = $request->file('p_image')->store('products', 'public');
            $data['p_image'] = $imagePath;
        }

        $product->update($data);

        return redirect()->route('admin.view-product')->with('success', 'Product updated successfully!');
    }

    public function deleteproduct($p_id)
    {
        $product = Product::findOrFail($p_id);
        $product->delete();

        return redirect()->route('admin.view-product')->with('success', 'Product deleted successfully!');
    }

    public function bulkProductStatusUpdate(Request $request)
    {
        $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,p_id',
            'status' => 'required|in:active,inactive,out_of_stock,discontinued',
        ]);
        
        $updatedCount = Product::whereIn('p_id', $request->product_ids)
                            ->update(['status' => $request->status]);
        
        return redirect()->route('admin.view-product')
                    ->with('success', "Successfully updated status for {$updatedCount} products to " . ucfirst(str_replace('_', ' ', $request->status)) . "!");
    }
}
