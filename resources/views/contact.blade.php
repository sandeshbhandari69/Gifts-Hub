@extends('layouts.main')
@push('title')
    <title>Contact Us - Gifts Hub</title>
@endpush
@section('content')
<div class="container my-5">
    <div class="text-center mb-5">
        <h1 class="display-4" style="color: #0d47a1;">Contact Us</h1>
        <p class="lead">We'd love to hear from you!</p>
    </div>
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-body p-5">
                    <h3 class="mb-4">Get in Touch</h3>
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Your Name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Your Email">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="5" placeholder="Your Message"></textarea>
                        </div>
                        <button type="submit" class="btn theme-green-btn btn-lg w-100">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow border-0 h-100">
                <div class="card-body p-5">
                    <h3 class="mb-4">Contact Information</h3>
                    <div class="d-flex align-items-start mb-4">
                        <div class="me-3 text-primary">
                            <i class="fas fa-map-marker-alt fa-2x"></i>
                        </div>
                        <div>
                            <h5>Our Location</h5>
                            <p class="text-muted">123 Gift Street, Celebration City, NY 10012</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-4">
                        <div class="me-3 text-primary">
                            <i class="fas fa-envelope fa-2x"></i>
                        </div>
                        <div>
                            <h5>Email Us</h5>
                            <p class="text-muted">support@giftshub.com</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-4">
                        <div class="me-3 text-primary">
                            <i class="fas fa-phone fa-2x"></i>
                        </div>
                        <div>
                            <h5>Call Us</h5>
                            <p class="text-muted">+1 (555) 123-4567</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
