@extends('layouts.main')
@push('title')
    <title>{{ $currentCategory ? $currentCategory->c_name : 'Category Products' }} - Gifts Hub</title>
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
    --radius-sm:       8px;
    --radius-md:       14px;
    --radius-lg:       20px;
    --shadow-card:     0 2px 8px rgba(28,25,23,0.07), 0 0 0 1px rgba(28,25,23,0.06);
    --shadow-hover:    0 10px 32px rgba(28,25,23,0.13), 0 0 0 1px rgba(28,25,23,0.06);
    --font-display:    'Playfair Display', serif;
    --font-body:       'DM Sans', sans-serif;
    --transition:      all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
}

body { font-family: var(--font-body); background: var(--brand-surface); }

/* ── Section layout ── */
.shop-section { padding: 60px 0; }
.section-header { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 32px; gap: 16px; }
.section-label { display: inline-flex; align-items: center; gap: 6px; font-size: 0.68rem; font-weight: 600; letter-spacing: 0.18em; text-transform: uppercase; color: var(--brand-primary); margin-bottom: 6px; background: rgba(196,82,42,0.08); padding: 4px 10px; border-radius: 30px; }
.section-title { font-family: var(--font-display); font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 700; color: var(--text-primary); line-height: 1.15; margin: 0; }
.view-all-link { display: inline-flex; align-items: center; gap: 7px; font-size: 0.84rem; font-weight: 600; color: var(--brand-primary); text-decoration: none; padding: 9px 20px; border: 1.5px solid rgba(196,82,42,0.28); border-radius: 30px; white-space: nowrap; transition: var(--transition); flex-shrink: 0; }
.view-all-link:hover { background: var(--brand-primary); color: #fff; border-color: var(--brand-primary); transform: translateY(-1px); }

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
.product-card .card-actions { margin-top: auto; padding-top: 12px; }
.btn-add-cart { display: flex; align-items: center; justify-content: center; gap: 7px; width: 100%; padding: 11px 0; background: var(--brand-primary); color: #fff; font-family: var(--font-body); font-weight: 600; font-size: 0.85rem; border: none; border-radius: 30px; cursor: pointer; transition: var(--transition); text-decoration: none; }
.btn-add-cart:hover { background: var(--brand-secondary); color: #fff; transform: translateY(-1px); }

/* ── Grid / utils ── */
.products-grid { row-gap: 24px; --bs-gutter-x: 20px; }
.empty-state { text-align: center; padding: 60px 20px; color: var(--text-muted); }
.empty-state i { font-size: 2.5rem; margin-bottom: 12px; display: block; opacity: 0.4; }

/* ── Category hero header ── */
.category-header {
    background: linear-gradient(135deg, var(--brand-dark) 0%, #ffffff 100%);
    color: white;
    padding: 44px 0 40px;
    margin-bottom: 48px;
}
.cat-breadcrumb { display: flex; align-items: center; gap: 8px; margin-bottom: 18px; flex-wrap: wrap; }
.cat-breadcrumb a { color: rgba(255,255,255,0.65); text-decoration: none; font-size: 0.82rem; font-weight: 500; transition: color 0.2s; }
.cat-breadcrumb a:hover { color: #fff; }
.cat-breadcrumb .crumb-active { color: var(--brand-gold); font-size: 0.82rem; font-weight: 500; }
.cat-eyebrow { display: inline-flex; align-items: center; gap: 6px; font-size: 0.68rem; font-weight: 600; letter-spacing: 0.18em; text-transform: uppercase; color: var(--brand-gold); background: rgba(212,168,83,0.15); padding: 4px 12px; border-radius: 30px; margin-bottom: 10px; }
.cat-title { font-family: var(--font-display); font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 700; color: #fff; line-height: 1.1; margin: 0 0 10px; }
.cat-count { color: rgba(255,255,255,0.6); font-size: 0.92rem; margin: 0; }
.btn-back { display: inline-flex; align-items: center; gap: 8px; font-size: 0.84rem; font-weight: 600; color: rgba(255,255,255,0.85); text-decoration: none; padding: 10px 22px; border: 1.5px solid rgba(255,255,255,0.25); border-radius: 30px; transition: var(--transition); flex-shrink: 0; }
.btn-back:hover { background: rgba(255,255,255,0.12); border-color: rgba(255,255,255,0.5); color: #fff; }

/* ── Alert / error ── */
.alert-not-found { border-radius: var(--radius-lg); border: none; background: rgba(220,53,69,0.08); padding: 24px 28px; display: flex; align-items: center; gap: 16px; }
.alert-not-found i { font-size: 1.6rem; color: #dc3545; flex-shrink: 0; }
.alert-not-found h5 { margin: 0 0 4px; color: var(--text-primary); }
.alert-not-found p { margin: 0; font-size: 0.88rem; color: var(--text-secondary); }
</style>

{{-- ── Category hero header ── --}}
<div class="category-header">
    <div class="container">
            <a href="{{ route('categories') }}" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i> All Categories
            </a>
        </div>
    </div>
</div>

{{-- ── Products section ── --}}
<section class="shop-section" style="padding-top: 0;">
    <div class="container">

        @if(!$currentCategory)
            <div class="alert-not-found">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <div>
                    <h5>Category Not Found</h5>
                    <p>The category you're looking for doesn't exist. Please browse all available categories.</p>
                </div>
            </div>

        @elseif($products->count() === 0)
            <div class="empty-state">
                <i class="fa-solid fa-box-open"></i>
                <h4 style="font-family: var(--font-display); color: var(--text-primary); margin-bottom: 8px;">No products yet</h4>
                <p style="font-size: 0.92rem; max-width: 380px; margin: 0 auto 24px;">This category exists but has no products yet. Check back later or browse other categories.</p>
                <a href="{{ route('categories') }}" class="btn-add-cart" style="width:auto; padding:12px 28px; display:inline-flex;">
                    <i class="fa-solid fa-th-large"></i> Browse All Categories
                </a>
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
                                <small style="font-size: 0.78rem; color: var(--text-muted);">
                                    {{ $product->category->c_name }}
                                </small>
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
        @endif

    </div>
</section>

@endsection