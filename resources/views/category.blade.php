@extends('layouts.main')

@push('title')
    <title>Categories - Gifts Hub</title>
@endpush

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
/* ── Variables ── */
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
    --font-display:    'Playfair Display', serif;
    --font-body:       'DM Sans', sans-serif;
    --transition:      all 0.28s cubic-bezier(0.4, 0, 0.2, 1);

    --gh-dark:       #1a2035;
    --gh-mid:        #3a4a6b;
    --gh-accent:     #c4522a;
    --gh-gold:       #d4956a;
    --gh-bg:         #f7f4f0;
    --gh-card:       #ffffff;
    --gh-border:     rgba(26,32,53,0.20);
    --gh-border-img: rgba(26,32,53,0.12);
    --gh-text:       #1a2035;
    --gh-muted:      #7a7f8e;
    --gh-radius:     16px;
    --gh-shadow:     0 2px 16px rgba(26,32,53,0.10), 0 1px 4px rgba(26,32,53,0.06);
    --gh-shadow-hov: 0 18px 44px rgba(26,32,53,0.16), 0 4px 12px rgba(196,82,42,0.14);
    --gh-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --gh-font-d:     'Cormorant Garamond', Georgia, serif;
    --gh-font-b:     'DM Sans', sans-serif;
}

body { font-family: var(--font-body); background: var(--brand-surface); }

/* ══════════════════════════════════════
   PAGE HEADER  — identical to products
   ══════════════════════════════════════ */
.page-header {
    background: linear-gradient(135deg, var(--brand-dark) 0%, #ffffff 100%);
    padding: 44px 0 40px;
    margin-bottom: 48px;
}
.page-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.68rem;
    font-weight: 600;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--brand-gold);
    background: rgba(212,168,83,0.15);
    padding: 4px 12px;
    border-radius: 30px;
    margin-bottom: 10px;
}
.page-title {
    font-family: var(--font-display);
    font-size: clamp(1.8rem, 4vw, 2.8rem);
    font-weight: 700;
    color: #fff;
    line-height: 1.1;
    margin: 0 0 10px;
}
.page-subtitle {
    color: rgba(255,255,255,0.6);
    font-size: 0.92rem;
    margin: 0;
}

/* ── Filter Bar ── */
.cats-filter-bar {
    background: #ffffff;
    border-bottom: 1px solid rgba(26,32,53,0.08);
    padding: 14px 0;
    box-shadow: 0 2px 10px rgba(26,32,53,0.05);
}
.cats-filter-inner {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}
.cats-search-wrap {
    position: relative;
    flex: 1;
    min-width: 200px;
    max-width: 340px;
}
.cats-search-wrap i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gh-muted);
    font-size: 0.82rem;
    pointer-events: none;
}
.cats-search-input {
    width: 100%;
    height: 40px;
    border-radius: 50px;
    border: 1.5px solid rgba(26,32,53,0.14);
    background: var(--gh-bg);
    padding: 0 16px 0 40px;
    font-family: var(--gh-font-b);
    font-size: 0.875rem;
    color: var(--gh-text);
    outline: none;
    transition: var(--gh-transition);
}
.cats-search-input:focus {
    border-color: var(--gh-accent);
    background: #fff;
    box-shadow: 0 0 0 3px rgba(196,82,42,0.10);
}
.cats-sort-label {
    font-family: var(--gh-font-b);
    font-size: 0.79rem;
    color: var(--gh-muted);
    font-weight: 500;
    letter-spacing: 0.04em;
    white-space: nowrap;
}
.cats-sort-select {
    height: 40px;
    border-radius: 50px;
    border: 1.5px solid rgba(26,32,53,0.14);
    background: var(--gh-bg) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%237a7f8e' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") no-repeat right 14px center;
    padding: 0 36px 0 16px;
    font-family: var(--gh-font-b);
    font-size: 0.875rem;
    color: var(--gh-text);
    outline: none;
    cursor: pointer;
    appearance: none;
    transition: var(--gh-transition);
}
.cats-sort-select:focus { border-color: var(--gh-accent); }
.cats-result-count {
    margin-left: auto;
    font-family: var(--gh-font-b);
    font-size: 0.80rem;
    color: var(--gh-muted);
    font-weight: 500;
}

/* ── Section ── */
.cats-section {
    background: var(--gh-bg);
    padding: 44px 0 80px;
}

/* ── Grid ── */
.cats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 22px;
}
@media (max-width: 1199px) { .cats-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 767px)  { .cats-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; } }
@media (max-width: 420px)  { .cats-grid { grid-template-columns: 1fr; } }

/* ── Category Card ── */
.category-card {
    background: var(--gh-card);
    border-radius: var(--gh-radius);
    border: 2px solid var(--gh-border);
    box-shadow: var(--gh-shadow);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    text-decoration: none;
    color: inherit;
    transition: var(--gh-transition);
    position: relative;
    height: 100%;
    animation: ghFadeUp 0.45s ease both;
}
.category-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--gh-shadow-hov);
    border-color: var(--gh-accent);
    color: inherit;
    text-decoration: none;
}
.category-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--gh-accent), var(--gh-gold));
    opacity: 0;
    transition: var(--gh-transition);
    z-index: 2;
}
.category-card:hover::before { opacity: 1; }

/* stagger delays */
.category-card:nth-child(1)  { animation-delay: .04s; }
.category-card:nth-child(2)  { animation-delay: .09s; }
.category-card:nth-child(3)  { animation-delay: .14s; }
.category-card:nth-child(4)  { animation-delay: .19s; }
.category-card:nth-child(5)  { animation-delay: .24s; }
.category-card:nth-child(6)  { animation-delay: .29s; }
.category-card:nth-child(7)  { animation-delay: .34s; }
.category-card:nth-child(8)  { animation-delay: .38s; }
.category-card:nth-child(9)  { animation-delay: .42s; }
.category-card:nth-child(10) { animation-delay: .46s; }
.category-card:nth-child(11) { animation-delay: .50s; }
.category-card:nth-child(12) { animation-delay: .54s; }

/* ── Image Area ── */
.cat-img-wrap {
    width: 100%;
    aspect-ratio: 4 / 3;
    background: linear-gradient(145deg, #f7f2ec 0%, #ede5da 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.8rem;
    color: var(--gh-accent);
    position: relative;
    overflow: hidden;
    border-bottom: 2px solid var(--gh-border-img);
    transition: var(--gh-transition);
}
.cat-img-wrap::after {
    content: '';
    position: absolute;
    width: 76px; height: 76px;
    border-radius: 50%;
    background: rgba(196,82,42,0.09);
    transition: var(--gh-transition);
    z-index: 1;
}
.cat-img-wrap i {
    position: relative;
    z-index: 2;
    transition: var(--gh-transition);
}
.cat-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    inset: 0;
    transition: var(--gh-transition);
}
.category-card:hover .cat-img-wrap { background: linear-gradient(145deg, #f0e8de 0%, #e5d8ca 100%); }
.category-card:hover .cat-img-wrap i { transform: scale(1.12); color: var(--gh-dark); }
.category-card:hover .cat-img-wrap img { transform: scale(1.06); }
.category-card:hover .cat-img-wrap::after { width: 100px; height: 100px; background: rgba(196,82,42,0.14); }

/* ── Card Info ── */
.cat-info {
    padding: 15px 18px 18px;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 3px;
}
.cat-name {
    font-family: var(--gh-font-d);
    font-size: 1.08rem;
    font-weight: 600;
    color: var(--gh-text);
    margin: 0 0 2px;
    line-height: 1.3;
    letter-spacing: -0.01em;
}
.cat-count {
    font-family: var(--gh-font-b);
    font-size: 0.76rem;
    color: var(--gh-muted);
    font-weight: 400;
    letter-spacing: 0.02em;
}
.cat-arrow {
    margin-top: auto;
    padding-top: 10px;
    display: flex;
    align-items: center;
    gap: 5px;
    font-family: var(--gh-font-b);
    font-size: 0.73rem;
    font-weight: 600;
    color: var(--gh-accent);
    letter-spacing: 0.05em;
    text-transform: uppercase;
    opacity: 0;
    transform: translateX(-4px);
    transition: var(--gh-transition);
}
.cat-arrow i { font-size: 0.70rem; }
.category-card:hover .cat-arrow { opacity: 1; transform: translateX(0); }

/* ── Empty State ── */
.cats-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 72px 24px;
    background: var(--gh-card);
    border-radius: var(--gh-radius);
    border: 2px dashed rgba(26,32,53,0.14);
}
.cats-empty i { font-size: 3rem; color: rgba(26,32,53,0.18); display: block; margin-bottom: 14px; }
.cats-empty p  { font-family: var(--gh-font-b); font-size: 1rem; color: var(--gh-muted); margin: 0; }

/* ── Animation ── */
@keyframes ghFadeUp {
    from { opacity: 0; transform: translateY(22px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Responsive ── */
@media (max-width: 767px) {
    .page-header { padding: 40px 0 36px; margin-bottom: 0; }
    .cats-result-count { display: none; }
    .cats-search-wrap { max-width: 100%; }
}
</style>
@endpush

@section('content')

{{-- ── Page header — identical markup & classes to products page ── --}}
<div class="page-header">
    <div class="container">
        <h1 class="page-title">All Categories</h1>
        <p class="page-subtitle">Browse our curated gift collections for every occasion.</p>
    </div>
</div>

{{-- ── Filter Bar ── --}}
<div class="cats-filter-bar">
    <div class="container">
        <div class="cats-filter-inner">
            <div class="cats-search-wrap">
                <i class="fas fa-search"></i>
                <input
                    type="text"
                    id="catSearch"
                    class="cats-search-input"
                    placeholder="Search categories…"
                    autocomplete="off"
                >
            </div>

            <span class="cats-sort-label">Sort by</span>
            <select id="catSort" class="cats-sort-select">
                <option value="default">Default</option>
                <option value="name-asc">Name A–Z</option>
                <option value="name-desc">Name Z–A</option>
                <option value="products-desc">Most Products</option>
                <option value="products-asc">Fewest Products</option>
            </select>

            <span class="cats-result-count" id="catCount">
                Showing {{ $categories->count() }} {{ Str::plural('category', $categories->count()) }}
            </span>
        </div>
    </div>
</div>

{{-- ── Categories Grid ── --}}
<section class="cats-section">
    <div class="container">
        <div class="cats-grid" id="catsGrid">

            @forelse($categories as $category)
            <a
                href="{{ route('categories.products', ['slug' => Str::slug($category->c_name)]) }}"
                class="category-card"
                data-name="{{ strtolower($category->c_name) }}"
                data-count="{{ $category->products_count }}"
            >
                <div class="cat-img-wrap">
                    @if(!empty($category->image))
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->c_name }}" loading="lazy">
                    @else
                        <i class="fa-solid fa-gift"></i>
                    @endif
                </div>

                <div class="cat-info">
                    <h6 class="cat-name">{{ $category->c_name }}</h6>
                    <small class="cat-count">
                        {{ number_format($category->products_count) }} {{ Str::plural('product', $category->products_count) }}
                    </small>
                    <div class="cat-arrow">
                        Browse <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </a>

            @empty
            <div class="cats-empty">
                <i class="fas fa-layer-group"></i>
                <p>No categories available yet. Check back soon!</p>
            </div>
            @endforelse

        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
(function () {
    const grid   = document.getElementById('catsGrid');
    const search = document.getElementById('catSearch');
    const sort   = document.getElementById('catSort');
    const count  = document.getElementById('catCount');

    function update() {
        const q = search.value.trim().toLowerCase();
        const s = sort.value;
        let cards = Array.from(grid.querySelectorAll('.category-card'));
        let visible = cards.filter(c => !q || (c.dataset.name || '').includes(q));

        cards.forEach(c => c.style.display = 'none');

        if (s === 'name-asc')           visible.sort((a, b) => a.dataset.name.localeCompare(b.dataset.name));
        else if (s === 'name-desc')     visible.sort((a, b) => b.dataset.name.localeCompare(a.dataset.name));
        else if (s === 'products-desc') visible.sort((a, b) => (+b.dataset.count) - (+a.dataset.count));
        else if (s === 'products-asc')  visible.sort((a, b) => (+a.dataset.count) - (+b.dataset.count));

        visible.forEach(c => { grid.appendChild(c); c.style.display = ''; });

        if (count) {
            const n = visible.length;
            count.textContent = n === 1 ? 'Showing 1 category' : `Showing ${n} categories`;
        }
    }

    search.addEventListener('input', update);
    sort.addEventListener('change', update);
})();
</script>
@endpush