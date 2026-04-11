@extends('layouts.main')

@push('title')
<title>Checkout Page</title>
@endpush

@section('content')

<style>
/* ===== GLOBAL ===== */
body {
    background: #f5f7fb;
    font-family: 'Poppins', sans-serif;
}

/* ===== HEADER ===== */
.checkout-header {
    background: linear-gradient(135deg, #4e73df, #224abe);
    color: #fff;
    padding: 40px 0;
    border-radius: 0 0 20px 20px;
}

/* ===== CARD ===== */
.checkout-card {
    background: #fff;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    margin-bottom: 25px;
}

/* ===== INPUT ===== */
.form-control, .form-select {
    border-radius: 10px;
    padding: 12px;
    border: 1px solid #ddd;
    transition: 0.3s;
}

.form-control:focus, .form-select:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.1rem rgba(78,115,223,0.25);
}

/* ===== TABLE ===== */
.table {
    border-radius: 10px;
    overflow: hidden;
}

.table thead {
    background: #4e73df;
    color: #fff;
}

.table tbody tr {
    vertical-align: middle;
}

/* ===== PAYMENT ===== */
.payment-option {
    border: 1px solid #eee;
    padding: 12px 15px;
    border-radius: 10px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: 0.3s;
}

.payment-option:hover {
    border-color: #4e73df;
    background: #f0f4ff;
}

/* ===== BUTTON ===== */
.btn-place-order {
    background: #ff6600;
    color: #fff;
    border-radius: 50px;
    padding: 12px 25px;
    font-weight: 600;
    transition: 0.3s;
}

.btn-place-order:hover {
    background: #e65c00;
}

/* ===== EMPTY CART ===== */
.empty-cart {
    padding: 80px 0;
}
</style>

<!-- HEADER -->
<div class="checkout-header text-center">
    <h1><i class="fa-solid fa-cart-shopping"></i> Checkout</h1>
</div>

@if($cartItems && count($cartItems) > 0)

<div class="container my-5">

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf

        <div class="row">

            <!-- LEFT SIDE -->
            <div class="col-lg-7">

                <!-- BILLING -->
                <div class="checkout-card">
                    <h4 class="mb-3">Billing Details</h4>

                    <select class="form-select mb-3" name="country" required>
                        <option value="">Select Country</option>
                        <option>Nepal</option>
                        <option>India</option>
                        <option>USA</option>
                        <option>UK</option>
                    </select>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="tel" name="phone" class="form-control" placeholder="Phone Number" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                        </div>
                    </div>

                    <textarea class="form-control" name="address" rows="3" placeholder="Address" required></textarea>
                </div>

            </div>

            <!-- RIGHT SIDE -->
            <div class="col-lg-5">

                <!-- ORDER SUMMARY -->
                <div class="checkout-card">
                    <h4 class="mb-3">Your Order</h4>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $item['image'] }}" width="50" class="rounded me-2">
                                        <div>
                                            <small>{{ $item['name'] }}</small><br>
                                            <small>x{{ $item['quantity'] }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    Rs. {{ number_format((float)str_replace(['$', 'Rs.', 'Rs '],'',$item['price']) * $item['quantity'],2) }}
                                </td>
                            </tr>
                            @endforeach

                            <tr>
                                <th>Total</th>
                                <th>
                                    Rs. {{ number_format(collect($cartItems)->sum(function($item) {
                                        return (float)str_replace(['$', 'Rs.', 'Rs '], '', $item['price']) * $item['quantity'];
                                    }), 2) }}
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- PAYMENT -->
                <div class="checkout-card">
                    <h4 class="mb-3">Payment Method</h4>

                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="credit_card"> Credit Card
                    </label>

                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="esewa"> Esewa
                    </label>

                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="khalti"> Khalti
                    </label>

                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="cod" checked> Cash on Delivery
                    </label>

                    <button type="submit" class="btn btn-place-order w-100 mt-3">
                        Place Order
                    </button>
                </div>

            </div>

        </div>
    </form>

</div>

@else

<!-- EMPTY CART -->
<div class="empty-cart text-center">
    <i class="fa-solid fa-cart-shopping fa-4x text-muted mb-3"></i>
    <h3>Your cart is empty</h3>
    <a href="{{ route('home') }}" class="btn btn-primary mt-3">
        Continue Shopping
    </a>
</div>

@endif

@endsection