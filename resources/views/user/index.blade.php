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
                <div class="row g-3 mb-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="card stat-card total-orders dashboard-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-uppercase text-primary small fw-bold mb-1">Total Orders</div>
                                        <div class="h3 mb-0 fw-bold">{{ $orderStats['total_orders'] }}</div>
                                    </div>
                                    <div class="text-primary">
                                        <i class="fas fa-shopping-bag fa-2x opacity-25"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="card stat-card processing dashboard-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-uppercase text-secondary small fw-bold mb-1">Processing</div>
                                        <div class="h3 mb-0 fw-bold">{{ $orderStats['processing_orders'] }}</div>
                                    </div>
                                    <div class="text-secondary">
                                        <i class="fas fa-clock fa-2x opacity-25"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="card stat-card completed dashboard-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-uppercase text-success small fw-bold mb-1">Completed</div>
                                        <div class="h3 mb-0 fw-bold">{{ $orderStats['completed_orders'] }}</div>
                                    </div>
                                    <div class="text-success">
                                        <i class="fas fa-check-circle fa-2x opacity-25"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="card stat-card spent dashboard-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-uppercase text-warning small fw-bold mb-1">Total Spent</div>
                                        <div class="h3 mb-0 fw-bold">Rs. {{ number_format($orderStats['total_spent'], 2) }}</div>
                                    </div>
                                    <div class="text-warning">
                                        <i class="fas fa-dollar-sign fa-2x opacity-25"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <!-- Recent Orders -->
                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="card dashboard-card">
                            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                                <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Recent Orders</h5>
                                <a href="{{ route('user.order.history') }}" 
                                   class="btn btn-sm btn-outline-primary">View All Orders</a>
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
                                                        <span class="fw-bold text-primary">#{{ $order->order_id }}</span>
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
                    
                    <div class="col-lg-4">
                        <div class="card dashboard-card h-100">
                            <div class="card-header bg-white">
                                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Account Overview</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="card bg-light h-100">
                                            <div class="card-body text-center p-3">
                                                <i class="fas fa-lock fa-2x text-primary mb-2"></i>
                                                <h5 class="fw-bold mb-0">2</h5>
                                                <small class="text-muted">Security</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card bg-light h-100">
                                            <div class="card-body text-center p-3">
                                                <i class="fas fa-heart fa-2x text-danger mb-2"></i>
                                                <h5 class="fw-bold mb-0">{{ $wishlistCount ?? 0 }}</h5>
                                                <small class="text-muted">Wishlist</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card bg-light h-100">
                                            <div class="card-body text-center p-3">
                                                <i class="fas fa-dollar-sign fa-2x text-success mb-2"></i>
                                                <h5 class="fw-bold mb-0">Rs. {{ number_format($orderStats['total_spent'], 0) }}</h5>
                                                <small class="text-muted">Spent</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card bg-light h-100">
                                            <div class="card-body text-center p-3">
                                                <i class="fas fa-calendar fa-2x text-info mb-2"></i>
                                                <h5 class="fw-bold mb-0">{{ $user->created_at->diffForHumans() }}</h5>
                                                <small class="text-muted">Member</small>
                                            </div>
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