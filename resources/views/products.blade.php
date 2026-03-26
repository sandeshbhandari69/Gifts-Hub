@extends('layouts.main')
@push('title')
    <title>All Products - Gifts Hub</title>
@endpush
@push('styles')
<style>
.product-img {
    height: 200px;
    object-fit: cover;
}
</style>
@endpush
@section('content')
<div class="container-fluid bg-white py-5 shadow-sm mb-5">
    <div class="container">
        <span class="badge-purple">Products</span>
        <h1 class="section-title mt-2 mb-0">
            <i class="fa-solid fa-box me-2"></i>
            All Products
        </h1>
        <p class="text-muted mt-2">{{ $products->count() }} products available</p>
    </div>
</div>

<!-- Products List -->
<section class="my-5">
    <div class="container">
        <div class="row theme-product">
            @forelse($products as $product)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100">
                    <a href="{{ route('product.detail', ['slug' => Str::slug($product->p_name)]) }}">
                        @if($product->p_image && !empty($product->p_image))
                            <img src="{{ asset('storage/'.$product->p_image) }}" class="card-img-top product-img" alt="{{ $product->p_name }}" onerror="this.src='{{ asset('assets/images/product/1.png') }}';">
                        @else
                            <img src="{{ asset('assets/images/product/1.png') }}" class="card-img-top product-img" alt="{{ $product->p_name }}">
                        @endif
                    </a>
                    <div class="card-body">
                        <h6 class="card-title text-center">
                            <a href="{{ route('product.detail', ['slug' => Str::slug($product->p_name)]) }}" class="text-dark text-decoration-none">
                                {{ $product->p_name }}
                            </a>
                        </h6>
                        <h5 class="card-title text-center">Rs. {{ number_format($product->p_price, 2) }}</h5>
                        <p class="text-muted small text-center">{{ $product->category->c_name ?? 'Uncategorized' }}</p>
                        <div class="d-flex gap-2 mt-2">
                            <form action="{{ route('cart.add') }}" method="POST" class="flex-fill">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->p_id }}">
                                <input type="hidden" name="name" value="{{ $product->p_name }}">
                                <input type="hidden" name="price" value="{{ $product->p_price }}">
                                <input type="hidden" name="image" value="{{ $product->p_image ? asset('storage/'.$product->p_image) : asset('assets/images/product/1.png') }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary btn-xs rounded-pill w-100">
                                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                </button>
                            </form>
                            <form action="{{ route('wishlist.store') }}" method="POST" class="flex-fill">
                                @csrf
                                <input type="hidden" name="product_name" value="{{ $product->p_name }}">
                                <input type="hidden" name="product_price" value="{{ $product->p_price }}">
                                <input type="hidden" name="product_image" value="{{ $product->p_image ? asset('storage/'.$product->p_image) : asset('assets/images/product/1.png') }}">
                                <button type="submit" class="btn btn-outline-danger btn-xs rounded-pill w-100">
                                    <i class="fa-regular fa-heart"></i> Wishlist
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-box fa-3x text-muted mb-3"></i>
                <p class="text-muted">No products available yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
