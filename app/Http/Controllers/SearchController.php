<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class SearchController extends Controller
{
    public function autocomplete(Request $request)
    {
        $query = $request->get('query');
        
        if (empty($query)) {
            return response()->json([]);
        }
        
        $products = Product::where('p_name', 'LIKE', $query . '%')
            ->select('p_name as name', 'p_id as id')
            ->limit(10)
            ->get();
        
        return response()->json($products);
    }
    
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return redirect()->route('home');
        }
        
        $products = Product::where('p_name', 'LIKE', '%' . $query . '%')
            ->orWhere('p_description', 'LIKE', '%' . $query . '%')
            ->with('category')
            ->paginate(12);
        
        return view('search-results', compact('products', 'query'));
    }
}
