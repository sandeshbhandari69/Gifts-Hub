@extends('admin.includes.main')
@push('title')
    <title>Inventory Management</title>
@endpush

@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4 mt-4">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="mt-2 mb-4">Inventory Management</h4>

                    {{-- Search + Filter + action buttons --}}
                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                        <form action="{{ route('inventory.index') }}" method="GET" class="d-flex flex-wrap gap-2">
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                                <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
                            </div>
                            <select name="category" class="form-select w-auto">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                            <select name="location" class="form-select w-auto">
                                <option value="">All Locations</option>
                                @foreach($locations as $loc)
                                    <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">Filter</button>
                            @if(request('search') || request('category') || request('location'))
                                <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Clear</a>
                            @endif
                        </form>
                        <div class="d-flex gap-2 mt-2 mt-md-0">
                            <a href="{{ route('inventory.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Inventory
                            </a>
                        </div>
                    </div>

                    {{-- "Show" entries dropdown --}}
                    <form action="{{ route('inventory.index') }}" method="GET" class="d-flex align-items-center gap-2 mb-3">
                        @foreach(request()->except('per_page', 'page') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <label class="text-muted">Show</label>
                        <select name="per_page" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                        <span class="text-muted">entries</span>
                    </form>

                    {{-- Inventory table --}}
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Product</th>
                                    <th>Product ID</th>
                                    <th>Category</th>
                                    <th>Location</th>
                                    <th>Available</th>
                                    <th>Reserved</th>
                                    <th>On Hand</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($inventories as $index => $item)
                                <tr>
                                    <td>{{ $inventories->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $item->product_name }}</strong><br>
                                        <small class="text-muted">{{ Str::limit($item->description, 30) }}</small>
                                    </td>
                                    <td>#{{ $item->product_id }}</td>
                                    <td>{{ $item->category }}</td>
                                    <td>{{ $item->location }}</td>
                                    <td>{{ number_format($item->available_quantity) }}</td>
                                    <td>{{ number_format($item->reserved_quantity) }}</td>
                                    <td>{{ number_format($item->on_hand_quantity) }}</td>
                                    <td>{!! $item->stock_status_badge !!}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('inventory.show', $item->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('inventory.edit', $item->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('inventory.delete', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this inventory item?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-boxes fa-2x mb-2"></i>
                                            <p>No inventory items found.</p>
                                            <a href="{{ route('inventory.create') }}" class="btn btn-sm btn-primary">Add First Item</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination info and controls --}}
                    <div class="d-flex flex-wrap align-items-center justify-content-between mt-3">
                        <div class="text-muted small">
                            Showing {{ $inventories->firstItem() ?? 0 }} to {{ $inventories->lastItem() ?? 0 }} of {{ $inventories->total() }} entries
                        </div>
                        <nav>
                            {{ $inventories->links('pagination::bootstrap-4') }}
                        </nav>
                    </div>

                </div> 
            </div> 
        </div> 
    </main>
@endsection