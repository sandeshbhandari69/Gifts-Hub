@extends('layouts.main')
@push('title')
    <title>Contact Us - Gifts Hub</title>
@endpush

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Inter', sans-serif; background: #151d2e; }

    /* ── LAYOUT ── */
    .contact-body {
        max-width: 1000px;
        margin: 0 auto;
        padding: 56px 24px 80px;
    }

    /* ── FORM CARD ── */
    .contact-form-card {
        background: #1e2d45;
        border-radius: 16px;
        padding: 40px 36px;
        border: 0.5px solid rgba(0,0,0,0.1);
        height: 100%;
    }
    .contact-form-card h3 {
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        font-weight: 400;
        color: #f5f0e8;
        margin-bottom: 6px;
    }
    .card-sub {
        font-size: 13px;
        color: rgba(245,240,232,0.35);
        margin-bottom: 32px;
        font-weight: 300;
    }
    .form-label-gh {
        display: block;
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: rgba(201,149,106,0.75);
        margin-bottom: 8px;
    }
    .form-control-gh {
        width: 100%;
        padding: 13px 16px;
        font-size: 13px;
        font-family: 'Inter', sans-serif;
        color: #ffffff;
        background: rgba(0,0,0,0.05);
        border: 0.5px solid rgba(0,0,0,0.15);
        border-radius: 10px;
        outline: none;
        transition: border-color 0.2s, background 0.2s;
        margin-bottom: 20px;
        display: block;
    }
    .form-control-gh::placeholder { color: rgba(255,255,255,0.5); }
    .form-control-gh:focus {
        border-color: rgba(201,149,106,0.55);
        background: rgba(201,149,106,0.04);
        box-shadow: none;
    }
    .btn-gh-send {
        width: 100%;
        padding: 15px;
        background: #c9956a;
        color: #151d2e;
        font-family: 'Inter', sans-serif;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 2px;
        text-transform: uppercase;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    .btn-gh-send:hover { background: #d9a87c; transform: translateY(-1px); color: #151d2e; }
    .btn-gh-send:active { transform: none; }

    /* ── INFO CARD ── */
    .gh-info-top {
        background: linear-gradient(145deg, #151d2e, #1e2d45);
        border-radius: 16px;
        padding: 36px 30px;
        border: 0.5px solid rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    .gh-info-top h3 {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        font-weight: 400;
        color: #f5f0e8;
        margin-bottom: 28px;
    }
    .gh-contact-item {
        display: flex;
        gap: 14px;
        align-items: flex-start;
        padding: 16px 0;
        border-bottom: 0.5px solid rgba(0,0,0,0.08);
    }
    .gh-contact-item:last-child { border-bottom: none; padding-bottom: 0; }
    .gh-contact-item:first-child { padding-top: 0; }
    .gh-ci-icon {
        width: 36px; height: 36px;
        border-radius: 8px;
        background: rgba(201,149,106,0.1);
        border: 0.5px solid rgba(201,149,106,0.25);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-size: 14px;
        color: #c9956a;
    }
    .gh-ci-label {
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 1.8px;
        text-transform: uppercase;
        color: rgba(201,149,106,0.65);
        margin-bottom: 4px;
    }
    .gh-ci-val {
        font-size: 13px;
        color: rgba(245,240,232,0.75);
        line-height: 1.6;
        font-weight: 300;
        margin: 0;
    }

    /* ── HOURS ── */
    .gh-hours-card {
        background: rgba(201,149,106,0.07);
        border: 0.5px solid rgba(201,149,106,0.18);
        border-radius: 14px;
        padding: 24px 28px;
        margin-bottom: 20px;
    }
    .gh-hours-head {
        display: flex; align-items: center; gap: 8px;
        font-size: 10px; font-weight: 600;
        letter-spacing: 2px; text-transform: uppercase;
        color: #c9956a; margin-bottom: 16px;
    }
    .live-dot {
        width: 7px; height: 7px; border-radius: 50%;
        background: #6bbf6e;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%,100%{ opacity:1; } 50%{ opacity:0.35; }
    }
    .gh-hrow {
        display: flex; justify-content: space-between;
        font-size: 13px; color: rgba(245,240,232,0.55);
        padding: 5px 0; font-weight: 300;
    }
    .gh-hrow.open { color: #f5f0e8; font-weight: 500; }

    /* ── SOCIAL ── */
    .gh-social-card {
        background: #1e2d45;
        border: 0.5px solid rgba(255,255,255,0.07);
        border-radius: 14px;
        padding: 18px 24px;
        display: flex; align-items: center; justify-content: space-between;
    }
    .social-label {
        font-size: 10px; font-weight: 500;
        letter-spacing: 1.8px; text-transform: uppercase;
        color: rgba(245,240,232,0.3);
    }
    .social-icons { display: flex; gap: 8px; }
    .social-icon-btn {
        width: 34px; height: 34px; border-radius: 8px;
        background: rgba(255,255,255,0.05);
        border: 0.5px solid rgba(255,255,255,0.1);
        display: flex; align-items: center; justify-content: center;
        color: rgba(245,240,232,0.55);
        font-size: 13px;
        transition: background 0.2s, border-color 0.2s;
        text-decoration: none;
    }
    .social-icon-btn:hover {
        background: rgba(201,149,106,0.1);
        border-color: rgba(201,149,106,0.3);
        color: #c9956a;
    }

    /* ── SUCCESS STATE ── */
    .form-success { display: none; text-align: center; padding: 56px 0; }
    .success-ring {
        width: 64px; height: 64px; border-radius: 50%;
        border: 1.5px solid rgba(201,149,106,0.4);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
        font-size: 22px; color: #c9956a;
    }
    .form-success h4 {
        font-family: 'Playfair Display', serif;
        font-size: 22px; font-weight: 400;
        color: #f5f0e8; margin-bottom: 10px;
    }
    .form-success p {
        font-size: 13px;
        color: rgba(245,240,232,0.4);
</style>
@endpush

@section('content')

{{-- BODY --}}
<div class="contact-body">
    <div class="row g-4 align-items-start">

        {{-- FORM --}}
        <div class="col-lg-7">
            <div class="contact-form-card">
                <h3>Send a Message</h3>
                <p class="card-sub">We read every message and reply personally.</p>

                <div id="form-wrap" @if(session('success')) style="display:none" @endif>
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf

                        <div class="row g-3 mb-0">
                            <div class="col-6">
                                <label class="form-label-gh">First Name</label>
                                <input class="form-control-gh" type="text" name="first_name"
                                       placeholder="Sarah" value="{{ old('first_name') }}" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label-gh">Last Name</label>
                                <input class="form-control-gh" type="text" name="last_name"
                                       placeholder="Johnson" value="{{ old('last_name') }}" required>
                            </div>
                        </div>

                        <label class="form-label-gh">Email Address</label>
                        <input class="form-control-gh" type="email" name="email"
                               placeholder="you@example.com" value="{{ old('email') }}" required>

                        <label class="form-label-gh">Subject</label>
                        <input class="form-control-gh" type="text" name="subject"
                               placeholder="How can we help?" value="{{ old('subject') }}">

                        <label class="form-label-gh">Message</label>
                        <textarea class="form-control-gh" name="message"
                                  rows="5" placeholder="Tell us anything..." required>{{ old('message') }}</textarea>

                        <button type="submit" class="btn-gh-send">
                            <i class="fas fa-paper-plane fa-xs"></i>
                            Send Message
                        </button>
                    </form>
                </div>

                <div class="form-success" id="form-success"
                     @if(session('success')) style="display:block" @endif>
                    <div class="success-ring">
                        <i class="fas fa-check"></i>
                    </div>
                    <h4>Message received.</h4>
                    <p>Thank you for reaching out. We'll be in touch within 24 hours.</p>
                </div>
            </div>
        </div>

        {{-- INFO --}}
        <div class="col-lg-5">
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

@endsection