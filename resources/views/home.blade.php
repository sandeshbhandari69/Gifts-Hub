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
.category-card:hover .cat-img-wrap::after { background: rgba(196,82,42,0.06); }
.category-card .cat-img-wrap::after { content: ''; position: absolute; inset: 0; background: rgba(196,82,42,0); transition: var(--transition); }
.category-card .cat-info { padding: 14px 18px 18px; }
.category-card .cat-name { font-size: 0.95rem; font-weight: 600; color: var(--text-primary); margin: 0 0 3px; }
.category-card .cat-count { font-size: 0.78rem; color: var(--text-muted); }

/* ── Grid / utils ── */
.products-grid { row-gap: 24px; --bs-gutter-x: 20px; }
.empty-state { text-align: center; padding: 60px 20px; color: var(--text-muted); }
.empty-state i { font-size: 2.5rem; margin-bottom: 12px; display: block; opacity: 0.4; }
.section-divider { height: 1px; background: var(--border-color); margin: 0 var(--bs-gutter-x, 12px); }

/* ══════════════════════════════════════════
   HERO SLIDER
══════════════════════════════════════════ */
#heroSlider {
    position: relative !important;
    height: 92vh !important;
    min-height: 520px !important;
    overflow: hidden !important;
    background: #0d1117 !important;
    font-family: 'DM Sans', sans-serif;
}
#heroSlider .slide { position: absolute !important; top: 0 !important; right: 0 !important; bottom: 0 !important; left: 0 !important; opacity: 0 !important; transition: opacity 0.9s ease, transform 1.2s ease !important; transform: scale(1.04) !important; display: flex !important; align-items: center !important; pointer-events: none !important; z-index: 1 !important; }
#heroSlider .slide.active { opacity: 1 !important; transform: scale(1) !important; z-index: 2 !important; pointer-events: auto !important; }
#heroSlider .slide-bg { position: absolute !important; top: 0 !important; right: 0 !important; bottom: 0 !important; left: 0 !important; background-size: cover !important; background-position: center !important; background-repeat: no-repeat !important; }
#heroSlider .slide-bg::after { content: '' !important; position: absolute !important; top: 0 !important; right: 0 !important; bottom: 0 !important; left: 0 !important; background: linear-gradient(105deg, rgba(10,14,20,0.92) 0%, rgba(10,14,20,0.55) 55%, rgba(10,14,20,0.15) 100%) !important; }

/* ── UPDATED SLIDE COLORS — dark charcoal left → teal/blue right ── */
#heroSlider .slide:nth-child(1) .slide-bg {
    background-image: radial-gradient(ellipse at 75% 50%, #0d4a4a 0%, #0a2a35 40%, #0d1117 100%);
}
#heroSlider .slide:nth-child(2) .slide-bg {
    background-image: radial-gradient(ellipse at 70% 50%, #0a3d4a 0%, #072535 40%, #0d1117 100%);
}
#heroSlider .slide:nth-child(3) .slide-bg {
    background-image: radial-gradient(ellipse at 72% 48%, #0b4040 0%, #0a2030 40%, #0d1117 100%);
}

#heroSlider .slide-content { position: relative !important; z-index: 3 !important; padding: 0 6vw !important; max-width: 680px !important; }
#heroSlider .slide-eyebrow { display: inline-flex !important; align-items: center !important; gap: 10px !important; font-size: 0.70rem !important; font-weight: 600 !important; letter-spacing: 0.22em !important; text-transform: uppercase !important; color: #d4a853 !important; margin-bottom: 18px !important; opacity: 0 !important; transform: translateY(20px) !important; transition: opacity 0.6s ease 0.30s, transform 0.6s ease 0.30s !important; }
#heroSlider .slide-eyebrow::before { content: '' !important; display: block !important; width: 30px !important; height: 1px !important; background: #d4a853 !important; }
#heroSlider .slide.active .slide-eyebrow { opacity: 1 !important; transform: translateY(0) !important; }
#heroSlider .slide-title { font-family: 'Playfair Display', serif !important; font-size: clamp(2.6rem, 5.5vw, 4.8rem) !important; font-weight: 700 !important; color: #ffffff !important; line-height: 1.1 !important; margin-bottom: 18px !important; opacity: 0 !important; transform: translateY(28px) !important; transition: opacity 0.7s ease 0.45s, transform 0.7s ease 0.45s !important; }
#heroSlider .slide.active .slide-title { opacity: 1 !important; transform: translateY(0) !important; }
#heroSlider .slide-title em { font-style: italic !important; color: #e8896a !important; }
#heroSlider .slide-desc { font-size: 1rem !important; color: rgba(255,255,255,0.72) !important; line-height: 1.8 !important; max-width: 420px !important; margin-bottom: 32px !important; font-weight: 300 !important; opacity: 0 !important; transform: translateY(20px) !important; transition: opacity 0.6s ease 0.60s, transform 0.6s ease 0.60s !important; }
#heroSlider .slide.active .slide-desc { opacity: 1 !important; transform: translateY(0) !important; }
#heroSlider .slide-actions { display: flex !important; gap: 12px !important; align-items: center !important; flex-wrap: wrap !important; opacity: 0 !important; transform: translateY(20px) !important; transition: opacity 0.6s ease 0.75s, transform 0.6s ease 0.75s !important; }
#heroSlider .slide.active .slide-actions { opacity: 1 !important; transform: translateY(0) !important; }
.btn-slide-primary { display: inline-flex !important; align-items: center !important; gap: 8px !important; padding: 13px 30px !important; background: #c4522a !important; color: #fff !important; font-family: 'DM Sans', sans-serif !important; font-weight: 600 !important; font-size: 0.88rem !important; text-decoration: none !important; border-radius: 50px !important; border: none !important; cursor: pointer !important; transition: background 0.3s, transform 0.3s !important; }
.btn-slide-primary:hover { background: #e8896a !important; transform: translateY(-2px) !important; color: #fff !important; }
.btn-slide-ghost { display: inline-flex !important; align-items: center !important; gap: 8px !important; padding: 13px 26px !important; background: transparent !important; color: rgba(255,255,255,0.85) !important; font-family: 'DM Sans', sans-serif !important; font-weight: 500 !important; font-size: 0.88rem !important; text-decoration: none !important; border-radius: 50px !important; border: 1.5px solid rgba(255,255,255,0.35) !important; transition: border-color 0.3s, background 0.3s !important; cursor: pointer !important; }
.btn-slide-ghost:hover { border-color: rgba(255,255,255,0.75) !important; background: rgba(255,255,255,0.09) !important; color: #fff !important; }
#heroSlider .slider-controls { position: absolute !important; bottom: 36px !important; left: 6vw !important; z-index: 20 !important; display: flex !important; align-items: center !important; gap: 18px !important; }
#heroSlider .slider-dots { display: flex !important; gap: 8px !important; }
#heroSlider .slider-dot { width: 26px !important; height: 3px !important; background: rgba(255,255,255,0.30) !important; border-radius: 2px !important; cursor: pointer !important; border: none !important; padding: 0 !important; transition: width 0.4s ease, background 0.4s ease !important; }
#heroSlider .slider-dot.active { background: #d4a853 !important; width: 46px !important; }
#heroSlider .slider-arrows { display: flex !important; gap: 8px !important; }
#heroSlider .slider-arrow { width: 40px !important; height: 40px !important; border-radius: 50% !important; border: 1.5px solid rgba(255,255,255,0.35) !important; background: transparent !important; color: #fff !important; font-size: 13px !important; display: flex !important; align-items: center !important; justify-content: center !important; cursor: pointer !important; transition: background 0.3s, border-color 0.3s !important; }
#heroSlider .slider-arrow:hover { background: #c4522a !important; border-color: #c4522a !important; }
#heroSlider .scroll-hint { position: absolute !important; bottom: 44px !important; right: 5vw !important; z-index: 10 !important; display: flex !important; flex-direction: column !important; align-items: center !important; gap: 8px !important; color: rgba(255,255,255,0.35) !important; font-size: 0.60rem !important; letter-spacing: 0.18em !important; text-transform: uppercase !important; }
#heroSlider .scroll-line { width: 1px !important; height: 38px !important; background: rgba(255,255,255,0.22) !important; animation: scrollAnim 2s ease-in-out infinite !important; }
@keyframes scrollAnim { 0% { transform: scaleY(0); transform-origin: top; } 49% { transform: scaleY(1); transform-origin: top; } 50% { transform-origin: bottom; } 100% { transform: scaleY(0); transform-origin: bottom; } }

/* Trust bar */
.trust-bar { background: #1c1917 !important; padding: 12px 0 !important; overflow: hidden !important; }
.trust-track { display: flex !important; gap: 56px !important; animation: marquee 22s linear infinite !important; white-space: nowrap !important; }
.trust-item { display: flex !important; align-items: center !important; gap: 9px !important; font-size: 0.74rem !important; font-weight: 500 !important; letter-spacing: 0.07em !important; color: rgba(255,255,255,0.55) !important; flex-shrink: 0 !important; font-family: 'DM Sans', sans-serif !important; }
.trust-item i { color: #d4a853 !important; }
@keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

@media (max-width: 768px) {
    #heroSlider { height: 78vh !important; min-height: 460px !important; }
    #heroSlider .slide-title { font-size: 2.2rem !important; }
    #heroSlider .scroll-hint { display: none !important; }
    .section-header { flex-wrap: wrap; }
}
@media (max-width: 480px) {
    #heroSlider { height: 85vh !important; }
    #heroSlider .slide-title { font-size: 1.9rem !important; }
    .btn-slide-primary, .btn-slide-ghost { padding: 11px 20px !important; font-size: 0.80rem !important; }
}
</style>

{{-- ══════ HERO SLIDER ══════ --}}
<section id="heroSlider">
    <div class="slide active">
        <div class="slide-bg" {{-- style="background-image:url('{{ asset('assets/images/hero/slide1.jpg') }}')" --}}></div>
        <div class="slide-content">
            <div class="slide-eyebrow">Curated Gifts</div>
            <h1 class="slide-title">The Perfect <em>Gift</em><br>Finds You</h1>
            <p class="slide-desc">Discover curated gifts for every occasion, handpicked to create moments of joy and celebration.</p>
            <div class="slide-actions">
                <a href="{{ route('categories') }}" class="btn-slide-primary">Explore Now &nbsp;<i class="fa-solid fa-arrow-right"></i></a>
                <a href="#products-section" class="btn-slide-ghost"><i class="fa-solid fa-star"></i>&nbsp; Top Deals</a>
            </div>
        </div>
    </div>
    <div class="slide">
        <div class="slide-bg" {{-- style="background-image:url('{{ asset('assets/images/hero/slide2.jpg') }}')" --}}></div>
        <div class="slide-content">
            <div class="slide-eyebrow">New Arrivals</div>
            <h1 class="slide-title">Give <em>Joy</em>,<br>Not Just Gifts</h1>
            <p class="slide-desc">From birthdays to anniversaries — every celebration deserves something extraordinary and memorable.</p>
            <div class="slide-actions">
                <a href="{{ route('categories') }}" class="btn-slide-primary">Shop Now &nbsp;<i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <div class="slide">
        <div class="slide-bg" {{-- style="background-image:url('{{ asset('assets/images/hero/slide3.jpg') }}')" --}}></div>
        <div class="slide-content">
            <div class="slide-eyebrow">Special Deals</div>
            <h1 class="slide-title">Celebrate<br><em>Every</em> Moment</h1>
            <p class="slide-desc">Explore our exclusive collection of premium gifts, thoughtfully designed to make every occasion unforgettable.</p>
            <div class="slide-actions">
                <a href="{{ route('categories') }}" class="btn-slide-primary">View Categories &nbsp;<i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <div class="slider-controls">
        <div class="slider-dots">
            <button class="slider-dot active" data-slide="0" aria-label="Slide 1"></button>
            <button class="slider-dot"        data-slide="1" aria-label="Slide 2"></button>
            <button class="slider-dot"        data-slide="2" aria-label="Slide 3"></button>
        </div>
        <div class="slider-arrows">
            <button class="slider-arrow" id="prevSlide" aria-label="Previous"><i class="fa-solid fa-chevron-left"></i></button>
            <button class="slider-arrow" id="nextSlide" aria-label="Next"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
    </div>
    <div class="scroll-hint">
        <div class="scroll-line"></div>
        <span>Scroll</span>
    </div>
</section>

<script>
(function () {
    var slider = document.getElementById('heroSlider');
    if (!slider) return;
    var slides = slider.querySelectorAll('.slide'), dots = slider.querySelectorAll('.slider-dot'), current = 0, timer = null;
    function goTo(n) { slides[current].classList.remove('active'); dots[current].classList.remove('active'); current = (n + slides.length) % slides.length; slides[current].classList.add('active'); dots[current].classList.add('active'); }
    function next() { goTo(current + 1); }
    function prev() { goTo(current - 1); }
    function startAuto() { clearInterval(timer); timer = setInterval(next, 5000); }
    document.getElementById('nextSlide').addEventListener('click', function(){ next(); startAuto(); });
    document.getElementById('prevSlide').addEventListener('click', function(){ prev(); startAuto(); });
    dots.forEach(function(dot){ dot.addEventListener('click', function(){ goTo(parseInt(this.dataset.slide,10)); startAuto(); }); });
    var tx = 0;
    slider.addEventListener('touchstart', function(e){ tx = e.touches[0].clientX; }, {passive:true});
    slider.addEventListener('touchend',   function(e){ var d=tx-e.changedTouches[0].clientX; if(Math.abs(d)>50){d>0?next():prev();startAuto();} }, {passive:true});
    slider.addEventListener('mouseenter', function(){ clearInterval(timer); });
    slider.addEventListener('mouseleave', startAuto);
    document.addEventListener('keydown', function(e){ if(e.key==='ArrowRight'){next();startAuto();} if(e.key==='ArrowLeft'){prev();startAuto();} });
    startAuto();
})();
</script>

{{-- Trust bar --}}
<div class="trust-bar">
    <div class="trust-track">
        <div class="trust-item"><i class="fa-solid fa-truck-fast"></i> Free Delivery Over Rs. 5000</div>
        <div class="trust-item"><i class="fa-solid fa-shield-halved"></i> Secure Payments</div>
        <div class="trust-item"><i class="fa-solid fa-gift"></i> Gift Wrapping Available</div>
        <div class="trust-item"><i class="fa-solid fa-headset"></i> 24/7 Support</div>
        <div class="trust-item"><i class="fa-solid fa-truck-fast"></i> Free Delivery Over Rs. 5000</div>
        <div class="trust-item"><i class="fa-solid fa-shield-halved"></i> Secure Payments</div>
        <div class="trust-item"><i class="fa-solid fa-gift"></i> Gift Wrapping Available</div>
        <div class="trust-item"><i class="fa-solid fa-headset"></i> 24/7 Support</div>
    </div>
</div>


{{-- ══════ TOP DEALS ══════ --}}
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


{{-- ══════ GIFT CATEGORIES ══════ --}}
<div class="container"><div class="section-divider"></div></div>
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