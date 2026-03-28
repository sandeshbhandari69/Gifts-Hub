<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    // Show add category form
    public function addcategory()
    {
        return view('admin/add-category');
    }

    // Store new category
    public function createcategory(Request $request)
    {
        $request->validate([
            'c_name' => 'required|string|max:255',
        ]);

        Category::create([
            'c_name' => $request->c_name,
        ]);

        return redirect()->route('admin.add-category')->with('success', 'Category added successfully!');
    }

    // View all categories
    public function viewcategory()
    {
        $categories = Category::all(); // Make sure variable name matches compact
        return view('admin/view-category', compact('categories'));
    }

    // Show edit form
    public function editcategory($c_id)
    {
        $category = Category::findOrFail($c_id);
        return view('admin/edit-category', compact('category'));
    }

    // Update category
    public function updatecategory(Request $request, $c_id)
    {
        $request->validate([
            'c_name' => 'required|string|max:255',
        ]);

        // Fetch category first
        $category = Category::findOrFail($c_id);

        $category->update([
            'c_name' => $request->c_name,
        ]);

        return redirect()->route('admin.view-category')->with('success', 'Category updated successfully!');
    }  

    public function deletecategory($c_id)
    {
        $category = Category::findOrFail($c_id);
        $category->delete();

        return redirect()->route('admin.view-category')->with('message', 'Category deleted successfully!');
    }
}