@extends('user.layouts.main')
@push('title')
    <title>User Dashboard - Gifts Hub</title>
@endpush
@push('styles')
<style>
.dashboard-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}
.dashboard-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.stat-card {
    border-left: 4px solid;
}
.stat-card.total-orders { border-left-color: #007bff; }
.stat-card.processing { border-left-color: #6c757d; }
.stat-card.completed { border-left-color: #28a745; }
.stat-card.spent { border-left-color: #ffc107; }
.quick-action-btn {
    transition: all 0.2s ease-in-out;
}
.quick-action-btn:hover {
    transform: translateY(-2px);
}
</style>
@endpush
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <div class="d-flex justify-content-between align-items-center my-4">
                    <h1 class="mb-0">Dashboard</h1>
                    <div>
                        <span class="badge bg-success">Welcome back, {{ $user->name }}!</span>
                    </div>
                </div>
                
                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card total-orders dashboard-card h-100">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-uppercase text-primary small fw-bold">Total Orders</div>
                                        <div class="h4 mb-0 fw-bold">{{ $orderStats['total_orders'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-shopping-bag fa-2x text-primary opacity-25"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card processing dashboard-card h-100">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-uppercase text-secondary small fw-bold">Processing</div>
                                        <div class="h4 mb-0 fw-bold">{{ $orderStats['processing_orders'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clock fa-2x text-secondary opacity-25"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card completed dashboard-card h-100">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-uppercase text-success small fw-bold">Completed</div>
                                        <div class="h4 mb-0 fw-bold">{{ $orderStats['completed_orders'] }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-check-circle fa-2x text-success opacity-25"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card spent dashboard-card h-100">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-uppercase text-warning small fw-bold">Total Spent</div>
                                        <div class="h4 mb-0 fw-bold">Rs. {{ number_format($orderStats['total_spent'], 2) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-warning opacity-25"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions & User Info -->
                <div class="row mb-4">
                    <!-- Quick Actions -->
                    <div class="col-xl-6 col-md-6 mb-4">
                        <div class="card dashboard-card h-100">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <a href="{{ route('products') }}" class="btn btn-outline-primary quick-action-btn w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                            <i class="fas fa-store fa-2x mb-2"></i>
                                            <span>Browse Products</span>
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('user.order.history') }}" class="btn btn-outline-info quick-action-btn w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                            <i class="fas fa-history fa-2x mb-2"></i>
                                            <span>Order History</span>
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('user.wishlist') }}" class="btn btn-outline-danger quick-action-btn w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                            <i class="fas fa-heart fa-2x mb-2"></i>
                                            <span>My Wishlist</span>
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('user.settings') }}" class="btn btn-outline-secondary quick-action-btn w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                            <i class="fas fa-cog fa-2x mb-2"></i>
                                            <span>Settings</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Profile Card -->
                    <div class="col-xl-6 col-md-6 mb-4">
                        <div class="card dashboard-card h-100">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Profile Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <img src="{{ asset('dashboard/assets/img/user.png') }}" 
                                             class="rounded-circle img-fluid mb-3" 
                                             style="width: 120px;"
                                             alt="User Profile">
                                        <h6 class="fw-bold">{{ $user->name }}</h6>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="fw-bold mb-3">Contact Information</h6>
                                        <div class="mb-2">
                                            <i class="fas fa-envelope me-2 text-muted"></i>
                                            <span>{{ $user->email }}</span>
                                        </div>
                                        <div class="mb-2">
                                            <i class="fas fa-phone me-2 text-muted"></i>
                                            <span>{{ $user->phone ?? 'Not provided' }}</span>
                                        </div>
                                        <div class="mb-2">
                                            <i class="fas fa-calendar me-2 text-muted"></i>
                                            <span>Member since {{ $user->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <div class="mt-3">
                                            <a href="{{ route('user.settings') }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit me-1"></i> Edit Profile
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Orders -->
                <div class="row">
                    <div class="col-xl-8 mb-4">  
                        <div class="card dashboard-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Recent Orders</h5>
                                <div>
                                    <a href="{{ route('user.order.history') }}" 
                                       class="btn btn-sm btn-outline-primary">View All Orders</a>
                                </div>
                            </div>
                            <div class="card-body">
                                @if($recentOrders->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Date</th>
                                                    <th>Total</th>
                                                    <th>Payment</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($recentOrders as $order)
                                                <tr>
                                                    <td>
                                                        <span class="fw-bold">#{{ $order->order_id }}</span>
                                                    </td>
                                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                    <td class="fw-bold text-success">Rs. {{ number_format($order->total, 2) }}</td>
                                                    <td>
                                                        <span class="badge bg-light text-dark">
                                                            {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                                                        </span>
                                                    </td>
                                                    <td>{!! $order->status_badge !!}</td>
                                                    <td>
                                                        <a href="{{ route('user.order.detail', $order->order_id) }}" 
                                                           class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye me-1"></i> View
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                                        <h5>No orders yet</h5>
                                        <p class="text-muted">You haven't placed any orders yet. Start shopping to see your order history here.</p>
                                        <a href="{{ route('products') }}" class="btn btn-primary">
                                            <i class="fas fa-shopping-cart me-2"></i>Start Shopping
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Activity -->
                    <div class="col-xl-4 mb-4">
                        <div class="card dashboard-card h-100">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Recent Activity</h5>
                            </div>
                            <div class="card-body">
                                @if(isset($recentActivity) && $recentActivity->count() > 0)
                                    <div class="activity-feed">
                                        @foreach($recentActivity as $activity)
                                        <div class="activity-item d-flex align-items-start mb-3">
                                            <div class="activity-icon me-3">
                                                <i class="fas {{ $activity['icon'] }} {{ $activity['color'] }} fa-lg"></i>
                                            </div>
                                            <div class="activity-details flex-grow-1">
                                                <div class="fw-bold small">{{ $activity['description'] }}</div>
                                                <div class="text-muted small">{{ $activity['date'] }}</div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="mt-3 pt-3 border-top">
                                        <a href="{{ route('user.order.history') }}" class="btn btn-sm btn-outline-success w-100">
                                            <i class="fas fa-history me-1"></i> View All Activity
                                        </a>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-history fa-2x text-muted mb-3"></i>
                                        <h6 class="text-muted">No recent activity</h6>
                                        <p class="text-muted small">Your activity will appear here as you use the platform.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Stats Row -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card dashboard-card">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Account Overview</h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-3 mb-3">
                                        <div class="p-3 bg-light rounded">
                                            <i class="fas fa-shopping-bag fa-2x text-primary mb-2"></i>
                                            <h4 class="fw-bold">{{ $orderStats['total_orders'] }}</h4>
                                            <p class="text-muted mb-0">Total Orders</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="p-3 bg-light rounded">
                                            <i class="fas fa-heart fa-2x text-danger mb-2"></i>
                                            <h4 class="fw-bold">{{ $wishlistCount ?? 0 }}</h4>
                                            <p class="text-muted mb-0">Wishlist Items</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="p-3 bg-light rounded">
                                            <i class="fas fa-dollar-sign fa-2x text-success mb-2"></i>
                                            <h4 class="fw-bold">Rs. {{ number_format($orderStats['total_spent'], 0) }}</h4>
                                            <p class="text-muted mb-0">Total Spent</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="p-3 bg-light rounded">
                                            <i class="fas fa-calendar fa-2x text-info mb-2"></i>
                                            <h4 class="fw-bold">{{ $user->created_at->diffForHumans() }}</h4>
                                            <p class="text-muted mb-0">Member Since</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection