@extends('layouts.main')

@push('title')
<title>Product Detail</title>
@endpush

@push('styles')
<style>
    /* ── Typography ── */
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=DM+Sans:wght@400;500;600&display=swap');

    .pd-wrap { font-family: 'DM Sans', sans-serif; }

    /* ── Hero Grid ── */
    .pd-hero {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 48px;
        padding: 48px 0;
        align-items: start;
    }
    @media (max-width: 768px) {
        .pd-hero { grid-template-columns: 1fr; gap: 28px; }
    }

    /* ── Image Panel ── */
    .pd-img-panel {
        background: #f7f9f5;
        border-radius: 20px;
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        border: 1px solid #e5ede7;
    }
    .pd-img-panel img {
        width: 80%;
        max-height: 80%;
        object-fit: contain;
        transition: transform 0.4s ease;
    }
    .pd-img-panel:hover img { transform: scale(1.04); }
    .pd-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        background: #2d6a4f;
        color: #fff;
        font-size: 11px;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
        letter-spacing: 0.5px;
    }

    /* ── Product Info ── */
    .pd-info { display: flex; flex-direction: column; gap: 18px; }
    .pd-category {
        font-size: 12px;
        font-weight: 600;
        color: #2d6a4f;
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    .pd-title {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 600;
        line-height: 1.2;
        margin: 0;
        color: #1a1a1a;
    }
    .pd-stars-row { display: flex; align-items: center; gap: 10px; }
    .pd-stars-row .fa-star.checked { color: #f4a629; }
    .pd-stars-row .fa-star { color: #d0d0d0; }
    .pd-stars-row small { color: #888; font-size: 13px; }
    .pd-price {
        font-size: 1.75rem;
        font-weight: 700;
        color: #2d6a4f;
    }
    .pd-desc { font-size: 0.93rem; color: #555; line-height: 1.75; }

    /* ── Quantity ── */
    .pd-qty-wrap { display: flex; align-items: center; gap: 14px; }
    .pd-qty-label { font-size: 13px; font-weight: 600; color: #555; }
    .pd-qty { display: flex; align-items: center; }
    .pd-qty .btn-qty {
        width: 36px; height: 36px;
        border: 1px solid #cdd9d2;
        background: #fff;
        color: #333;
        font-size: 16px;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background 0.15s;
        line-height: 1;
    }
    .pd-qty .btn-qty:first-child { border-radius: 20px 0 0 20px; }
    .pd-qty .btn-qty:last-child  { border-radius: 0 20px 20px 0; }
    .pd-qty .btn-qty:hover { background: #eaf3de; }
    .pd-qty .qty-val {
        width: 44px; height: 36px;
        text-align: center;
        border-top: 1px solid #cdd9d2;
        border-bottom: 1px solid #cdd9d2;
        border-left: none; border-right: none;
        background: #fff;
        font-size: 14px; font-weight: 600;
        display: flex; align-items: center; justify-content: center;
    }

    /* ── Action Buttons ── */
    .pd-actions { display: flex; flex-wrap: wrap; gap: 10px; }
    .btn-pd-cart {
        flex: 1; min-width: 140px;
        padding: 13px 22px;
        background: #2d6a4f; color: #fff;
        border: none; border-radius: 30px;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px; font-weight: 600;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
        display: inline-flex; align-items: center; justify-content: center; gap: 7px;
    }
    .btn-pd-cart:hover { background: #1b4332; transform: translateY(-1px); color: #fff; }
    .btn-pd-wish {
        padding: 13px 22px;
        border: 1.5px solid #2d6a4f; color: #2d6a4f;
        background: transparent; border-radius: 30px;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px; font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex; align-items: center; justify-content: center; gap: 7px;
    }
    .btn-pd-wish:hover { background: #eaf3de; color: #2d6a4f; }
    .btn-pd-buy {
        flex: 1; min-width: 140px;
        padding: 13px 22px;
        background: #e07b39; color: #fff;
        border: none; border-radius: 30px;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px; font-weight: 600;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
        display: inline-flex; align-items: center; justify-content: center; gap: 7px;
    }
    .btn-pd-buy:hover { background: #c4612a; transform: translateY(-1px); color: #fff; }

    /* ── Product Meta ── */
    .pd-meta { display: flex; flex-direction: column; gap: 8px; padding-top: 18px; border-top: 1px solid #eaeaea; }
    .pd-meta-row { display: flex; gap: 10px; font-size: 13px; }
    .pd-meta-row .lbl { color: #888; min-width: 80px; }
    .pd-meta-row .val { color: #222; font-weight: 500; }
    .pd-meta-row .val.in-stock { color: #2d6a4f; }

    /* ── Description Box ── */
    .pd-desc-box {
        background: #f7f9f5;
        border-radius: 16px;
        padding: 32px 36px;
        margin: 48px 0;
        border: 1px solid #e5ede7;
    }
    .pd-desc-box p { font-size: 0.94rem; color: #555; line-height: 1.8; margin: 0; }
    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 20px;
    }

    /* ── Related Products ── */
    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 22px;
    }

    /* ── Product Card (using provided CSS variables mapped to concrete values) ── */
    .product-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        overflow: hidden;
        transition: box-shadow 0.2s ease, transform 0.2s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
        border: 1px solid #eaeaea;
    }
    .product-card:hover {
        box-shadow: 0 8px 28px rgba(0,0,0,0.13);
        transform: translateY(-4px);
    }
    .product-card .card-img-wrap {
        position: relative;
        width: 100%;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        background: #f7f9f5;
    }
    .product-card .card-img-wrap img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 10px;
        transition: transform 0.5s cubic-bezier(0.4,0,0.2,1);
    }
    .product-card:hover .card-img-wrap img { transform: scale(1.05); }
    .product-card .wishlist-overlay {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 3;
    }
    .product-card .wishlist-overlay button {
        width: 34px; height: 34px;
        border-radius: 50%;
        border: none;
        background: rgba(255,255,255,0.92);
        color: #999;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.10);
        font-size: 14px;
    }
    .product-card .wishlist-overlay button:hover { color: #e05a7a; transform: scale(1.1); }
    .product-card .card-info {
        padding: 16px 18px 18px;
        display: flex;
        flex-direction: column;
        flex: 1;
        gap: 4px;
    }
    .product-card .card-stars { display: flex; gap: 2px; margin-bottom: 4px; }
    .product-card .card-stars .fa-star { font-size: 11px; }
    .product-card .card-stars .fa-star.checked { color: #f4a629; }
    .product-card .card-stars .fa-star { color: #d0d0d0; }
    .product-card .card-name {
        font-size: 0.92rem;
        font-weight: 600;
        color: #1a1a1a;
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.4;
        margin: 0;
    }
    .product-card .card-name:hover { color: #2d6a4f; }
    .product-card .card-price {
        font-size: 1.05rem;
        font-weight: 700;
        color: #2d6a4f;
        margin-top: 4px;
    }
    .product-card .card-actions { margin-top: auto; padding-top: 12px; }
    .btn-add-cart {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        width: 100%;
        padding: 11px 0;
        background: #2d6a4f;
        color: #fff;
        font-family: 'DM Sans', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        border: none;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }
    .btn-add-cart:hover { background: #1b4332; color: #fff; transform: translateY(-1px); }

    /* ── Reviews ── */
    .review-item {
        display: grid;
        grid-template-columns: 52px 1fr;
        gap: 16px;
        padding: 24px 0;
        border-bottom: 1px solid #eaeaea;
        align-items: start;
    }
    .review-avatar {
        width: 46px; height: 46px;
        border-radius: 50%;
        background: #eaf3de;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 14px;
        color: #2d6a4f;
        flex-shrink: 0;
    }
    .review-header { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 6px; }
    .review-name { font-weight: 600; font-size: 0.95rem; margin: 0; }
    .review-date { font-size: 12px; color: #888; }
    .review-text { font-size: 0.92rem; color: #555; line-height: 1.65; margin: 8px 0 12px; }
    .btn-reply {
        font-size: 12px; padding: 5px 16px;
        border: 1px solid #ddd; background: transparent;
        color: #555; border-radius: 20px; cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        text-decoration: none; display: inline-block;
        transition: background 0.15s;
    }
    .btn-reply:hover { background: #f5f5f5; color: #333; }

    /* ── Review Form ── */
    .review-form-box {
        background: #f7f9f5;
        border-radius: 16px;
        padding: 36px;
        margin-top: 48px;
        border: 1px solid #e5ede7;
    }
    .rating-pick { display: flex; gap: 6px; margin-bottom: 20px; }
    .rating-pick .fa-star { font-size: 22px; color: #ccc; cursor: pointer; transition: color 0.15s; }
    .rating-pick .fa-star.active { color: #f4a629; }
    .rf-input, .rf-textarea {
        width: 100%;
        padding: 13px 16px;
        border: 1px solid #d0ddd5;
        border-radius: 10px;
        background: #fff;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        color: #222;
        box-sizing: border-box;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .rf-input:focus, .rf-textarea:focus {
        border-color: #2d6a4f;
        box-shadow: 0 0 0 3px rgba(45,106,79,0.12);
    }
    .rf-textarea { resize: vertical; min-height: 120px; }

    /* ── Section divider ── */
    .pd-divider { border: none; border-top: 1px solid #eaeaea; margin: 16px 0 40px; }
</style>
@endpush

@section('content')

<div class="pd-wrap">

    {{-- ── Hero Section ── --}}
    <section class="my-5">
        <div class="container">
            <div class="pd-hero">

                {{-- Product Image --}}
                <div class="pd-img-panel">
                    <span class="pd-badge">✦ New Arrival</span>
                    <img src="{{ asset('storage/'.$product->p_image) }}"
                         alt="{{ $product->p_name }}">
                </div>

                {{-- Product Info --}}
                <div class="pd-info">
                    <div class="pd-category">{{ $product->category->c_name ?? 'Gifts & Lifestyle' }}</div>

                    <h1 class="pd-title">{{ $product->p_name }}</h1>

                    <div class="pd-stars-row">
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <small>2 Customer Reviews</small>
                    </div>

                    <div class="pd-price">Rs. {{ number_format($product->p_price, 2) }}</div>

                    <p class="pd-desc">
                        {{ $product->p_description ?? $product->p_name . ' is a premium gift item perfect for your loved ones.
                        Top quality and best price guaranteed.' }}
                    </p>

                    {{-- Quantity --}}
                    <div class="pd-qty-wrap">
                        <span class="pd-qty-label">Qty</span>
                        <div class="pd-qty">
                            <button class="btn-qty" type="button" onclick="adjustQty(-1)">
                                <i class="fa-solid fa-minus" style="font-size:12px;"></i>
                            </button>
                            <div class="qty-val" id="qtyDisplay">1</div>
                            <button class="btn-qty" type="button" onclick="adjustQty(1)">
                                <i class="fa-solid fa-plus" style="font-size:12px;"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="pd-actions">
                        <form action="{{ route('cart.add') }}" method="POST" style="flex:1;min-width:140px;">
                            @csrf
                            <input type="hidden" name="id"       value="{{ md5($product->p_name ?? uniqid()) }}">
                            <input type="hidden" name="name"     value="{{ $product->p_name  ?? 'Product' }}">
                            <input type="hidden" name="price"    value="{{ number_format($product->p_price, 2) }}">
                            <input type="hidden" name="image"    value="{{ $product->p_image ? asset('storage/'.$product->p_image) : asset('assets/images/product/1.png') }}">
                            <input type="hidden" name="quantity" id="cartQty" value="1">
                            <button type="submit" class="btn-pd-cart" style="width:100%;">
                                <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                            </button>
                        </form>

                        <form action="{{ route('wishlist.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_name"  value="{{ $product->p_name  ?? 'Product' }}">
                            <input type="hidden" name="product_price" value="Rs. {{ number_format($product->p_price, 2) }}">
                            <input type="hidden" name="product_image" value="{{ $product->p_image ?? 'assets/images/product/1.png' }}">
                            <button type="submit" class="btn-pd-wish">
                                <i class="fa-regular fa-heart"></i> Wishlist
                            </button>
                        </form>

                        <form action="{{ route('cart.add') }}" method="POST" style="flex:1;min-width:140px;">
                            @csrf
                            <input type="hidden" name="id"          value="{{ md5($product->p_name ?? uniqid()) }}">
                            <input type="hidden" name="name"        value="{{ $product->p_name  ?? 'Product' }}">
                            <input type="hidden" name="price"       value="{{ number_format($product->p_price, 2) }}">
                            <input type="hidden" name="image"       value="{{ $product->p_image ? asset('storage/'.$product->p_image) : asset('assets/images/product/1.png') }}">
                            <input type="hidden" name="quantity"    value="1">
                            <input type="hidden" name="redirect_to" value="checkout">
                            <button type="submit" class="btn-pd-buy" style="width:100%;">
                                Buy Now <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </form>
                    </div>

                    {{-- Meta Info --}}
                    <div class="pd-meta">
                        <div class="pd-meta-row">
                            <span class="lbl">SKU</span>
                            <span class="val">{{ strtoupper(substr(md5($product->p_name ?? ''), 0, 8)) }}</span>
                        </div>
                        <div class="pd-meta-row">
                            <span class="lbl">Category</span>
                            <span class="val">{{ $product->category->c_name ?? 'Gift Sets' }}</span>
                        </div>
                        <div class="pd-meta-row">
                            <span class="lbl">Stock</span>
                            <span class="val in-stock"><i class="fa-solid fa-circle" style="font-size:8px;"></i> In Stock</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Description --}}
            <div class="pd-desc-box">
                <h2 class="section-title">Product Description</h2>
                <p>
                    {{ $product->p_description ?? 'Detailed description for ' . $product->p_name . ' will go here.
                    Currently using mock description. You can elaborate on materials,
                    usage, care instructions, and what makes this product special.' }}
                </p>
            </div>
        </div>
    </section>


    {{-- ── Related Products ── --}}
    <section class="my-5">
        <div class="container">
            <div class="d-flex align-items-center mb-4">
                <h2 class="section-title flex-grow-1 mb-0">Related Products</h2>
                <a href="#" class="btn btn-sm theme-green-btn text-light rounded-pill">View All</a>
            </div>

            <div class="related-grid">
                @if($relatedProducts && $relatedProducts->count() > 0)
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="product-card">
                            <div class="card-img-wrap">
                                <img src="{{ asset('storage/'.$relatedProduct->p_image) }}" alt="{{ $relatedProduct->p_name }}">
                                <div class="wishlist-overlay">
                                    <button type="button" title="Add to Wishlist">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-info">
                                <div class="card-stars">
                                    <i class="fa fa-star checked"></i>
                                    <i class="fa fa-star checked"></i>
                                    <i class="fa fa-star checked"></i>
                                    <i class="fa fa-star checked"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <a href="{{ route('product.detail', Str::slug($relatedProduct->p_name)) }}" class="card-name">{{ $relatedProduct->p_name }}</a>
                                <div class="card-price">Rs. {{ number_format($relatedProduct->p_price, 2) }}</div>
                                <div class="card-actions">
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ md5($relatedProduct->p_name ?? uniqid()) }}">
                                        <input type="hidden" name="name" value="{{ $relatedProduct->p_name ?? 'Product' }}">
                                        <input type="hidden" name="price" value="{{ number_format($relatedProduct->p_price, 2) }}">
                                        <input type="hidden" name="image" value="{{ $relatedProduct->p_image ? asset('storage/'.$relatedProduct->p_image) : asset('assets/images/product/1.png') }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn-add-cart">
                                            <i class="fa-solid fa-cart-shopping" style="font-size:13px;"></i> Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- Fallback to static products if no related products found --}}
                    <div class="product-card">
                        <div class="card-img-wrap">
                            <img src="{{ asset('assets/images/SubCategory/Gadgets/headphone.png') }}" alt="Headphone">
                            <div class="wishlist-overlay">
                                <button type="button" title="Add to Wishlist">
                                    <i class="fa-regular fa-heart"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="card-stars">
                                <i class="fa fa-star checked"></i>
                                <i class="fa fa-star checked"></i>
                                <i class="fa fa-star checked"></i>
                                <i class="fa fa-star checked"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <a href="#" class="card-name">Wireless Headphone</a>
                            <div class="card-price">Rs. 110.99</div>
                            <div class="card-actions">
                                <button class="btn-add-cart">
                                    <i class="fa-solid fa-cart-shopping" style="font-size:13px;"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <section class="my-5">
        <div class="container">
            <hr class="pd-divider">
            <h2 class="section-title">{{ $reviews ? $reviews->count() : '02' }} Reviews</h2>

            @if($reviews && $reviews->count() > 0)
                @foreach($reviews as $review)
                    <div class="review-item">
                        <div class="review-avatar">{{ substr($review->r_name ?? 'Anonymous', 0, 2) }}</div>
                        <div>
                            <div class="review-header">
                                <div>
                                    <p class="review-name">{{ $review->r_name ?? 'Anonymous' }}</p>
                                    <div class="review-date">{{ $review->created_at ? $review->created_at->format('d M, Y') : '18 Feb, 2026' }}</div>
                                </div>
                                <div>
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="fa fa-star {{ $i <= ($review->r_rating ?? 4) ? 'checked' : '' }}"></span>
                                    @endfor
                                </div>
                            </div>
                            <p class="review-text">{{ $review->r_comment ?? 'Great product! Really helped me during outdoor adventures. The quality exceeded my expectations.' }}</p>
                            <a href="#" class="btn-reply">Reply</a>
                        </div>
                    </div>
                @endforeach
            @else
                {{-- Fallback to static reviews if no reviews found --}}
                <div class="review-item">
                    <div class="review-avatar">JD</div>
                    <div>
                        <div class="review-header">
                            <div>
                                <p class="review-name">John Doe</p>
                                <div class="review-date">18 Feb, 2026</div>
                            </div>
                            <div>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                            </div>
                        </div>
                        <p class="review-text">Great product! Really helped me during outdoor adventures. The quality exceeded my expectations.</p>
                        <a href="#" class="btn-reply">Reply</a>
                    </div>
                </div>

                <div class="review-item">
                    <div class="review-avatar" style="background:#e6f1fb;color:#185fa5;">AD</div>
                    <div>
                        <div class="review-header">
                            <div>
                                <p class="review-name">Alen Doe</p>
                                <div class="review-date">18 Jan, 2026</div>
                            </div>
                            <div>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                            </div>
                        </div>
                        <p class="review-text">Excellent quality and very useful product. Would definitely recommend it to friends and family.</p>
                        <a href="#" class="btn-reply">Reply</a>
                    </div>
                </div>
            @endif

            {{-- ── Add Review Form ── --}}
            <div class="review-form-box">
                <h3 class="section-title" style="margin-bottom:6px;">Write a Review</h3>
                <p style="font-size:13px;color:#888;margin:0 0 18px;">How would you rate this product?</p>

                <div class="rating-pick" id="ratingPick">
                    <span class="fa fa-star" onclick="setRating(1)"></span>
                    <span class="fa fa-star" onclick="setRating(2)"></span>
                    <span class="fa fa-star" onclick="setRating(3)"></span>
                    <span class="fa fa-star" onclick="setRating(4)"></span>
                    <span class="fa fa-star" onclick="setRating(5)"></span>
                </div>

                <form action="{{ route('review.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->p_id }}">
                    <div class="row mb-3">
                        <div class="col-lg-6 mb-3">
                            <input type="text" name="name" class="rf-input" placeholder="Your Name" required>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <input type="email" name="email" class="rf-input" placeholder="Your Email" required>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <textarea name="comment" class="rf-textarea" rows="5" placeholder="Share your experience with this product..." required></textarea>
                        </div>
                        <input type="hidden" name="rating" id="ratingValue" value="5">
                        <div>
                            <button type="submit" class="btn-pd-buy" style="width:auto;padding:13px 28px;">
                                Post Review <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </section>

</div>


@push('scripts')
<script>
    // Quantity adjuster
    let qty = 1;
    function adjustQty(delta) {
        qty = Math.max(1, qty + delta);
        document.getElementById('qtyDisplay').textContent = qty;
        const cartQtyInput = document.getElementById('cartQty');
        if (cartQtyInput) cartQtyInput.value = qty;
    }

    // Star rating picker
    let selectedRating = 5;
    function setRating(n) {
        selectedRating = n;
        document.querySelectorAll('#ratingPick .fa-star').forEach(function(star, i) {
            star.classList.toggle('active', i < n);
        });
        const ratingInput = document.getElementById('ratingValue');
        if (ratingInput) ratingInput.value = n;
    }
</script>
@endpush

@endsection