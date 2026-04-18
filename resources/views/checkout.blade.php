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
    background: linear-gradient(135deg, #0891b2 0%, #14b8a6 50%, #10b981 100%);
    padding: 44px 0 40px;
    margin-bottom: 0;
}

/* ===== CARD ===== */
.checkout-card {
    background: #fff;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(250, 248, 248, 0.97);
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
<div class="checkout-header text-light text-center">
    <h1 ></i> Checkout</h1>
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

    <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
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

                    <button type="submit" class="btn btn-place-order w-100 mt-3" id="placeOrderBtn">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const placeOrderBtn = document.getElementById('placeOrderBtn');
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    
    // Add click handler for payment method selection
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            if (this.value === 'khalti') {
                placeOrderBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Pay with Khalti';
                placeOrderBtn.style.background = '#6a11cb';
            } else if (this.value === 'esewa') {
                placeOrderBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Pay with Esewa';
                placeOrderBtn.style.background = '#009900';
            } else {
                placeOrderBtn.innerHTML = 'Place Order';
                placeOrderBtn.style.background = '#ff6600';
            }
        });
    });
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        const selectedPayment = document.querySelector('input[name="payment_method"]:checked').value;
        
        if (selectedPayment === 'khalti' || selectedPayment === 'esewa') {
            // Show loading state for online payments
            placeOrderBtn.disabled = true;
            placeOrderBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Redirecting to payment...';
            
            // Add a small delay to show the loading state
            setTimeout(() => {
                form.submit();
            }, 500);
        } else {
            // Normal submission for COD and other methods
            placeOrderBtn.disabled = true;
            placeOrderBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
        }
    });
    
    // Initialize button text based on default selection
    const defaultPayment = document.querySelector('input[name="payment_method"]:checked');
    if (defaultPayment && defaultPayment.value === 'cod') {
        placeOrderBtn.innerHTML = 'Place Order';
        placeOrderBtn.style.background = '#ff6600';
    }
});
</script>

@endsection