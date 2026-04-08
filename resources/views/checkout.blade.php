@extends('layouts.main')

@push('title')
<title>Checkout Page</title>
@endpush

@section('content')

<!-- Page Header -->
<div class="container-fluid bg-light p-5">
    <h1 class="text-center text-secondary">
        <i class="fa-solid fa-cart-shopping"></i> Checkout
    </h1>
</div>

@if($cartItems && count($cartItems) > 0)
<!-- Billing Information -->
<section>
    <div class="container my-5">
        <h3>Billing Details</h3>
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="row my-3">
                <div class="col-lg-12 mb-3">
                    <select class="form-select form-control" name="country" required>
                        <option value="">Select your Country</option>
                        <option value="Nepal">Nepal</option>
                        <option value="India">India</option>
                        <option value="USA">USA</option>
                        <option value="UK">UK</option>
                        <option value="Australia">Australia</option>
                        <option value="Canada">Canada</option>
                    </select>
                </div> 

                <div class="col-lg-6 mb-3">
                    <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
                </div>

                <div class="col-lg-6 mb-3">
                    <input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
                </div>

                <div class="col-lg-6 mb-3">
                    <input type="tel" class="form-control" name="phone" placeholder="Phone Number" required>
                </div>

                <div class="col-lg-6 mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                </div>

                <div class="col-lg-12 mb-3">
                    <textarea class="form-control form-control-lg" name="address" placeholder="Your Address" rows="4" required></textarea>
                </div>

                                
            </div>

            <!-- Order Summary -->
            <h3>Your Orders</h3>
            <div class="row mb-5">
                <div class="col-lg-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"><h5>Product</h5></th>
                                <th scope="col"><h5>Price</h5></th>
                                <th scope="col"><h5>Quantity</h5></th>
                                <th scope="col"><h5>Total</h5></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                            <tr>
                                <th>
                                    <div class="d-flex">
                                        <div>    
                                            <img src="{{ $item['image'] }}" class="img-fluid rounded" style="width: 70px;" alt="{{ $item['name'] }}" onerror="this.src='{{ asset('assets/images/product/1.png') }}';">
                                        </div>
                                        <div class="p-3"><h6>{{ $item['name'] }}</h6></div>
                                    </div>
                                </th>
                                <td>Rs. {{ number_format((float)str_replace(['$', 'Rs.', 'Rs '],'',$item['price']),2) }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>Rs. {{ number_format((float)str_replace(['$', 'Rs.', 'Rs '],'',$item['price']) * $item['quantity'],2) }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <th colspan="3"><h4>Total</h4></th>
                                <th><h5>Rs. {{ number_format(collect($cartItems)->sum(function($item) { return (float)str_replace(['$', 'Rs.', 'Rs '], '', $item['price']) * $item['quantity']; }), 2) }}</h5></th>
                            </tr>
                        </tbody>
                    </table>    
                </div>
            </div>



            <!-- Payment Method -->
            <h3>Payment Method</h3>
            <div class="row">
                <div class="col-lg-5">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card" required>
                        <label class="form-check-label" for="credit_card">
                            <h5>Credit Card/Debit Card</h5>
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payment_method" id="esewa" value="esewa" required>
                        <label class="form-check-label" for="esewa">
                            <h5>Esewa</h5>
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payment_method" id="khalti" value="khalti" required>
                        <label class="form-check-label" for="khalti">
                            <h5>Khalti</h5>
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked required>
                        <label class="form-check-label" for="cod">
                            <h5>Cash on Delivery</h5>
                        </label>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn theme-orange-btn text-light btn-sm rounded-pill px-3 py-2">
                            <h5>Place Order</h5>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- JavaScript for Khalti Modal Removed: Form directly submits to checkout.process -->
@else
<!-- Empty Cart -->
<section class="py-5">
    <div class="container">
        <div class="text-center">
            <i class="fa-solid fa-cart-shopping fa-4x text-muted mb-3"></i>
            <h3>Your cart is empty</h3>
            <p class="text-muted">Please add items to your cart before checkout.</p>
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="fa-solid fa-shopping-bag me-2"></i>Continue Shopping
            </a>
        </div>
    </div>
</section>
@endif

@endsection
