@extends('admin.includes.main')
@push('title')
    <title>Admin Dashboard - Gifts Hub</title>
@endpush
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="my-4">Dashboard</h1>
                
                <div class="row">
                    <!-- Total Orders Card -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card bg-primary text-white shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                                            Total Orders</div>
                                        <div class="h5 mb-0 font-weight-bold">{{ number_format($totalOrders) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-shopping-cart fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Sales Card -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card bg-success text-white shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                                            Total Sales</div>
                                        <div class="h5 mb-0 font-weight-bold">Rs. {{ number_format($totalSales, 2) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Users Card -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card bg-info text-white shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                                            Total Users</div>
                                        <div class="h5 mb-0 font-weight-bold">{{ number_format($totalUsers) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Processing Orders Card -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card bg-warning text-white shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                                            Processing</div>
                                        <div class="h5 mb-0 font-weight-bold">{{ number_format($processingOrders) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-xl-8 col-md-12">  
                        <div class="d-flex mb-3">
                            <h4>Recent Orders</h4>
                            <div class="ms-auto">
                                <a href="{{ route('sales.report') }}" 
                                   class="text-decoration-none btn btn-dark btn-sm">View All</a>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <table id="datatablesSimple" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Order ID</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentOrders as $order)
                                    <tr>
                                        <th scope="row">{{ $order->order_id }}</th>
                                        <td>{{ $order->user->name ?? 'Guest' }}</td>
                                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                        <td>Rs. {{ number_format($order->total, 2) }}</td>
                                        <td>
                                            {!! $order->status_badge !!}
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/details') }}" 
                                               class="text-decoration-none btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <i class="fas fa-shopping-bag fa-2x mb-2"></i>
                                            <p>No orders yet.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Order Status Summary -->
                    <div class="col-xl-4 col-md-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Order Status Overview</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span><i class="fas fa-box text-secondary me-2"></i> Processing</span>
                                    <span class="badge bg-secondary">{{ $processingOrders }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span><i class="fas fa-truck text-success me-2"></i> Shipped</span>
                                    <span class="badge bg-success">{{ $shippedOrders }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span><i class="fas fa-check-circle text-primary me-2"></i> Delivered</span>
                                    <span class="badge bg-primary">{{ $deliveredOrders }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-shopping-cart text-info me-2"></i> Total Orders</span>
                                    <span class="badge bg-info">{{ $totalOrders }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Links -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Quick Links</h5>
                            </div>
                            <div class="card-body">
                                <a href="{{ route('admin.view-product') }}" class="btn btn-outline-primary w-100 mb-2">
                                    <i class="fas fa-box me-2"></i> Manage Products
                                </a>
                                <a href="{{ route('admin.view-category') }}" class="btn btn-outline-success w-100 mb-2">
                                    <i class="fas fa-list me-2"></i> Manage Categories
                                </a>
                                <a href="{{ route('inventory.index') }}" class="btn btn-outline-info w-100 mb-2">
                                    <i class="fas fa-warehouse me-2"></i> Manage Inventory
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-warning w-100 mb-2">
                                    <i class="fas fa-users me-2"></i> Manage Users
                                </a>
                                <a href="{{ route('sales.report') }}" class="btn btn-outline-danger w-100">
                                    <i class="fas fa-chart-line me-2"></i> Sales Report
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection
