@extends('admin.includes.main')

@section('title')
    <title>Order Details - Admin</title>
@endsection

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <div class="d-flex justify-content-between align-items-center my-4">
                    <h1 class="mb-0">Order Details</h1>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Back to Orders
                    </a>
                </div>

                <!-- Order Info Cards -->
                <div class="row mb-4">
                    <div class="col-xl-6 col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Order Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <strong>Order ID:</strong>
                                    </div>
                                    <div class="col-6">
                                        #{{ $order->order_id }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <strong>Date:</strong>
                                    </div>
                                    <div class="col-6">
                                        {{ $order->created_at->format('M d, Y H:i') }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <strong>Payment Method:</strong>
                                    </div>
                                    <div class="col-6">
                                        <span class="badge bg-light text-dark">
                                            {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <strong>Status:</strong>
                                    </div>
                                    <div class="col-6">
                                        {!! $order->status_badge !!}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <strong>Total Amount:</strong>
                                    </div>
                                    <div class="col-6">
                                        <span class="fw-bold text-success">Rs. {{ number_format($order->total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-6 col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Customer Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <strong>Name:</strong>
                                    </div>
                                    <div class="col-6">
                                        {{ $order->user->name ?? 'N/A' }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <strong>Email:</strong>
                                    </div>
                                    <div class="col-6">
                                        {{ $order->user->email ?? 'N/A' }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <strong>Phone:</strong>
                                    </div>
                                    <div class="col-6">
                                        {{ $order->user->phone ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Order Items</h5>
                            </div>
                            <div class="card-body">
                                @if(isset($order->items) && count($order->items) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->items as $item)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if(!empty($item['image']))
                                                                <img src="{{ asset('assets/images/Product/1.png') }}" 
                                                                     class="img-fluid rounded me-3" 
                                                                     style="width: 50px;" 
                                                                     alt="{{ $item['name'] }}">
                                                            @else
                                                                <img src="{{ asset($item['image']) }}" 
                                                                     class="img-fluid rounded me-3" 
                                                                     style="width: 50px;" 
                                                                     alt="{{ $item['name'] }}"
                                                                     onerror="this.src='{{ asset('assets/images/Product/1.png') }}'">
                                                            @endif
                                                            <div>
                                                                <strong>{{ $item['name'] }}</strong>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Rs. {{ number_format($item['price'], 2) }}</td>
                                                    <td>{{ $item['quantity'] }}</td>
                                                    <td>Rs. {{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-box fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted mb-3">No items found</h5>
                                        <p class="text-muted">This order doesn't contain any items.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Update Status Form -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-warning text-white">
                                <h5 class="mb-0">Update Order Status</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="status" class="form-label">Order Status</label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                                <option value="on_the_way" {{ $order->status == 'on_the_way' ? 'selected' : '' }}>On the way</option>
                                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">&nbsp;</label>
                                            <button type="submit" class="btn btn-warning w-100">
                                                <i class="fas fa-save me-2"></i> Update Status
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection
