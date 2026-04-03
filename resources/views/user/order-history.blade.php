@extends('user.layouts.main')

@push('title')
    <title>Order History - Gifts Hub</title>
@endpush

@push('styles')
<style>
.table-container {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
}

.modern-table {
    margin: 0;
}

.modern-table thead th {
    background: #f8f9fa;
    border: none;
    padding: 12px 16px;
    font-weight: 600;
    color: #495057;
    border-bottom: 2px solid #dee2e6;
}

.modern-table tbody td {
    padding: 12px 16px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f3f4;
}

.modern-table tbody tr:hover {
    background-color: #f8f9fa;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-state i {
    font-size: 4rem;
    color: #6c757d;
    margin-bottom: 1rem;
}

.empty-state h5 {
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #adb5bd;
    margin-bottom: 1.5rem;
}

.badge-status {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
    border-radius: 50px;
}

.action-btn {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.action-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
</style>
@endpush

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 mt-4">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold mb-1">Order History</h2>
                        <p class="text-muted mb-0">View and track all your orders</p>
                    </div>
                    <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                    </a>
                </div>

                <!-- Recent Orders Section -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold mb-0">Recent Orders</h4>
                            <button class="btn btn-outline-primary btn-sm">
                                View All Orders
                            </button>
                        </div>
                        
                        @if($orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table modern-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                            <th>Items</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $index => $order)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <span class="fw-bold">#{{ $order->order_id }}</span>
                                            </td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    {{ is_array($order->items) ? count($order->items) : 0 }} product(s)
                                                </span>
                                            </td>
                                            <td class="fw-bold text-success">Rs. {{ number_format($order->total, 2) }}</td>
                                            <td>{!! $order->status_badge !!}</td>
                                            <td>
                                                <a href="{{ route('user.order.detail', $order->order_id) }}" 
                                                   class="btn btn-sm btn-primary action-btn">
                                                    <i class="fas fa-eye me-1"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="fas fa-shopping-bag fa-4x text-muted"></i>
                                </div>
                                <h5 class="text-muted mb-3">No orders yet</h5>
                                <p class="text-muted mb-4">You haven't placed any orders yet. Start shopping to see your order history here.</p>
                                <a href="{{ route('products') }}" class="btn btn-primary">
                                    <i class="fas fa-shopping-cart me-2"></i>Start Shopping
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>
        </main>
@endsection