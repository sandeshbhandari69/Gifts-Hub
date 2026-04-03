@extends('admin.includes.main')

@push('title')
    <title>View Inventory - {{ $inventory->product_name }}</title>
@endpush

@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4 mt-4">
            <div class="row">
                <!-- Inventory Details -->
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Inventory Details</h5>
                            <span class="badge {{ $inventory->stock_status == 'in_stock' ? 'bg-success' : ($inventory->stock_status == 'low_stock' ? 'bg-warning' : 'bg-danger') }}">
                                {{ ucfirst(str_replace('_', ' ', $inventory->stock_status)) }}
                            </span>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Inventory ID:</th>
                                    <td>{{ $inventory->id }}</td>
                                </tr>
                                <tr>
                                    <th>Product ID:</th>
                                    <td>#{{ $inventory->product_id }}</td>
                                </tr>
                                <tr>
                                    <th>Product Name:</th>
                                    <td>{{ $inventory->product_name }}</td>
                                </tr>
                                <tr>
                                    <th>Category:</th>
                                    <td>{{ $inventory->category }}</td>
                                </tr>
                                <tr>
                                    <th>Location:</th>
                                    <td>{{ $inventory->location }}</td>
                                </tr>
                                <tr>
                                    <th>Unit Cost:</th>
                                    <td>Rs. {{ number_format($inventory->unit_cost ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Created On:</th>
                                    <td>{{ $inventory->created_at->format('F d, Y H:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated:</th>
                                    <td>{{ $inventory->updated_at->format('F d, Y H:i A') }}</td>
                                </tr>
                                @if($inventory->description)
                                <tr>
                                    <th>Inventory Description:</th>
                                    <td>{{ $inventory->description }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Product Information -->
                @if($inventory->product)
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Product Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">Product Price:</th>
                                            <td>Rs. {{ number_format($inventory->product->p_price, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Product Stock:</th>
                                            <td>{{ $inventory->product->p_stock }}</td>
                                        </tr>
                                        <tr>
                                            <th>Category ID:</th>
                                            <td>{{ $inventory->product->c_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Product Description:</th>
                                            <td>{{ $inventory->product->p_description }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-4 text-center">
                                    @if($inventory->product->p_image)
                                        <img src="{{ asset('storage/' . $inventory->product->p_image) }}" alt="{{ $inventory->product_name }}" style="max-width: 120px; max-height: 120px; object-fit: cover;" class="rounded shadow-sm mb-2">
                                        <small class="text-muted d-block">Product Image</small>
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; margin: 0 auto;">
                                            <i class="fas fa-image text-muted fa-2x"></i>
                                        </div>
                                        <small class="text-muted d-block">No Image</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Stock Summary -->
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Stock Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="p-3 bg-light rounded text-center">
                                        <h6 class="text-muted mb-1">Available Quantity</h6>
                                        <h4 class="mb-0">{{ number_format($inventory->available_quantity) }}</h4>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 bg-light rounded text-center">
                                        <h6 class="text-muted mb-1">Reserved Quantity</h6>
                                        <h4 class="mb-0">{{ number_format($inventory->reserved_quantity) }}</h4>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 bg-light rounded text-center">
                                        <h6 class="text-muted mb-1">On Hand Quantity</h6>
                                        <h4 class="mb-0">{{ number_format($inventory->on_hand_quantity) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mb-4">
                <a href="{{ route('inventory.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Inventory
                </a>
                <a href="{{ route('inventory.edit', $inventory->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Inventory
                </a>
                <form action="{{ route('inventory.delete', $inventory->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this inventory item?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </main>
@endsection
