@extends('layouts.main')

@push('title')
    <title>Contact Us - Gifts Hub</title>
@endpush

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
/* ── Scoped reset ── */
.contact-wrap, .contact-wrap * { box-sizing: border-box; }

/* ── Variables (matching About Us) ── */
.contact-wrap {
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
   PAGE HEADER (matching About Us gradient)
════════════════════════════ */
.contact-header {
    background: linear-gradient(120deg, var(--ab-dark) 0%, var(--ab-mid) 38%, #8a9ab5 68%, #ddd8d0 88%, #f5f0eb 100%);
    padding: 60px 0 56px;
    position: relative;
    overflow: hidden;
}
.contact-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 60% 80% at 8% 50%, rgba(196,82,42,0.10) 0%, transparent 60%),
        radial-gradient(ellipse 30% 60% at 92% 30%, rgba(212,149,106,0.08) 0%, transparent 50%);
    pointer-events: none;
}
.contact-header .container { position: relative; z-index: 1; }
.contact-header-eyebrow {
    font-size: 11px;
    letter-spacing: 4px;
    text-transform: uppercase;
    color: rgba(245,240,235,0.50);
    font-weight: 500;
    margin-bottom: 14px;
}
.contact-header-title {
    font-family: var(--ab-font-d);
    font-size: clamp(2.4rem, 5.5vw, 3.8rem);
    font-weight: 300;
    color: #f5f0eb;
    line-height: 1.08;
    letter-spacing: -0.02em;
    margin: 0 0 18px;
}
.contact-header-title em {
    font-style: italic;
    color: var(--ab-gold);
}
.contact-header-sub {
    font-size: 15px;
    font-weight: 300;
    color: rgba(245,240,235,0.62);
    max-width: 460px;
    line-height: 1.75;
    margin: 0;
}

/* ════════════════════════════
   MAIN CONTENT WRAPPER
════════════════════════════ */
.contact-main {
    padding: 68px 0 90px;
}

/* ── LAYOUT ── */
.contact-body {
    max-width: 1000px;
    margin: 0 auto;
}

/* ── FORM CARD ── */
.contact-form-card {
    background: var(--ab-surface);
    border: 1.5px solid var(--ab-border);
    border-radius: var(--ab-radius);
    padding: 40px 36px;
    height: 100%;
    transition: var(--ab-transition);
}
.contact-form-card:hover {
    border-color: var(--ab-accent);
    box-shadow: 0 12px 32px rgba(26,32,53,0.09);
}
.contact-form-card h3 {
    font-family: var(--ab-font-d);
    font-size: clamp(1.7rem, 3vw, 2.4rem);
    font-weight: 300;
    color: var(--ab-text);
    line-height: 1.35;
    margin-bottom: 6px;
}
.card-sub {
    font-size: 13px;
    color: var(--ab-soft);
    margin-bottom: 32px;
    font-weight: 300;
    line-height: 1.6;
}
.form-label-gh {
    display: block;
    font-size: 10px;
    font-weight: 500;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--ab-accent);
    margin-bottom: 8px;
}
.form-control-gh {
    width: 100%;
    padding: 13px 16px;
    font-size: 13px;
    font-family: var(--ab-font-b);
    color: var(--ab-text);
    background: var(--ab-bg);
    border: 1.5px solid var(--ab-border);
    border-radius: var(--ab-radius);
    outline: none;
    transition: var(--ab-transition);
    margin-bottom: 20px;
    display: block;
}
.form-control-gh::placeholder { color: var(--ab-muted); }
.form-control-gh:focus {
    border-color: var(--ab-accent);
    background: var(--ab-bg);
    box-shadow: 0 0 0 3px rgba(196,82,42,0.1);
}
.btn-gh-send {
    width: 100%;
    padding: 15px;
    background: var(--ab-accent);
    color: var(--ab-bg);
    font-family: var(--ab-font-b);
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    border: none;
    border-radius: var(--ab-radius);
    cursor: pointer;
    transition: var(--ab-transition);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}
.btn-gh-send:hover { 
    background: var(--ab-gold); 
    transform: translateY(-2px); 
    box-shadow: 0 8px 24px rgba(196,82,42,0.2);
}
.btn-gh-send:active { transform: none; }

/* ── INFO CARD ── */
.gh-info-top {
    background: var(--ab-surface);
    border: 1.5px solid var(--ab-border);
    border-radius: var(--ab-radius);
    padding: 36px 30px;
    margin-bottom: 20px;
    transition: var(--ab-transition);
}
.gh-info-top:hover {
    border-color: var(--ab-accent);
    box-shadow: 0 12px 32px rgba(26,32,53,0.09);
}
.gh-info-top h3 {
    font-family: var(--ab-font-d);
    font-size: clamp(1.5rem, 2.5vw, 2rem);
    font-weight: 300;
    color: var(--ab-text);
    line-height: 1.35;
    margin-bottom: 28px;
}
.gh-contact-item {
    display: flex;
    gap: 14px;
    align-items: flex-start;
    padding: 16px 0;
    border-bottom: 1px solid var(--ab-border-mid);
}
.gh-contact-item:last-child { border-bottom: none; padding-bottom: 0; }
.gh-contact-item:first-child { padding-top: 0; }
.gh-ci-icon {
    width: 36px; height: 36px;
    border-radius: 8px;
    background: rgba(196,82,42,0.1);
    border: 1.5px solid rgba(196,82,42,0.25);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    font-size: 14px;
    color: var(--ab-accent);
}
.gh-ci-label {
    font-size: 10px;
    font-weight: 500;
    letter-spacing: 1.8px;
    text-transform: uppercase;
    color: var(--ab-accent);
    margin-bottom: 4px;
}
.gh-ci-val {
    font-size: 13px;
    color: var(--ab-soft);
    line-height: 1.6;
    font-weight: 300;
    margin: 0;
}

/* ── SOCIAL ── */
.gh-social-card {
    background: var(--ab-surface);
    border: 1.5px solid var(--ab-border);
    border-radius: var(--ab-radius);
    padding: 18px 24px;
    display: flex; align-items: center; justify-content: space-between;
    transition: var(--ab-transition);
}
.gh-social-card:hover {
    border-color: var(--ab-accent);
    box-shadow: 0 12px 32px rgba(26,32,53,0.09);
}
.social-label {
    font-size: 10px; font-weight: 500;
    letter-spacing: 1.8px; text-transform: uppercase;
    color: var(--ab-accent);
}
.social-icons { display: flex; gap: 8px; }
.social-icon-btn {
    width: 34px; height: 34px; border-radius: 8px;
    background: var(--ab-bg);
    border: 1.5px solid var(--ab-border);
    display: flex; align-items: center; justify-content: center;
    color: var(--ab-soft);
    font-size: 13px;
    transition: var(--ab-transition);
    text-decoration: none;
}
.social-icon-btn:hover {
    background: rgba(196,82,42,0.1);
    border-color: var(--ab-accent);
    color: var(--ab-accent);
    transform: translateY(-2px);
}

/* ── SUCCESS STATE ── */
.form-success { display: none; text-align: center; padding: 56px 0; }
.success-ring {
    width: 64px; height: 64px; border-radius: 50%;
    border: 1.5px solid rgba(196,82,42,0.4);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px;
    font-size: 22px; color: var(--ab-accent);
}
.form-success h4 {
    font-family: var(--ab-font-d);
    font-size: clamp(1.5rem, 2.5vw, 2rem);
    font-weight: 300;
    color: var(--ab-text);
    line-height: 1.35;
    margin-bottom: 10px;
}
.form-success p {
    font-size: 13px;
    color: var(--ab-soft);
    line-height: 1.6;
}

/* ════════════════════════════
   ANIMATIONS
════════════════════════════ */
.contact-fade {
    opacity: 0;
    animation: contactRise 0.6s ease forwards;
}
.contact-fade:nth-child(1) { animation-delay: 0.05s; }
.contact-fade:nth-child(2) { animation-delay: 0.15s; }
.contact-fade:nth-child(3) { animation-delay: 0.25s; }

@keyframes contactRise {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ════════════════════════════
   RESPONSIVE
════════════════════════════ */
@media (max-width: 767px) {
    .contact-header { padding: 44px 0 40px; }
    .contact-main { padding: 44px 0 60px; }
    .contact-form-card { padding: 28px 24px; }
    .gh-info-top { padding: 28px 24px; }
}
</style>
@endpush

@section('content')

<div class="contact-wrap">

    
    {{-- ── MAIN CONTENT ── --}}
    <div class="contact-main">
        <div class="container">
            <div class="contact-body">
                <div class="row g-4 align-items-start">

                    {{-- FORM --}}
                    <div class="col-lg-7 contact-fade">
                        <div class="contact-form-card">
                            <h3>Send a Message</h3>
                            <p class="card-sub">We read every message and reply personally.</p>

                            <div id="form-wrap">
                                <form id="contactForm">
                                    <div class="row g-3 mb-0">
                                        <div class="col-12">
                                            <label class="form-label-gh">Name</label>
                                            <input class="form-control-gh" type="text" name="name"
                                                   placeholder="Your full name" required>
                                        </div>
                                    </div>

                                    <label class="form-label-gh">Email Address</label>
                                    <input class="form-control-gh" type="email" name="email"
                                           placeholder="you@example.com" required>

                                    <label class="form-label-gh">Subject</label>
                                    <input class="form-control-gh" type="text" name="subject"
                                           placeholder="How can we help?" required>

                                    <label class="form-label-gh">Message</label>
                                    <textarea class="form-control-gh" name="message"
                                              rows="5" placeholder="Tell us anything..." required></textarea>

                                    <button type="submit" class="btn-gh-send">
                                        <i class="fas fa-paper-plane fa-xs"></i>
                                        Send Message
                                    </button>
                                </form>
                            </div>

                            <div class="form-success" id="form-success" style="display:none">
                                <div class="success-ring">
                                    <i class="fas fa-check"></i>
                                </div>
                                <h4>Message received.</h4>
                                <p>Your message has been sent! We'll get back to you soon.</p>
                            </div>
                        </div>
                    </div>

                    {{-- INFO --}}
                    <div class="col-lg-5 contact-fade">
                        <div class="gh-info-top">
                            <h3>Get in Touch</h3>
                            <div class="gh-contact-item">
                                <div class="gh-ci-icon"><i class="fas fa-map-marker-alt fa-xs"></i></div>
                                <div>
                                    <div class="gh-ci-label">Location</div>
                                    <p class="gh-ci-val">123 Gift Street, Celebration City<br>New York, NY 10012</p>
                                </div>
                            </div>
                            <div class="gh-contact-item">
                                <div class="gh-ci-icon"><i class="fas fa-envelope fa-xs"></i></div>
                                <div>
                                    <div class="gh-ci-label">Email</div>
                                    <p class="gh-ci-val">support@giftshub.com</p>
                                </div>
                            </div>
                            <div class="gh-contact-item">
                                <div class="gh-ci-icon"><i class="fas fa-phone fa-xs"></i></div>
                                <div>
                                    <div class="gh-ci-label">Phone</div>
                                    <p class="gh-ci-val">+1 (555) 123-4567</p>
                                </div>
                            </div>
                        </div>

                        <div class="gh-social-card">
                            <div class="social-label">Follow Us</div>
                            <div class="social-icons">
                                <a href="#" class="social-icon-btn" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="social-icon-btn" title="Instagram"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="social-icon-btn" title="Twitter"><i class="fab fa-x-twitter"></i></a>
                                <a href="#" class="social-icon-btn" title="Pinterest"><i class="fab fa-pinterest-p"></i></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    const formWrap = document.getElementById('form-wrap');
    const formSuccess = document.getElementById('form-success');
    
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(this);
        const messageData = {
            id: Date.now().toString(),
            name: formData.get('name'),
            email: formData.get('email'),
            subject: formData.get('subject'),
            message: formData.get('message'),
            timestamp: new Date().toISOString(),
            read: false
        };
        
        // Get existing messages from localStorage
        let messages = JSON.parse(localStorage.getItem('contactMessages') || '[]');
        messages.unshift(messageData); // Add new message at the beginning
        
        // Save to localStorage
        localStorage.setItem('contactMessages', JSON.stringify(messages));
        
        // Show success message
        formWrap.style.display = 'none';
        formSuccess.style.display = 'block';
        
        // Reset form
        contactForm.reset();
        
        // Show form again after 5 seconds
        setTimeout(() => {
            formWrap.style.display = 'block';
            formSuccess.style.display = 'none';
        }, 5000);
    });
});
</script>

@endsection
