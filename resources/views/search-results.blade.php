@extends('layouts.main')
@push('title')
    <title>Search Results for "{{ $query }}"</title>
@endpush
@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=DM+Sans:wght@300;400;500;600&display=swap');
:root {
    --brand-primary:   #c4522a;
    --brand-secondary: #e8896a;
    --brand-gold:      #d4a853;
    --brand-dark:      #1c1917;
    --brand-surface:   #f8f6f3;
    --brand-card:      #ffffff;
    --text-primary:    #1a1714;
    --text-secondary:  #6b6560;
    --text-muted:      #a09890;
    --border-color:    #e8e2db;
    --radius-lg:       20px;
    --shadow-card:     0 2px 8px rgba(28,25,23,0.07), 0 0 0 1px rgba(28,25,23,0.06);
    --shadow-hover:    0 10px 32px rgba(28,25,23,0.13), 0 0 0 1px rgba(28,25,23,0.06);
    --font-display:    'Playfair Display', serif;
    --font-body:       'DM Sans', sans-serif;
    --transition:      all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
}

body { font-family: var(--font-body); background: var(--brand-surface); }

/* Product Card */
.product-card {
    background: var(--brand-card);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-card);
    overflow: hidden;
    transition: var(--transition);
    height: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
}
.product-card:hover {
    box-shadow: var(--shadow-hover);
    transform: translateY(-4px);
}

/* Wishlist heart — floating top-left */
.wishlist-overlay {
    position: absolute; top: 12px; left: 12px; z-index: 3;
}
.wishlist-overlay button {
    width: 36px; height: 36px; border-radius: 50%; border: none;
    background: rgba(255,255,255,0.92); color: var(--text-muted);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: var(--transition);
    box-shadow: 0 2px 8px rgba(0,0,0,0.10); font-size: 14px;
}
.wishlist-overlay button:hover {
    color: #e05a7a; background: #fff; transform: scale(1.1);
}

/* Image container */
.card-img-wrap {
    position: relative;
    width: 100%;
    aspect-ratio: 1 / 1;
    overflow: hidden;
    background: var(--brand-surface);
    display: block;
}
.card-img-wrap img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s cubic-bezier(0.4,0,0.2,1);
}
.product-card:hover .card-img-wrap img {
    transform: scale(1.05);
}

/* Card body */
.card-info {
    padding: 16px;
    display: flex;
    flex-direction: column;
    flex: 1;
    gap: 8px;
}
.card-stars { display: flex; gap: 2px; margin-bottom: 4px; }
.card-stars i { color: #ffc107; font-size: 14px; }
.card-name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    text-decoration: none;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
    margin: 0;
}
.card-name:hover { color: var(--brand-primary); }
.card-price {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-top: 2px;
}
.card-actions {
    margin-top: auto;
    padding-top: 12px;
}
.btn-add-cart {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 12px 0;
    background: #28a745;
    color: #fff;
    font-family: var(--font-body);
    font-weight: 600;
    font-size: 0.9rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: var(--transition);
    text-decoration: none;
}
.btn-add-cart:hover {
    background: #218838;
    color: #fff;
    transform: translateY(-1px);
}
</style>
@endpush
@section('content')

<div class="container my-5">
    <!-- Search Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Search Results</li>
                </ol>
            </nav>
            <h1 class="h3 mb-3">Search Results for "{{ $query }}"</h1>
            <p class="text-muted">Found {{ $products->total() }} product{{ $products->total() != 1 ? 's' : '' }}</p>
        </div>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="row products-grid" style="--bs-gutter-x: 20px;">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-6 mb-0">
                <div class="product-card">

                    {{-- Floating wishlist heart --}}
                    <div class="wishlist-overlay">
                        <form action="{{ route('wishlist.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_name"  value="{{ $product->p_name }}">
                            <input type="hidden" name="product_price" value="{{ $product->p_price }}">
                            <input type="hidden" name="product_image" value="{{ $product->p_image ? asset('storage/'.$product->p_image) : asset('assets/images/product/1.png') }}">
                            <button type="submit" title="Add to wishlist">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                        </form>
                    </div>

                    {{-- Product image --}}
                    <a href="{{ route('product.detail', ['slug' => Str::slug($product->p_name)]) }}">
                        <div class="card-img-wrap">
                            @if($product->p_image && !empty($product->p_image))
                                <img src="{{ asset('storage/'.$product->p_image) }}"
                                     alt="{{ $product->p_name }}"
                                     onerror="this.src='{{ asset('assets/images/product/1.png') }}'">
                            @else
                                <img src="{{ asset('assets/images/product/1.png') }}"
                                     alt="{{ $product->p_name }}">
                            @endif
                        </div>
                    </a>

                    {{-- Card info --}}
                    <div class="card-info">
                        <div class="card-stars">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>
                        <a href="{{ route('product.detail', ['slug' => Str::slug($product->p_name)]) }}"
                           class="card-name">{{ $product->p_name }}</a>
                        <div class="card-price">Rs. {{ number_format($product->p_price, 2) }}</div>
                        <div class="card-actions">
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id"       value="{{ $product->p_id }}">
                                <input type="hidden" name="name"     value="{{ $product->p_name }}">
                                <input type="hidden" name="price"    value="{{ $product->p_price }}">
                                <input type="hidden" name="image"    value="{{ $product->p_image ? asset('storage/'.$product->p_image) : asset('assets/images/product/1.png') }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-add-cart">
                                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="row mt-4">
                <div class="col-12">
                    {{ $products->links() }}
                </div>
            </div>
        @endif
    @else
        <div class="row">
            <div class="col-12 text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h4 class="text-muted mb-3">No products found</h4>
                <p class="text-muted">We couldn't find any products matching "{{ $query }}".</p>
                <p class="text-muted">Try searching with different keywords or browse our categories.</p>
                <a href="{{ route('categories') }}" class="btn theme-orange-btn mt-3">Browse Categories</a>
            </div>
        </div>
    @endif
</div>

@endsection
