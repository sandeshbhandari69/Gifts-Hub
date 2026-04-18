@extends('layouts.main')
@push('title')
    <title>Home Page</title>
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
.shop-section + .shop-section { padding-top: 0; }
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

/* ── Category Card ── */
.category-card { background: var(--brand-card); border-radius: var(--radius-lg); box-shadow: var(--shadow-card); overflow: hidden; transition: var(--transition); height: 100%; display: flex; flex-direction: column; text-decoration: none; color: inherit; }
.category-card:hover { box-shadow: var(--shadow-hover); transform: translateY(-4px); color: inherit; }
.category-card .cat-img-wrap { width: 100%; aspect-ratio: 4 / 3; background: linear-gradient(135deg, #f8f0ea 0%, #f0e4d7 100%); display: flex; align-items: center; justify-content: center; font-size: 3rem; color: var(--brand-primary); position: relative; overflow: hidden; }
.category-card .cat-info { padding: 14px 18px 18px; }
.category-card .cat-name { font-size: 0.95rem; font-weight: 600; color: var(--text-primary); margin: 0 0 3px; }
.category-card .cat-count { font-size: 0.78rem; color: var(--text-muted); }

/* ── Grid / utils ── */
.products-grid { row-gap: 24px; --bs-gutter-x: 20px; }
.empty-state { text-align: center; padding: 60px 20px; color: var(--text-muted); }
.empty-state i { font-size: 2.5rem; margin-bottom: 12px; display: block; opacity: 0.4; }
.section-divider { height: 1px; background: var(--border-color); margin: 0 var(--bs-gutter-x, 12px); }


/* ══════════════════════════════════════════
   SPLIT HERO  (replaces slider)
══════════════════════════════════════════ */
.hero-split {
    background: var(--brand-dark);
    display: grid;
    grid-template-columns: 1fr 1fr;
    min-height: 480px;
    overflow: hidden;
}

/* Left – text side */
.hero-split .hero-left {
    padding: 64px 48px 64px 56px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.hero-split .hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 0.68rem;
    font-weight: 600;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: var(--brand-gold);
    margin-bottom: 20px;
}
.hero-split .hero-eyebrow::before {
    content: '';
    display: block;
    width: 28px;
    height: 1px;
    background: var(--brand-gold);
}
.hero-split .hero-title {
    font-family: var(--font-display);
    font-size: clamp(2.2rem, 4vw, 3.8rem);
    font-weight: 700;
    color: #ffffff;
    line-height: 1.1;
    margin-bottom: 18px;
}
.hero-split .hero-title em { font-style: italic; color: var(--brand-secondary); }
.hero-split .hero-desc {
    font-size: 0.95rem;
    color: rgba(255,255,255,0.65);
    line-height: 1.8;
    max-width: 380px;
    margin-bottom: 34px;
    font-weight: 300;
}
.hero-split .hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }
.btn-hero-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 28px;
    background: var(--brand-primary);
    color: #fff;
    font-family: var(--font-body);
    font-weight: 600;
    font-size: 0.88rem;
    text-decoration: none;
    border-radius: 50px;
    border: none;
    cursor: pointer;
    transition: var(--transition);
}
.btn-hero-primary:hover { background: var(--brand-secondary); transform: translateY(-2px); color: #fff; }
.btn-hero-ghost {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 24px;
    background: transparent;
    color: rgba(255,255,255,0.82);
    font-family: var(--font-body);
    font-weight: 500;
    font-size: 0.88rem;
    text-decoration: none;
    border-radius: 50px;
    border: 1.5px solid rgba(255,255,255,0.32);
    transition: var(--transition);
    cursor: pointer;
}
.btn-hero-ghost:hover { border-color: rgba(255,255,255,0.72); background: rgba(255,255,255,0.09); color: #fff; }

/* Right – stats mosaic */
.hero-split .hero-right {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 1fr 1fr;
    gap: 3px;
    background: rgba(255,255,255,0.04);
}
.hero-stat-cell {
    background: rgba(255,255,255,0.06);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 28px 16px;
    transition: var(--transition);
}
.hero-stat-cell:hover { background: rgba(255,255,255,0.10); }
.hero-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: rgba(196,82,42,0.20);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: var(--brand-secondary);
}
.hero-stat-num {
    font-family: var(--font-display);
    font-size: 1.8rem;
    font-weight: 700;
    color: #fff;
    line-height: 1;
}
.hero-stat-lbl {
    font-size: 0.72rem;
    font-weight: 500;
    color: rgba(255,255,255,0.55);
    text-align: center;
    letter-spacing: 0.03em;
}

/* Hero image variant (when real image available) */
.hero-split .hero-image-side {
    position: relative;
    overflow: hidden;
}
.hero-split .hero-image-side img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.hero-split .hero-image-side::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, rgba(28,25,23,0.3) 0%, transparent 60%);
}

/* ── Trust bar ── */
.trust-bar {
    background: #111;
    padding: 11px 0;
    overflow: hidden;
    width: 100%;
}
.trust-track { display: flex; gap: 56px; animation: marquee 24s linear infinite; white-space: nowrap; }
.trust-item { display: flex; align-items: center; gap: 9px; font-size: 0.74rem; font-weight: 500; letter-spacing: 0.07em; color: rgba(255,255,255,0.55); flex-shrink: 0; font-family: var(--font-body); }
.trust-item i { color: var(--brand-gold); }
@keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

/* ── Promo Banner Row ── */
.promo-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.promo-card {
    border-radius: var(--radius-lg);
    padding: 36px 32px;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    min-height: 200px;
    text-decoration: none;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}
.promo-card:hover { transform: translateY(-3px); }
.promo-card.warm { background: linear-gradient(135deg, #c4522a 0%, #e8896a 100%); }
.promo-card.dark { background: linear-gradient(135deg, #1c1917 0%, #3d2b1c 100%); }
.promo-tag { font-size: 0.65rem; font-weight: 600; letter-spacing: 0.18em; text-transform: uppercase; color: rgba(255,255,255,0.75); margin-bottom: 8px; }
.promo-card.dark .promo-tag { color: var(--brand-gold); }
.promo-h { font-family: var(--font-display); font-size: 1.4rem; font-weight: 700; color: #fff; line-height: 1.2; margin-bottom: 6px; }
.promo-sub { font-size: 0.80rem; color: rgba(255,255,255,0.70); margin-bottom: 18px; }
.btn-promo {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 20px;
    background: rgba(255,255,255,0.18);
    color: #fff;
    font-size: 0.78rem;
    font-weight: 600;
    border: 1.5px solid rgba(255,255,255,0.40);
    border-radius: 30px;
    text-decoration: none;
    width: fit-content;
    transition: var(--transition);
}
.btn-promo:hover { background: rgba(255,255,255,0.30); color: #fff; }

/* ── Featured Highlight Banner ── */
.featured-banner {
    background: linear-gradient(120deg, #2a1810 0%, #3d1f12 50%, #1c1917 100%);
    border-radius: var(--radius-lg);
    padding: 44px 48px;
    display: grid;
    grid-template-columns: 1fr auto;
    align-items: center;
    gap: 40px;
}
.fb-eyebrow { font-size: 0.65rem; font-weight: 600; letter-spacing: 0.18em; text-transform: uppercase; color: var(--brand-gold); margin-bottom: 10px; }
.fb-title { font-family: var(--font-display); font-size: clamp(1.5rem, 2.5vw, 2.1rem); font-weight: 700; color: #fff; margin-bottom: 12px; line-height: 1.15; }
.fb-title em { font-style: italic; color: var(--brand-secondary); }
.fb-desc { font-size: 0.88rem; color: rgba(255,255,255,0.60); line-height: 1.8; max-width: 420px; }
.fb-right { display: flex; flex-direction: column; align-items: flex-end; gap: 18px; }
.fb-badge {
    background: rgba(212,168,83,0.14);
    border: 1px solid rgba(212,168,83,0.30);
    border-radius: var(--radius-md);
    padding: 14px 22px;
    text-align: center;
    white-space: nowrap;
}
.fb-badge-num { font-family: var(--font-display); font-size: 2.2rem; font-weight: 700; color: var(--brand-gold); display: block; line-height: 1; }
.fb-badge-lbl { font-size: 0.68rem; color: rgba(255,255,255,0.50); letter-spacing: 0.10em; margin-top: 4px; display: block; }

/* ── Responsive ── */
@media (max-width: 991px) {
    .hero-split { grid-template-columns: 1fr; min-height: auto; }
    .hero-split .hero-right { grid-template-columns: repeat(4,1fr); grid-template-rows: 1fr; }
    .hero-split .hero-left { padding: 52px 32px; }
    .promo-row { grid-template-columns: 1fr; }
    .featured-banner { grid-template-columns: 1fr; }
    .fb-right { align-items: flex-start; }
}
@media (max-width: 767px) {
    .hero-split .hero-right { grid-template-columns: repeat(2,1fr); grid-template-rows: 1fr 1fr; }
    .hero-split .hero-left { padding: 40px 20px; }
    .section-header { flex-wrap: wrap; }
    .featured-banner { padding: 32px 24px; }
}
@media (max-width: 480px) {
    .hero-split .hero-title { font-size: 2rem; }
    .hero-split .hero-right { display: none; }
    .hero-split { grid-template-columns: 1fr; }
}
</style>

{{-- ══════ PROMO BANNERS ══════ --}}
<section class="shop-section" style="padding-bottom: 32px;">
    <div class="container">
        <div class="promo-row">
            <a href="{{ route('categories') }}" class="promo-card warm">
                <div class="promo-tag">Limited Time Offer</div>
                <div class="promo-h">Birthday &amp; Anniversary<br>Gift Bundles</div>
                <div class="promo-sub">Save up to 30% on curated gift sets</div>
                <span class="btn-promo">Shop Bundles &nbsp;<i class="fa-solid fa-arrow-right"></i></span>
            </a>
            <a href="{{ route('categories') }}" class="promo-card dark">
                <div class="promo-tag">✦ New Arrivals</div>
                <div class="promo-h">Premium Gifting<br>Experience</div>
                <div class="promo-sub">Luxury wrapping &amp; same-day delivery</div>
                <span class="btn-promo">Explore Now &nbsp;<i class="fa-solid fa-arrow-right"></i></span>
            </a>
        </div>
    </div>
</section>


{{-- ══════ TOP DEALS ══════ --}}
<div class="container"><div class="section-divider"></div></div>
<section class="shop-section" id="products-section">
    <div class="container">
        <div class="section-header">
            <div>
                <span class="section-label"><i class="fa-solid fa-fire-flame-curved"></i> Recommendations</span>
                <h2 class="section-title">Top Deals</h2>
            </div>
            <a href="{{ route('categories') }}" class="view-all-link">View All <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="row products-grid">
            @forelse($products->take(4) as $product)
            <div class="col-lg-3 col-md-6 mb-0">
                <div class="product-card">
                    <div class="wishlist-overlay">
                        <form action="{{ route('wishlist.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_name"  value="{{ $product->p_name }}">
                            <input type="hidden" name="product_price" value="{{ $product->p_price }}">
                            <input type="hidden" name="product_image" value="{{ $product->p_image ? asset('storage/'.$product->p_image) : asset('assets/images/product/1.png') }}">
                            <button type="submit" title="Add to wishlist"><i class="fa-regular fa-heart"></i></button>
                        </form>
                    </div>
                    <a href="{{ route('product.detail', ['slug' => Str::slug($product->p_name)]) }}">
                        <div class="card-img-wrap">
                            @if($product->p_image && !empty($product->p_image))
                                <img src="{{ asset('storage/'.$product->p_image) }}" alt="{{ $product->p_name }}" onerror="this.src='{{ asset('assets/images/product/1.png') }}'">
                            @else
                                <img src="{{ asset('assets/images/product/1.png') }}" alt="{{ $product->p_name }}">
                            @endif
                        </div>
                    </a>
                    <div class="card-info">
                        <div class="card-stars">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>
                        <a href="{{ route('product.detail', ['slug' => Str::slug($product->p_name)]) }}" class="card-name">{{ $product->p_name }}</a>
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
            @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="fas fa-box"></i>
                    <p>No products available yet.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>


{{-- ══════ MORE PRODUCTS ══════ --}}
@if($products->count() > 4)
<div class="container"><div class="section-divider"></div></div>
<section class="shop-section">
    <div class="container">
        <div class="section-header">
            <div>
                <span class="section-label"><i class="fa-solid fa-bolt"></i> Hot</span>
                <h2 class="section-title">More Products</h2>
            </div>
        </div>
        <div class="row products-grid">
            @foreach($products->slice(4) as $product)
            <div class="col-lg-3 col-md-6 mb-0">
                <div class="product-card">
                    <div class="wishlist-overlay">
                        <form action="{{ route('wishlist.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_name"  value="{{ $product->p_name }}">
                            <input type="hidden" name="product_price" value="{{ $product->p_price }}">
                            <input type="hidden" name="product_image" value="{{ $product->p_image ? asset('storage/'.$product->p_image) : asset('assets/images/product/1.png') }}">
                            <button type="submit" title="Add to wishlist"><i class="fa-regular fa-heart"></i></button>
                        </form>
                    </div>
                    <a href="{{ route('product.detail', ['slug' => Str::slug($product->p_name)]) }}">
                        <div class="card-img-wrap">
                            @if($product->p_image && !empty($product->p_image))
                                <img src="{{ asset('storage/'.$product->p_image) }}" alt="{{ $product->p_name }}" onerror="this.src='{{ asset('assets/images/product/1.png') }}'">
                            @else
                                <img src="{{ asset('assets/images/product/1.png') }}" alt="{{ $product->p_name }}">
                            @endif
                        </div>
                    </a>
                    <div class="card-info">
                        <div class="card-stars">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>
                        <a href="{{ route('product.detail', ['slug' => Str::slug($product->p_name)]) }}" class="card-name">{{ $product->p_name }}</a>
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
    </div>
</section>
@endif


{{-- ══════ FEATURED HIGHLIGHT BANNER ══════ --}}
<div class="container"><div class="section-divider"></div></div>
<section class="shop-section" style="padding-bottom: 0;">
    <div class="container">
        <div class="featured-banner">
            <div>
                <div class="fb-eyebrow">✦ Featured Collection</div>
                <div class="fb-title">Give <em>Joy</em>,<br>Not Just Gifts</div>
                <p class="fb-desc">From birthdays to anniversaries — every celebration deserves something extraordinary and memorable. Explore our handpicked premium selections.</p>
            </div>
            <div class="fb-right">
                <div class="fb-badge">
                    <span class="fb-badge-num">500+</span>
                    <span class="fb-badge-lbl">HAPPY CUSTOMERS</span>
                </div>
                <a href="{{ route('categories') }}" class="btn-hero-primary">
                    Shop Collection &nbsp;<i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>


{{-- ══════ GIFT CATEGORIES ══════ --}}
<section class="shop-section">
    <div class="container">
        <div class="section-header">
            <div>
                <span class="section-label"><i class="fa-solid fa-layer-group"></i> Browse</span>
                <h2 class="section-title">Gift Categories</h2>
            </div>
            <a href="{{ route('categories') }}" class="view-all-link">All Categories <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="row products-grid">
            @forelse($categories->take(4) as $category)
            <div class="col-lg-3 col-md-6 mb-0">
                <a href="{{ route('categories.products', ['slug' => Str::slug($category->c_name)]) }}" class="category-card">
                    <div class="cat-img-wrap">
                        <i class="fa-solid fa-gift"></i>
                    </div>
                    <div class="cat-info">
                        <div class="cat-name">{{ $category->c_name }}</div>
                        <div class="cat-count">{{ $category->products_count }} products</div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="fas fa-list"></i>
                    <p>No categories available yet.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

@endsection