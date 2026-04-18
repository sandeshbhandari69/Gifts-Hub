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
        gap: 16px;
        padding: 24px 0;
        align-items: start;
    }
    @media (max-width: 768px) {
        .pd-hero { grid-template-columns: 1fr; gap: 20px; }
    }

    /* ── Image Panel ── */
    .pd-img-panel {
        background: #f7f9f5;
        border-radius: 16px;
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        border: 1px solid #e5ede7;
        max-height: 400px;
    }
    .pd-img-panel img {
        width: 85%;
        max-height: 85%;
        object-fit: contain;
        border-radius: 8px;
    }
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
    .pd-info { display: flex; flex-direction: column; gap: 12px; }
    .pd-category {
        font-size: 12px;
        font-weight: 600;
        color: #2d6a4f;
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    .pd-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem;
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
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d6a4f;
    }
    .pd-desc { font-size: 0.88rem; color: #555; line-height: 1.6; }

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
        border-radius: 12px;
        padding: 20px 24px;
        margin: 24px 0;
        border: 1px solid #e5ede7;
    }
    .pd-desc-box p { font-size: 0.94rem; color: #555; line-height: 1.8; margin: 0; }
    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 16px;
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
        grid-template-columns: 44px 1fr;
        gap: 12px;
        padding: 16px 0;
        border-bottom: 1px solid #eaeaea;
        align-items: start;
    }
    .review-avatar {
        width: 36px; height: 36px;
        border-radius: 50%;
        background: #eaf3de;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 12px;
        color: #2d6a4f;
        flex-shrink: 0;
    }
    .review-header { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 6px; }
    .btn-delete-review {
        font-size: 11px; padding: 3px 10px;
        background: #dc3545; color: white;
        border: none; border-radius: 12px; cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        text-decoration: none; display: inline-block;
        transition: background 0.15s;
    }
    .btn-delete-review:hover { background: #c82333; }
    .btn-edit-review {
        font-size: 11px; padding: 3px 10px;
        background: #007bff; color: white;
        border: none; border-radius: 12px; cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        text-decoration: none; display: inline-block;
        transition: background 0.15s;
        margin-right: 5px;
    }
    .btn-edit-review:hover { background: #0056b3; }
    .edit-review-form {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        margin-top: 10px;
        display: none;
    }
    .edit-review-form.active { display: block; }
    .edit-review-form .form-group {
        margin-bottom: 12px;
    }
    .edit-review-form label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #555;
        margin-bottom: 5px;
    }
    .edit-review-form input, .edit-review-form textarea {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        box-sizing: border-box;
    }
    .edit-review-form textarea {
        min-height: 80px;
        resize: vertical;
    }
    .edit-actions {
        display: flex;
        gap: 8px;
        margin-top: 10px;
    }
    .btn-save-edit, .btn-cancel-edit {
        padding: 6px 15px;
        border: none; border-radius: 6px;
        font-size: 12px; font-weight: 600;
        cursor: pointer;
        transition: background 0.15s;
    }
    .btn-save-edit {
        background: #28a745; color: white;
    }
    .btn-save-edit:hover { background: #218838; }
    .btn-cancel-edit {
        background: #6c757d; color: white;
    }
    .btn-cancel-edit:hover { background: #5a6268; }
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

    /* ── Reply Section ── */
    .reply-section {
        margin-top: 12px;
        padding-left: 12px;
        border-left: 2px solid #e5ede7;
        display: none;
    }
    .reply-section.active { display: block; }
    .reply-item {
        padding: 8px 0;
        font-size: 0.85rem;
        color: #666;
        line-height: 1.5;
    }
    .reply-author {
        font-weight: 600;
        color: #2d6a4f;
        margin-bottom: 2px;
    }
    .reply-form {
        margin-top: 8px;
        display: flex;
        gap: 8px;
        align-items: flex-start;
    }
    .reply-input {
        flex: 1;
        padding: 8px 12px;
        border: 1px solid #d0ddd5;
        border-radius: 8px;
        font-size: 13px;
        font-family: 'DM Sans', sans-serif;
        resize: none;
        min-height: 36px;
        max-height: 80px;
    }
    .reply-input:focus {
        outline: none;
        border-color: #2d6a4f;
        box-shadow: 0 0 0 2px rgba(45,106,79,0.1);
    }
    .btn-reply-submit {
        padding: 8px 16px;
        background: #2d6a4f;
        color: white;
        border: none;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-reply-submit:hover { background: #1b4332; }
    .btn-cancel-reply {
        padding: 8px 16px;
        background: transparent;
        color: #666;
        border: 1px solid #ddd;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-cancel-reply:hover { background: #f5f5f5; }

    /* ── Review Form ── */
    .review-form-box {
        background: #f7f9f5;
        border-radius: 12px;
        padding: 24px;
        margin-top: 32px;
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

    <section class="my-5">
        <div class="container">
            <hr class="pd-divider">
            <h2 class="section-title">{{ $reviews ? $reviews->count() : '0' }} Reviews</h2>

            @if($reviews && $reviews->count() > 0)
                @foreach($reviews as $review)
                    <div class="review-item">
                        <div class="review-avatar">{{ substr($review['name'] ?? 'Anonymous', 0, 2) }}</div>
                        <div>
                            <div class="review-header">
                                <div>
                                    <p class="review-name">{{ $review['name'] ?? 'Anonymous' }}</p>
                                    <div class="review-date">{{ $review['created_at'] ?? '18 Feb, 2026' }}</div>
                                </div>
                                <div>
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="fa fa-star {{ $i <= ($review['rating'] ?? 4) ? 'checked' : '' }}"></span>
                                    @endfor
                                </div>
                            </div>
                            <p class="review-text">{{ $review['comment'] ?? 'Great product! Really helped me during outdoor adventures. The quality exceeded my expectations.' }}</p>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <a href="#" class="btn-reply" onclick="toggleReplyForm('{{ $review['id'] ?? uniqid() }}', event)">Reply</a>
                                <a href="#" class="btn-edit-review" onclick="toggleEditForm('{{ $review['id'] ?? uniqid() }}', event)">Edit</a>
                                <form action="{{ route('review.delete') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="review_id" value="{{ $review['id'] ?? uniqid() }}">
                                    <button type="submit" class="btn-delete-review" onclick="return confirm('Are you sure you want to delete this review?')">Delete</button>
                                </form>
                            </div>
                            <div class="edit-review-form" id="edit-form-{{ $review['id'] ?? uniqid() }}">
                                <form action="{{ route('review.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="review_id" value="{{ $review['id'] ?? uniqid() }}">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" value="{{ $review['name'] ?? '' }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" value="{{ $review['email'] ?? '' }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Rating</label>
                                        <select name="rating" style="width: 100%; padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; font-family: 'DM Sans', sans-serif; font-size: 13px;">
                                            <option value="1" {{ ($review['rating'] ?? 5) == 1 ? 'selected' : '' }}>1 Star</option>
                                            <option value="2" {{ ($review['rating'] ?? 5) == 2 ? 'selected' : '' }}>2 Stars</option>
                                            <option value="3" {{ ($review['rating'] ?? 5) == 3 ? 'selected' : '' }}>3 Stars</option>
                                            <option value="4" {{ ($review['rating'] ?? 5) == 4 ? 'selected' : '' }}>4 Stars</option>
                                            <option value="5" {{ ($review['rating'] ?? 5) == 5 ? 'selected' : '' }}>5 Stars</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Comment</label>
                                        <textarea name="comment" required>{{ $review['comment'] ?? '' }}</textarea>
                                    </div>
                                    <div class="edit-actions">
                                        <button type="submit" class="btn-save-edit">Save Changes</button>
                                        <button type="button" class="btn-cancel-edit" onclick="toggleEditForm('{{ $review['id'] ?? uniqid() }}', event)">Cancel</button>
                                    </div>
                                </form>
                            </div>
                            <div class="reply-section" id="reply-section-{{ $review['id'] ?? uniqid() }}">
                                @if(isset($review->replies) && count($review->replies) > 0)
                                    @foreach($review->replies as $reply)
                                        <div class="reply-item">
                                            <div class="reply-author">{{ $reply->author ?? 'Admin' }}</div>
                                            <div>{{ $reply->message ?? 'Thank you for your feedback!' }}</div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="reply-form">
                                    <textarea class="reply-input" placeholder="Write a reply..." id="reply-input-{{ $review['id'] ?? uniqid() }}"></textarea>
                                    <div>
                                        <button class="btn-reply-submit" onclick="submitReply('{{ $review['id'] ?? uniqid() }}', '{{ $review['name'] ?? 'Anonymous' }}')">Post</button>
                                        <button class="btn-cancel-reply" onclick="toggleReplyForm('{{ $review['id'] ?? uniqid() }}', event)">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div style="text-align: center; padding: 40px 0; color: #888;">
                    <p style="font-size: 16px; margin-bottom: 8px;">No reviews yet.</p>
                    <p style="font-size: 14px;">Be the first to review this product!</p>
                </div>
            @endif

            {{-- Add Review Form --}}
            <div class="review-form-box">
                @if(session('success'))
                    <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                        {{ session('success') }}
                    </div>
                @endif
                
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
                    <input type="hidden" name="product_id" value="{{ $product->p_id ?? '1' }}">
                    <input type="hidden" name="product_name" value="{{ $product->p_name ?? 'Product' }}">
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

    // Initialize rating on page load
    document.addEventListener('DOMContentLoaded', function() {
        setRating(5); // Set default rating to 5 stars
    });

    // Reply functionality
    function toggleReplyForm(reviewId, event) {
        event.preventDefault();
        const replySection = document.getElementById('reply-section-' + reviewId);
        if (replySection) {
            replySection.classList.toggle('active');
            // Clear input when closing
            if (!replySection.classList.contains('active')) {
                const input = document.getElementById('reply-input-' + reviewId);
                if (input) input.value = '';
            }
        }
    }

    // Edit functionality
    function toggleEditForm(reviewId, event) {
        event.preventDefault();
        const editForm = document.getElementById('edit-form-' + reviewId);
        if (editForm) {
            editForm.classList.toggle('active');
        }
    }

    function submitReply(reviewId, reviewAuthor) {
        const input = document.getElementById('reply-input-' + reviewId);
        const replyText = input ? input.value.trim() : '';
        
        if (!replyText) {
            alert('Please write a reply before submitting.');
            return;
        }
        
        // Store reply in session (simulate backend functionality)
        const replies = JSON.parse(sessionStorage.getItem('replies') || '{}');
        if (!replies[reviewId]) {
            replies[reviewId] = [];
        }
        
        replies[reviewId].push({
            author: 'Admin',
            message: replyText,
            review_author: reviewAuthor,
            created_at: new Date().toISOString()
        });
        
        sessionStorage.setItem('replies', JSON.stringify(replies));
        
        // Add reply to DOM
        addReplyToDOM(reviewId, 'Admin', replyText);
        
        // Clear input and close form
        input.value = '';
        document.getElementById('reply-section-' + reviewId).classList.remove('active');
        
        // Show success message
        showSuccessMessage('Reply posted successfully!');
    }

    function addReplyToDOM(reviewId, author, message) {
        const replySection = document.getElementById('reply-section-' + reviewId);
        if (!replySection) return;
        
        const replyForm = replySection.querySelector('.reply-form');
        const replyItem = document.createElement('div');
        replyItem.className = 'reply-item';
        replyItem.innerHTML = `
            <div class="reply-author">${author}</div>
            <div>${message}</div>
        `;
        
        replySection.insertBefore(replyItem, replyForm);
    }

    function deleteReview(reviewId, event) {
        event.preventDefault();
        
        if (!confirm('Are you sure you want to delete this review?')) {
            return;
        }
        
        // Find and remove the review element
        const reviewItem = event.target.closest('.review-item');
        if (reviewItem) {
            reviewItem.remove();
            showSuccessMessage('Review deleted successfully!');
            
            // Also remove from session storage
            const reviews = JSON.parse(sessionStorage.getItem('reviews') || '[]');
            const updatedReviews = reviews.filter(review => review.id !== reviewId);
            sessionStorage.setItem('reviews', JSON.stringify(updatedReviews));
        }
    }

    function showSuccessMessage(message) {
        // Create a simple success message
        const successDiv = document.createElement('div');
        successDiv.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #2d6a4f;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            z-index: 1000;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        `;
        successDiv.textContent = message;
        document.body.appendChild(successDiv);
        
        // Remove after 3 seconds
        setTimeout(() => {
            if (successDiv.parentNode) {
                successDiv.parentNode.removeChild(successDiv);
            }
        }, 3000);
    }

    // Load existing replies on page load
    document.addEventListener('DOMContentLoaded', function() {
        const replies = JSON.parse(sessionStorage.getItem('replies') || '{}');
        Object.keys(replies).forEach(reviewId => {
            replies[reviewId].forEach(reply => {
                addReplyToDOM(reviewId, reply.author, reply.message);
            });
        });
    });
</script>
@endpush

@endsection