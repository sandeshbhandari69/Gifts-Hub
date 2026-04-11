@extends('layouts.main')
@push('title')
    <title>All Products - Gifts Hub</title>
@endpush

@section('content')

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

/* ── Page header ── */
.page-header {
    background: linear-gradient(135deg, #0891b2 0%, #14b8a6 50%, #10b981 100%);
    padding: 44px 0 40px;
    margin-bottom: 48px;
}
.page-eyebrow {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 0.68rem; font-weight: 600; letter-spacing: 0.18em;
    text-transform: uppercase; color: var(--brand-gold);
    background: rgba(212,168,83,0.15); padding: 4px 12px;
    border-radius: 30px; margin-bottom: 10px;
}
.page-title {
    font-family: var(--font-display);
    font-size: clamp(1.8rem, 4vw, 2.8rem);
    font-weight: 700; color: #fff; line-height: 1.1; margin: 0 0 10px;
}
.page-subtitle { color: rgba(255,255,255,0.6); font-size: 0.92rem; margin: 0; }

/* ── Product Card ── */
.product-card { background: var(--brand-card); border-radius: var(--radius-lg); box-shadow: var(--shadow-card); overflow: hidden; transition: var(--transition); height: 100%; display: flex; flex-direction: column; position: relative; }
.product-card:hover { box-shadow: var(--shadow-hover); transform: translateY(-4px); }
.product-card .card-img-wrap { position: relative; width: 100%; aspect-ratio: 4 / 3; overflow: hidden; background: var(--brand-surface); }
.product-card .card-img-wrap img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: contain; padding: 10px; transition: transform 0.5s cubic-bezier(0.4,0,0.2,1); }
.product-card:hover .card-img-wrap img { transform: scale(1.05); }
.product-card .wishlist-overlay { position: absolute; top: 12px; right: 12px; z-index: 3; }
.product-card .wishlist-overlay button { width: 36px; height: 36px; border-radius: 50%; border: none; background: rgba(255,255,255,0.92); color: var(--text-muted); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: var(--transition); box-shadow: 0 2px 8px rgba(0,0,0,0.10); font-size: 14px; }
.product-card .wishlist-overlay button:hover { color: #e05a7a; background: #fff; transform: scale(1.1); }
.product-card .card-info { padding: 16px 18px 18px; display: flex; flex-direction: column; flex: 1; gap: 4px; }
.product-card .card-stars { display: flex; gap: 2px; margin-bottom: 4px; }
.product-card .card-stars i { color: var(--brand-gold); font-size: 11px; }
.product-card .card-name { font-size: 0.95rem; font-weight: 600; color: var(--text-primary); text-decoration: none; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4; margin: 0; }
.product-card .card-name:hover { color: var(--brand-primary); }
.product-card .card-price { font-size: 1.1rem; font-weight: 700; color: var(--brand-primary); margin-top: 4px; }
.product-card .card-cat { font-size: 0.78rem; color: var(--text-muted); margin-top: 2px; }
.product-card .card-actions { margin-top: auto; padding-top: 12px; }
.btn-add-cart { display: flex; align-items: center; justify-content: center; gap: 7px; width: 100%; padding: 11px 0; background: var(--brand-primary); color: #fff; font-family: var(--font-body); font-weight: 600; font-size: 0.85rem; border: none; border-radius: 30px; cursor: pointer; transition: var(--transition); text-decoration: none; }
.btn-add-cart:hover { background: var(--brand-secondary); color: #fff; transform: translateY(-1px); }

/* ── Grid ── */
.products-grid { row-gap: 24px; --bs-gutter-x: 20px; }

/* ── Empty state ── */
.empty-state { text-align: center; padding: 70px 20px; color: var(--text-muted); }
.empty-state i { font-size: 2.8rem; margin-bottom: 16px; display: block; opacity: 0.35; }
.empty-state h4 { color: var(--text-primary); font-family: var(--font-display); margin-bottom: 8px; }
.empty-state p { font-size: 0.92rem; max-width: 380px; margin: 0 auto; }

/* ── Pagination ── */
.pagination .page-link {
    color: var(--brand-primary);
    border-color: var(--border-color);
    border-radius: 8px !important;
    margin: 0 3px;
    font-family: var(--font-body);
    font-weight: 500;
    font-size: 0.88rem;
    transition: var(--transition);
}
.pagination .page-link:hover {
    background: var(--brand-primary);
    border-color: var(--brand-primary);
    color: #fff;
}
.pagination .page-item.active .page-link {
    background: var(--brand-primary);
    border-color: var(--brand-primary);
    color: #fff;
}
.pagination .page-item.disabled .page-link {
    color: var(--text-muted);
    border-color: var(--border-color);
}
</style>

{{-- ── Page header ── --}}
<div class="page-header">
    <div class="container">
        <h1 class="page-title">All Products</h1>
    </div>
</div>

{{-- ── Products grid ── --}}
<section style="padding: 0 0 64px;">
    <div class="container">

        @if($products->isEmpty())
            <div class="empty-state">
                <i class="fa-solid fa-box-open"></i>
                <h4>No products yet</h4>
                <p>Check back later — new products are added regularly.</p>
            </div>
        @else
            <div class="row products-grid">
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

                        {{-- Full image, no crop --}}
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
                            @if($product->category)
                                <div class="card-cat">{{ $product->category->c_name }}</div>
                            @endif
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

            {{-- Pagination --}}
            @if($products->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
            @endif
        @endif

    </div>
</section>

@endsection