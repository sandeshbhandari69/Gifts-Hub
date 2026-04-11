@extends('layouts.main')

@push('title')
    <title>About Us - Gifts Hub</title>
@endpush

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
/* ── Scoped reset ── */
.ab-wrap, .ab-wrap * { box-sizing: border-box; }

/* ── Variables ── */
.ab-wrap {
    --ab-dark:       #1a2035;
    --ab-mid:        #3a4a6b;
    --ab-accent:     #c4522a;
    --ab-gold:       #d4956a;
    --ab-bg:         #ffffff;
    --ab-surface:    #faf8f5;
    --ab-border:     #e8e0d6;
    --ab-border-mid: #ede8e0;
    --ab-text:       #1a1a1a;
    --ab-soft:       #555555;
    --ab-muted:      #999999;
    --ab-radius:     12px;
    --ab-transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
    --ab-font-d:     'Cormorant Garamond', Georgia, serif;
    --ab-font-b:     'DM Sans', sans-serif;

    background: var(--ab-bg);
    font-family: var(--ab-font-b);
    color: var(--ab-text);
}

/* ════════════════════════════
   PAGE HEADER  (matches categories page gradient)
════════════════════════════ */
.ab-header {
    background: linear-gradient(120deg, var(--ab-dark) 0%, var(--ab-mid) 38%, #8a9ab5 68%, #ddd8d0 88%, #f5f0eb 100%);
    padding: 60px 0 56px;
    position: relative;
    overflow: hidden;
}
.ab-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 60% 80% at 8% 50%, rgba(196,82,42,0.10) 0%, transparent 60%),
        radial-gradient(ellipse 30% 60% at 92% 30%, rgba(212,149,106,0.08) 0%, transparent 50%);
    pointer-events: none;
}
.ab-header .container { position: relative; z-index: 1; }
.ab-header-eyebrow {
    font-size: 11px;
    letter-spacing: 4px;
    text-transform: uppercase;
    color: rgba(245,240,235,0.50);
    font-weight: 500;
    margin-bottom: 14px;
}
.ab-header-title {
    font-family: var(--ab-font-d);
    font-size: clamp(2.4rem, 5.5vw, 3.8rem);
    font-weight: 300;
    color: #f5f0eb;
    line-height: 1.08;
    letter-spacing: -0.02em;
    margin: 0 0 18px;
}
.ab-header-title em {
    font-style: italic;
    color: var(--ab-gold);
}
.ab-header-sub {
    font-size: 15px;
    font-weight: 300;
    color: rgba(245,240,235,0.62);
    max-width: 460px;
    line-height: 1.75;
    margin: 0;
}

/* ════════════════════════════
   STATS BAR
════════════════════════════ */
.ab-stats-bar {
    background: #ffffff;
    border-bottom: 1px solid var(--ab-border-mid);
    padding: 28px 0;
}
.ab-stats-inner {
    display: flex;
    gap: 0;
}
.ab-stat {
    flex: 1;
    padding: 0 32px;
    border-right: 1px solid var(--ab-border-mid);
    text-align: center;
}
.ab-stat:first-child { padding-left: 0; text-align: left; }
.ab-stat:last-child  { border-right: none; }
.ab-stat-number {
    font-family: var(--ab-font-d);
    font-size: 2.4rem;
    font-weight: 300;
    color: var(--ab-accent);
    display: block;
    line-height: 1;
}
.ab-stat-label {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 2.5px;
    color: var(--ab-muted);
    margin-top: 5px;
    display: block;
    font-weight: 500;
}

/* ════════════════════════════
   MAIN CONTENT WRAPPER
════════════════════════════ */
.ab-main {
    padding: 68px 0 90px;
}

/* ════════════════════════════
   SECTION ROWS
════════════════════════════ */
.ab-section {
    margin-bottom: 68px;
}
.ab-section-row {
    display: grid;
    grid-template-columns: 200px 1fr;
    gap: 52px;
    align-items: start;
}
.ab-section-label {
    font-size: 11px;
    letter-spacing: 3.5px;
    text-transform: uppercase;
    color: var(--ab-accent);
    font-weight: 600;
    padding-top: 6px;
    line-height: 1;
}
.ab-section-heading {
    font-family: var(--ab-font-d);
    font-size: clamp(1.7rem, 3vw, 2.4rem);
    font-weight: 300;
    color: var(--ab-text);
    line-height: 1.35;
    margin-bottom: 22px;
}
.ab-section-para {
    font-size: 15px;
    font-weight: 300;
    color: var(--ab-soft);
    line-height: 1.88;
    margin-bottom: 14px;
}
.ab-section-para:last-child { margin-bottom: 0; }

/* ════════════════════════════
   HORIZONTAL DIVIDER
════════════════════════════ */
.ab-divider {
    height: 1px;
    background: var(--ab-border-mid);
    margin-bottom: 68px;
}

/* ════════════════════════════
   VALUES GRID
════════════════════════════ */
.ab-values-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}
.ab-val {
    background: var(--ab-surface);
    border: 1.5px solid var(--ab-border);
    border-radius: var(--ab-radius);
    padding: 28px 22px 24px;
    position: relative;
    overflow: hidden;
    transition: var(--ab-transition);
    cursor: default;
}
.ab-val::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--ab-accent), var(--ab-gold));
    opacity: 0;
    transition: var(--ab-transition);
    border-radius: 0;
}
.ab-val:hover {
    border-color: var(--ab-accent);
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(26,32,53,0.09);
}
.ab-val:hover::before { opacity: 1; }
.ab-val-num {
    font-family: var(--ab-font-d);
    font-size: 2.8rem;
    font-weight: 300;
    color: #e8d4c4;
    display: block;
    line-height: 1;
    margin-bottom: 14px;
}
.ab-val-title {
    font-size: 15px;
    font-weight: 600;
    color: var(--ab-text);
    margin-bottom: 8px;
}
.ab-val-desc {
    font-size: 13.5px;
    font-weight: 300;
    color: var(--ab-muted);
    line-height: 1.72;
    margin: 0;
}

/* ════════════════════════════
   QUOTE / FOUNDER BANNER
════════════════════════════ */
.ab-quote-banner {
    background: var(--ab-surface);
    border: 1.5px solid var(--ab-border);
    border-left: 4px solid var(--ab-accent);
    border-radius: 0 var(--ab-radius) var(--ab-radius) 0;
    padding: 40px 44px;
    display: flex;
    align-items: flex-start;
    gap: 28px;
}
.ab-quote-mark {
    font-family: var(--ab-font-d);
    font-size: 5.5rem;
    color: #e8d4c4;
    line-height: 0.75;
    flex-shrink: 0;
    margin-top: 6px;
    user-select: none;
}
.ab-quote-content {}
.ab-quote-text {
    font-family: var(--ab-font-d);
    font-size: clamp(1.2rem, 2.2vw, 1.65rem);
    font-weight: 300;
    font-style: italic;
    color: var(--ab-text);
    line-height: 1.55;
    margin-bottom: 22px;
}
.ab-quote-text em {
    font-style: normal;
    color: var(--ab-accent);
    font-weight: 400;
}
.ab-quote-author {
    display: flex;
    align-items: center;
    gap: 14px;
}
.ab-quote-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--ab-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 600;
    color: #f5f0eb;
    flex-shrink: 0;
    letter-spacing: 0.5px;
    font-family: var(--ab-font-b);
}
.ab-quote-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--ab-text);
    display: block;
}
.ab-quote-role {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 2.5px;
    color: var(--ab-muted);
    margin-top: 3px;
    display: block;
    font-weight: 500;
}

/* ════════════════════════════
   ANIMATIONS
════════════════════════════ */
.ab-fade {
    opacity: 0;
    animation: abRise 0.6s ease forwards;
}
.ab-fade:nth-child(1) { animation-delay: 0.05s; }
.ab-fade:nth-child(2) { animation-delay: 0.15s; }
.ab-fade:nth-child(3) { animation-delay: 0.25s; }
.ab-fade:nth-child(4) { animation-delay: 0.35s; }

@keyframes abRise {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ════════════════════════════
   RESPONSIVE
════════════════════════════ */
@media (max-width: 767px) {
    .ab-header { padding: 44px 0 40px; }

    .ab-stats-inner {
        flex-direction: column;
        gap: 20px;
    }
    .ab-stat {
        padding: 0 0 20px;
        border-right: none;
        border-bottom: 1px solid var(--ab-border-mid);
        text-align: left;
    }
    .ab-stat:last-child { border-bottom: none; padding-bottom: 0; }

    .ab-main { padding: 44px 0 60px; }

    .ab-section-row {
        grid-template-columns: 1fr;
        gap: 14px;
    }
    .ab-values-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }
    .ab-quote-banner {
        flex-direction: column;
        gap: 16px;
        padding: 28px 24px;
        border-left-width: 3px;
    }
    .ab-quote-mark { display: none; }
}

@media (min-width: 768px) and (max-width: 1024px) {
    .ab-values-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>
@endpush

@section('content')

<div class="ab-wrap">

    {{-- ── STATS BAR ── --}}
    <div class="ab-stats-bar ab-fade">
        <div class="container">
            <div class="ab-stats-inner">
                <div class="ab-stat">
                    <span class="ab-stat-number">2024</span>
                    <span class="ab-stat-label">Founded</span>
                </div>
                <div class="ab-stat">
                    <span class="ab-stat-number">100%</span>
                    <span class="ab-stat-label">Curated</span>
                </div>
                <div class="ab-stat">
                    <span class="ab-stat-number">Every</span>
                    <span class="ab-stat-label">Occasion</span>
                </div>
                <div class="ab-stat">
                    <span class="ab-stat-number">Nepal</span>
                    <span class="ab-stat-label">Based</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── MAIN CONTENT ── --}}
    <div class="ab-main">
        <div class="container">

            {{-- Mission ── --}}
            <div class="ab-section ab-fade">
                <div class="ab-section-row">
                    <p class="ab-section-label">Our Mission</p>
                    <div>
                        <h2 class="ab-section-heading">
                            To make every moment of giving feel as special as the moment of receiving.
                        </h2>
                        <p class="ab-section-para">
                            We believe gifting is one of the most human things we do. Behind every wrapped box is a relationship, a memory, a feeling. Our role is to help you find the gift that carries all of that — effortlessly, beautifully, and with care.
                        </p>
                        <p class="ab-section-para">
                            From birthdays and anniversaries to festivals and milestones, Gifts Hub is built to make you feel confident in every gift you give.
                        </p>
                    </div>
                </div>
            </div>

            <div class="ab-divider"></div>

            {{-- Values ── --}}
            <div class="ab-section ab-fade">
                <div class="ab-section-row">
                    <p class="ab-section-label">What we stand for</p>
                    <div>
                        <div class="ab-values-grid">
                            <div class="ab-val">
                                <span class="ab-val-num">01</span>
                                <p class="ab-val-title">Thoughtful Curation</p>
                                <p class="ab-val-desc">Every product in our store is handpicked for quality, meaning, and that "wow" factor.</p>
                            </div>
                            <div class="ab-val">
                                <span class="ab-val-num">02</span>
                                <p class="ab-val-title">Personal Touch</p>
                                <p class="ab-val-desc">We design the gifting experience to feel personal — never generic, never rushed.</p>
                            </div>
                            <div class="ab-val">
                                <span class="ab-val-num">03</span>
                                <p class="ab-val-title">Trusted Quality</p>
                                <p class="ab-val-desc">We stand behind every item. If it doesn't meet our standard, it doesn't make the shelf.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ab-divider"></div>

            {{-- Founder Quote ── --}}
            <div class="ab-quote-banner ab-fade">
                <div class="ab-quote-mark">&ldquo;</div>
                <div class="ab-quote-content">
                    <p class="ab-quote-text">
                        We started Gifts Hub so no one ever has to settle for a gift that doesn't <em>mean something</em>.
                    </p>
                    <div class="ab-quote-author">
                        <div class="ab-quote-avatar">SB</div>
                        <div>
                            <strong class="ab-quote-name">Sandesh Bhandari</strong>
                            <span class="ab-quote-role">Founder &amp; CEO</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection