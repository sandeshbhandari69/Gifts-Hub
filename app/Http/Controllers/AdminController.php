<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Purchase;
use App\Models\User;

class AdminController extends Controller
{
    public function signup()
    {
        return view('admin/signup');
    }
    public function login()
    {
        return view('admin/login');
    }
    public function forget()
    {
        return view('admin/forget');
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
        $query = Inventory::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                  ->orWhere('product_id', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        // Filter by location
        if ($request->has('location') && !empty($request->location)) {
            $query->where('location', $request->location);
        }

        $inventories = $query->orderBy('created_at', 'desc')
                            ->paginate($request->get('per_page', 10))
                            ->withQueryString();

        // Get unique categories and locations for filters
        $categories = Inventory::distinct()->pluck('category');
        $locations = Inventory::distinct()->pluck('location');

        return view('admin.inventory', compact('inventories', 'categories', 'locations'));
    }

    public function inventoryCreate()
    {
        $categories = ['Gadgets', 'Combo Gifts', 'Birthday Gifts', 'Personalized', 'Valentines', 'Anniversary Gifts', 'Flower', 'Christmas'];
        $locations = ['Warehouse 1', 'Warehouse 2', 'Warehouse 3', 'Warehouse 4', 'Warehouse 5'];
        return view('admin.add-inventory', compact('categories', 'locations'));
    }

    public function inventoryStore(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_id' => 'required|string|unique:inventories,product_id|max:50',
            'category' => 'required|string|max:100',
            'location' => 'required|string|max:100',
            'available' => 'required|integer|min:0',
            'reserved' => 'required|integer|min:0',
            'on_hand' => 'required|integer|min:0',
            'unit_cost' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        Inventory::create([
            'product_name' => $request->product_name,
            'product_id' => $request->product_id,
            'category' => $request->category,
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
        $inventory = Inventory::findOrFail($id);
        $categories = ['Gadgets', 'Combo Gifts', 'Birthday Gifts', 'Personalized', 'Valentines', 'Anniversary Gifts', 'Flower', 'Christmas'];
        $locations = ['Warehouse 1', 'Warehouse 2', 'Warehouse 3', 'Warehouse 4', 'Warehouse 5'];
        return view('admin.edit-inventory', compact('inventory', 'categories', 'locations'));
    }

    public function inventoryUpdate(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_id' => 'required|string|max:50|unique:inventories,product_id,' . $id,
            'category' => 'required|string|max:100',
            'location' => 'required|string|max:100',
            'available' => 'required|integer|min:0',
            'reserved' => 'required|integer|min:0',
            'on_hand' => 'required|integer|min:0',
            'unit_cost' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $inventory->update([
            'product_name' => $request->product_name,
            'product_id' => $request->product_id,
            'category' => $request->category,
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
        $inventory = Inventory::findOrFail($id);
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
