<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin/login');
    }
    
    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Check if user is admin (you may want to modify this based on your user table structure)
            if (Auth::user()->role === 'admin' || Auth::user()->is_admin === 1) {
                return redirect()->intended('admin')->with('success', 'Welcome back, Admin!');
            }
            
            return redirect()->intended('admin')->with('success', 'Login successful!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login')->with('success', 'You have been logged out successfully.');
    }
    public function forget()
    {
        return view('admin/forget');
    }
    
    public function forgetPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if ($user && $user->role === 'admin') {
            // Use the user-provided password
            $user->password = Hash::make($request->password);
            $user->save();
            
            return redirect()->route('admin.login')->with('success', 'Your password has been successfully reset. You can now log in with your new password.');
        } elseif ($user) {
            return back()->with('error', 'This email is not registered as an admin account.');
        }
        
        return back()->with('error', 'Email not found in our system.');
    }
    public function index()
    {
        // Dashboard statistics
        $totalOrders = Order::count();
        $totalSales = Order::sum('total');
        $totalUsers = User::count();
        
        // Recent orders
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Order status counts
        $processingOrders = Order::where('status', 'processing')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        
        return view('admin.index', compact(
            'totalOrders', 
            'totalSales', 
            'totalUsers', 
            'recentOrders',
            'processingOrders',
            'shippedOrders',
            'deliveredOrders'
        ));
    }

    public function inventory(Request $request)
    {
        $query = Inventory::with('product.category');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('product', function($subQuery) use ($search) {
                    $subQuery->where('p_name', 'like', "%{$search}%");
                })->orWhere('product_id', 'like', "%{$search}%")
                  ->orWhereHas('product.category', function($subQuery) use ($search) {
                      $subQuery->where('c_name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->whereHas('product.category', function($q) use ($request) {
                $q->where('c_name', $request->category);
            });
        }

        // Filter by location
        if ($request->has('location') && !empty($request->location)) {
            $query->where('location', $request->location);
        }

        $inventories = $query->orderBy('created_at', 'desc')
                            ->paginate($request->get('per_page', 10))
                            ->withQueryString();

        // Get unique categories and locations for filters
        $categories = Category::orderBy('c_name')->pluck('c_name');
        $locations = Inventory::distinct()->pluck('location');

        return view('admin.inventory', compact('inventories', 'categories', 'locations'));
    }

    public function inventoryCreate()
    {
        $products = Product::with('category')->get();
        $locations = ['Warehouse 1', 'Warehouse 2', 'Warehouse 3', 'Warehouse 4', 'Warehouse 5'];
        return view('admin.add-inventory', compact('products', 'locations'));
    }

    public function inventoryStore(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,p_id|unique:inventories,product_id',
            'location' => 'required|string|max:100',
            'available' => 'required|integer|min:0',
            'reserved' => 'required|integer|min:0',
            'on_hand' => 'required|integer|min:0',
            'unit_cost' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        Inventory::create([
            'product_id' => $request->product_id,
            'location' => $request->location,
            'available_quantity' => $request->available,
            'reserved_quantity' => $request->reserved,
            'on_hand_quantity' => $request->on_hand,
            'unit_cost' => $request->unit_cost ?? 0,
            'description' => $request->description,
        ]);

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory Added Successfully');
    }

    public function inventoryEdit($id)
    {
        $inventory = Inventory::with('product.category')->findOrFail($id);
        $products = Product::with('category')->get();
        $locations = ['Warehouse 1', 'Warehouse 2', 'Warehouse 3', 'Warehouse 4', 'Warehouse 5'];
        return view('admin.edit-inventory', compact('inventory', 'products', 'locations'));
    }

    public function inventoryUpdate(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $request->validate([
            'product_id' => 'required|exists:products,p_id|unique:inventories,product_id,' . $id,
            'location' => 'required|string|max:100',
            'available' => 'required|integer|min:0',
            'reserved' => 'required|integer|min:0',
            'on_hand' => 'required|integer|min:0',
            'unit_cost' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $inventory->update([
            'product_id' => $request->product_id,
            'location' => $request->location,
            'available_quantity' => $request->available,
            'reserved_quantity' => $request->reserved,
            'on_hand_quantity' => $request->on_hand,
            'unit_cost' => $request->unit_cost ?? 0,
            'description' => $request->description,
        ]);

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory Updated Successfully');
    }

    public function inventoryDestroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory Deleted Successfully');
    }

    public function inventoryShow($id)
    {
        $inventory = Inventory::with('product.category')->findOrFail($id);
        return view('admin.view-inventory', compact('inventory'));
    }


        public function salesReport(Request $request)
    {
        $query = Order::query();

        // Date filtering
        if ($request->has('from_date') && !empty($request->from_date)) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->has('to_date') && !empty($request->to_date)) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $sales = $query->with('user')
                      ->orderBy('created_at', 'desc')
                      ->paginate(15)
                      ->withQueryString();

        $totalSales = $query->sum('total');
        $totalOrders = $query->count();
        $averageOrder = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

        return view('admin.sales-report', compact('sales', 'totalSales', 'totalOrders', 'averageOrder'));
    }

    public function salesReportFilter(Request $request)
    {
        return redirect()->route('sales.report', $request->only('from_date', 'to_date'));
    }

    public function purchaseReport(Request $request)
    {
        $query = Purchase::query();

        // Date filtering
        if ($request->has('from_date') && !empty($request->from_date)) {
            $query->whereDate('purchase_date', '>=', $request->from_date);
        }
        if ($request->has('to_date') && !empty($request->to_date)) {
            $query->whereDate('purchase_date', '<=', $request->to_date);
        }

        $purchases = $query->with('inventory')
                          ->orderBy('purchase_date', 'desc')
                          ->paginate(15)
                          ->withQueryString();

        $totalPurchase = $query->sum('total_amount');
        $totalOrders = $query->count();
        $averagePurchase = $totalOrders > 0 ? $totalPurchase / $totalOrders : 0;

        return view('admin.purchase-report', compact('purchases', 'totalPurchase', 'totalOrders', 'averagePurchase'));
    }

    public function purchaseReportFilter(Request $request)
    {
        return redirect()->route('purchase.report', $request->only('from_date', 'to_date'));
    }
    

    public function details()
    {
        return view('admin/details');
    }

     public function user()
    {
        return view('admin/user');
    }   
     
}
