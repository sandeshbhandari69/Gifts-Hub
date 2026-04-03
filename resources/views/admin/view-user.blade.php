@extends('admin.includes.main')

@push('title')
    <title>User Details - {{ $user->name }}</title>
@endpush

@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4 mt-4">
            <div class="row">
                <!-- User Profile Card -->
                <div class="col-xl-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">User Profile</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" 
                                     style="width: 100px; height: 100px; font-size: 40px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            </div>
                            <h5>{{ $user->name }}</h5>
                            <p class="text-muted">{{ $user->email }}</p>
                            <span class="badge {{ $user->is_blocked ? 'bg-danger' : 'bg-success' }} mb-3">
                                {{ $user->is_blocked ? 'Blocked' : 'Active' }}
                            </span>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                @if($user->is_blocked)
                                    <form action="{{ route('admin.users.unblock', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Unblock this user?')">
                                            <i class="fas fa-unlock"></i> Unblock
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.users.block', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Block this user?')">
                                            <i class="fas fa-ban"></i> Block
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Details -->
                <div class="col-xl-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">User Information</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">User ID:</th>
                                    <td>{{ $user->id }}</td>
                                </tr>
                                <tr>
                                    <th>Full Name:</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $user->phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Address:</th>
                                    <td>{{ $user->address ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @if($user->is_blocked)
                                            <span class="badge bg-danger">Blocked</span>
                                        @else
                                            <span class="badge bg-success">Active</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Registered On:</th>
                                    <td>{{ $user->created_at->format('F d, Y H:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated:</th>
                                    <td>{{ $user->updated_at->format('F d, Y H:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order History -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Order History</h5>
                    <span class="badge bg-primary">{{ $user->orders->count() }} Orders</span>
                </div>
                <div class="card-body">
                    @if($user->orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->orders as $order)
                                    <tr>
                                        <td>#{{ $order->order_id ?? $order->id }}</td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>Rs. {{ number_format($order->total, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'processing' ? 'warning' : 'info') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-info" title="View Order">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-shopping-bag fa-2x mb-2"></i>
                            <p>No orders found for this user.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mb-4">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Users
                </a>
                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                        <i class="fas fa-trash"></i> Delete User
                    </button>
                </form>
            </div>
        </div>
    </main>
@endsection
