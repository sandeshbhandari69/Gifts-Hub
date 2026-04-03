@extends('admin.includes.main')

@push('title')
    <title>View Products</title>
@endpush

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 mt-4">
                <div class="card p-4">
                    <div>
                        <div class="row">
                        <div class="col-xl-12 col-md-12">

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4>View Products</h4>
                                <a href="{{ route('admin.add-product') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Product
                                </a>
                            </div>

                            <div class="mt-3">
                                <table id="datatablesSimple" class="table table-hover">
                                        <thead>
                                            <tr>
                                            <th scope="col"><h5>Product</h5></th>
                                            <th scope="col"><h5>Price</h5></th>
                                            <th scope="col"><h5>Category</h5></th>
                                            <th scope="col"><h5>Stock</h5></th>
                                            <th scope="col"><h5>Description</h5></th>
                                            <th scope="col"><h5>Action</h5></th>
                                            </tr>
                                        </thead>
                                    <tbody>

                                        @if ($products->count() > 0)
                                            @foreach ($products as $product)
                                                <tr>
                                                    <th>
                                                        <div class="d-flex">
                                                            <div>
                                                                @if($product->p_image && !empty($product->p_image))
                                                                    <img src="{{ asset('storage/'.$product->p_image) }}" class="img-fluid rounded" style="width: 70px; height: 70px; object-fit: cover;" alt="{{ $product->p_name }}" onerror="this.src='{{ asset('assets/images/product/1.png') }}';">
                                                                @else
                                                                    <img src="{{ asset('assets/images/product/1.png') }}" class="img-fluid rounded" style="width: 70px; height: 70px; object-fit: cover;" alt="{{ $product->p_name }}">
                                                                @endif
                                                                </div>
                                                                <div class="p-3"><h6>{{ $product->p_name }}</h6></div>
                                                            </div>
                                                    </th>
                                                    <td>Rs. {{ number_format($product->p_price, 2) }}</td>
                                                    <td>{{ $product->category->c_name ?? 'N/A' }}</td>
                                                    <td>{{ $product->p_stock }}</td>
                                                    <td>{{ Str::limit($product->p_description, 50) }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.edit-product', $product->p_id) }}" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <form action="{{ route('admin.delete-product', $product->p_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">
                                                    <i class="fas fa-box fa-2x mb-2"></i>
                                                    <p>No products found.</p>
                                                    <a href="{{ route('admin.add-product') }}" class="btn btn-sm btn-primary">Add First Product</a>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection