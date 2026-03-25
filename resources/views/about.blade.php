@extends('layouts.main')

@push('title')
    <title>About Us - Gifts Hub</title>
@endpush

@section('content')

{{-- Google Fonts loaded directly inside content so it always works --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
/* ── Reset scoped to about page ── */
.ab-wrap, .ab-wrap * { box-sizing: border-box; }

/* ── CSS Variables ── */
.ab-wrap {
    --ink:      #1a1a1a;
    --soft:     #444444;
    --muted:    #999999;
    --accent:   #c4956a;
    --accent-l: #f0e0cf;
    --bg:       #f9f7f4;
    --white:    #ffffff;
    --line:     #e6e0d8;

    background: var(--bg);
    min-height: calc(100vh - 200px);
    padding: 80px 0 110px;
    font-family: 'Outfit', sans-serif;
    color: var(--ink);
}

/* ── Layout container ── */
.ab-inner {
    width: min(960px, 88%);
    margin: 0 auto;
}

/* ────────────────────────────────
   HERO
──────────────────────────────── */
.ab-hero {
    padding-bottom: 64px;
    border-bottom: 1px solid var(--line);
    margin-bottom: 64px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: end;
}

.ab-hero-left { }

.ab-tag {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 28px;
}
.ab-tag-line {
    width: 32px; height: 1px;
    background: var(--accent);
    display: block;
}
.ab-tag-text {
    font-size: 13px;
    letter-spacing: 3.5px;
    text-transform: uppercase;
    color: var(--accent);
    font-weight: 500;
}

.ab-hero-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(52px, 6.5vw, 80px);
    font-weight: 300;
    line-height: 1.05;
    letter-spacing: -0.5px;
    color: var(--ink);
    margin: 0;
}
.ab-hero-title em {
    font-style: italic;
    color: var(--accent);
}

.ab-hero-right {
    padding-bottom: 6px;
}

.ab-hero-body {
    font-size: 1.15rem;
    font-weight: 300;
    line-height: 1.9;
    color: var(--soft);
    border-left: 2px solid var(--accent);
    padding-left: 22px;
    margin: 0;
}

/* ────────────────────────────────
   MISSION
──────────────────────────────── */
.ab-mission {
    display: grid;
    grid-template-columns: 220px 1fr;
    gap: 48px;
    margin-bottom: 72px;
    align-items: start;
}

.ab-section-label {
    font-size: 13px;
    letter-spacing: 3.5px;
    text-transform: uppercase;
    color: var(--muted);
    padding-top: 4px;
    font-weight: 500;
}

.ab-mission-content { }

.ab-mission-headline {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(28px, 3.5vw, 40px);
    font-weight: 300;
    color: var(--ink);
    line-height: 1.35;
    margin: 0 0 22px 0;
}

.ab-mission-para {
    font-size: 1.05rem;
    font-weight: 300;
    color: var(--soft);
    line-height: 1.85;
    margin: 0 0 14px 0;
}
.ab-mission-para:last-child { margin-bottom: 0; }

/* ────────────────────────────────
   VALUES
──────────────────────────────── */
.ab-values-section {
    margin-bottom: 72px;
}

.ab-values-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 28px;
}
.ab-values-header-line {
    flex: 1;
    height: 1px;
    background: var(--line);
}

.ab-values-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}

.ab-val {
    background: var(--white);
    border: 1px solid var(--line);
    border-radius: 4px;
    padding: 32px 26px 28px;
    position: relative;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s;
    cursor: default;
}

.ab-val::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 3px;
    background: var(--accent);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.35s ease;
}

.ab-val:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 48px rgba(0,0,0,0.09);
    border-color: transparent;
}
.ab-val:hover::before { transform: scaleX(1); }

.ab-val-num {
    font-family: 'Cormorant Garamond', serif;
    font-size: 48px;
    font-weight: 300;
    color: var(--accent-l);
    line-height: 1;
    margin-bottom: 16px;
    display: block;
}

.ab-val-name {
    font-size: 17px;
    font-weight: 600;
    color: var(--ink);
    margin-bottom: 10px;
    letter-spacing: 0.2px;
}

.ab-val-desc {
    font-size: 15px;
    font-weight: 300;
    color: var(--muted);
    line-height: 1.75;
}

/* ────────────────────────────────
   CLOSING BANNER
──────────────────────────────── */
.ab-banner {
    background: var(--ink);
    border-radius: 6px;
    padding: 50px 52px;
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 40px;
    align-items: center;
}

.ab-banner-quote {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(24px, 3vw, 36px);
    font-weight: 300;
    font-style: italic;
    color: rgba(255,255,255,0.92);
    line-height: 1.45;
    margin: 0;
}
.ab-banner-quote em {
    color: var(--accent);
    font-style: normal;
    font-weight: 400;
}

.ab-banner-sig { text-align: right; }

.ab-banner-name {
    font-size: 17px;
    font-weight: 500;
    color: #ffffff;
    display: block;
    letter-spacing: 0.3px;
}

.ab-banner-role {
    font-size: 13px;
    color: rgba(255,255,255,0.38);
    letter-spacing: 2px;
    text-transform: uppercase;
    display: block;
    margin-top: 6px;
}

/* ────────────────────────────────
   ANIMATIONS
──────────────────────────────── */
.ab-fade { opacity: 0; animation: abRise 0.65s ease forwards; }
.ab-fade:nth-child(1) { animation-delay: 0.05s; }
.ab-fade:nth-child(2) { animation-delay: 0.15s; }
.ab-fade:nth-child(3) { animation-delay: 0.25s; }
.ab-fade:nth-child(4) { animation-delay: 0.35s; }
.ab-fade:nth-child(5) { animation-delay: 0.45s; }

@keyframes abRise {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ────────────────────────────────
   RESPONSIVE
──────────────────────────────── */
@media (max-width: 768px) {
    .ab-wrap { padding: 60px 0 80px; }

    .ab-hero {
        grid-template-columns: 1fr;
        gap: 32px;
    }

    .ab-mission {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .ab-values-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .ab-banner {
        grid-template-columns: 1fr;
        gap: 24px;
        padding: 36px 28px;
    }

    .ab-banner-sig { text-align: left; }
}
</style>

<div class="ab-wrap">
<div class="ab-inner">

    {{-- ── HERO ── --}}
    <div class="ab-hero ab-fade">
        <div class="ab-hero-left">
            <div class="ab-tag">
                <span class="ab-tag-line"></span>
                <span class="ab-tag-text">Our Story</span>
            </div>
            <h1 class="ab-hero-title">
                Gifts that say<br>
                <em>exactly</em> what<br>
                you feel.
            </h1>
        </div>
        <div class="ab-hero-right">
            <p class="ab-hero-body">
                Gifts Hub was founded in 2024 with a simple belief — the right gift can say everything words cannot. We curate thoughtful, beautiful presents for every occasion, making the art of gifting effortless for everyone.
            </p>
        </div>
    </div>

    {{-- ── MISSION ── --}}
    <div class="ab-mission ab-fade">
        <p class="ab-section-label">Our Mission</p>
        <div class="ab-mission-content">
            <h2 class="ab-mission-headline">
                To make every moment of giving feel as special as the moment of receiving.
            </h2>
            <p class="ab-mission-para">
                We believe gifting is one of the most human things we do. Behind every wrapped box is a relationship, a memory, a feeling. Our role is to help you find the gift that carries all of that — effortlessly, beautifully, and with care.
            </p>
            <p class="ab-mission-para">
                From birthdays and anniversaries to festivals and milestones, Gifts Hub is built to make you feel confident in every gift you give.
            </p>
        </div>
    </div>

    {{-- ── VALUES ── --}}
    <div class="ab-values-section ab-fade">
        <div class="ab-values-header">
            <span class="ab-section-label">What we stand for</span>
            <span class="ab-values-header-line"></span>
        </div>
        <div class="ab-values-grid">
            <div class="ab-val">
                <span class="ab-val-num">01</span>
                <p class="ab-val-name">Thoughtful Curation</p>
                <p class="ab-val-desc">Every product in our store is handpicked for quality, meaning, and that "wow" factor.</p>
            </div>
            <div class="ab-val">
                <span class="ab-val-num">02</span>
                <p class="ab-val-name">Personal Touch</p>
                <p class="ab-val-desc">We design the gifting experience to feel personal — never generic, never rushed.</p>
            </div>
            <div class="ab-val">
                <span class="ab-val-num">03</span>
                <p class="ab-val-name">Trusted Quality</p>
                <p class="ab-val-desc">We stand behind every item. If it doesn't meet our standard, it doesn't make the shelf.</p>
            </div>
        </div>
    </div>

    {{-- ── CLOSING BANNER ── --}}
    <div class="ab-banner ab-fade">
        <p class="ab-banner-quote">
            "We started Gifts Hub so no one ever has to settle for a gift that doesn't <em>mean something</em>."
        </p>
        <div class="ab-banner-sig">
            <strong class="ab-banner-name">Sandesh Bhandari</strong>
            <span class="ab-banner-role">Founder &amp; CEO</span>
        </div>
    </div>

</div>
</div>

@endsection