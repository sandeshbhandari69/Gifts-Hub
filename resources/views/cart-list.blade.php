@extends('layouts.main')

@push('title')
<title>Cart Page</title>
@endpush

@section('content')

<!-- Page Header -->
<div class="container-fluid bg-light p-5">
    <h1 class="text-center text-secondary">
        <i class="fa-solid fa-cart-shopping"></i> Cart List
    </h1>
</div>

<!-- Cart List -->
<section>
<div class="container">
<div class="row">

<div class="col-lg-12">
<table class="table">
<thead>
<tr>
    <th><h4>Product</h4></th>
    <th><h4>Price</h4></th>
    <th><h4>Quantity</h4></th>
    <th><h4>Sub Total</h4></th>
    <th><h4>Remove</h4></th>
</tr>
</thead>

<tbody>

@if($cartItems && count($cartItems) > 0)

@foreach($cartItems as $item)

@php
    $cleanPrice = (float) preg_replace('/[^0-9.]/', '', $item['price']);
@endphp

<tr data-item-id="{{ $item['id'] }}" data-price="{{ $cleanPrice }}">

<td>
<div class="d-flex align-items-center">
    <img src="{{ $item['image'] }}"
         style="width:70px;"
         class="img-fluid rounded"
         onerror="this.src='{{ asset('assets/images/product/1.png') }}'">

    <div class="p-3">
        <h5>{{ $item['name'] }}</h5>
    </div>
</div>
</td>

<td>Rs. {{ number_format($cleanPrice,2) }}</td>

<td>
<div class="d-flex align-items-center gap-2">

<button class="btn btn-sm btn-outline-secondary"
onclick="adjustQty('{{ $item['id'] }}', -1)">-</button>

<span class="quantity-display quantity-{{ $item['id'] }}">
{{ $item['quantity'] }}
</span>

<button class="btn btn-sm btn-outline-secondary"
onclick="adjustQty('{{ $item['id'] }}', 1)">+</button>

</div>
</td>

<td class="item-subtotal">
Rs. {{ number_format($cleanPrice * $item['quantity'],2) }}
</td>

<td>
<form action="{{ route('cart.remove') }}" method="POST">
@csrf
<input type="hidden" name="id" value="{{ $item['id'] }}">
<button type="submit" class="btn-close"></button>
</form>
</td>

</tr>

@endforeach

@else

<tr>
<td colspan="5" class="text-center py-4">
<h4>Your cart is empty</h4>
</td>
</tr>

@endif

</tbody>
</table>
</div>

<!-- Price Summary -->
<div class="col-lg-5 ms-auto my-5">

<h3>Price Details</h3><hr>

<div class="d-flex">
    <h5>Subtotal:</h5>
    <h5 class="ms-auto" id="cartSubtotal">Rs. 0</h5>
</div>

<div class="d-flex">
    <h5>Discount:</h5>
    <h5 class="ms-auto" id="cartDiscount">Rs. 0</h5>
</div>

<div class="d-flex">
    <h5>Shipping:</h5>
    <h5 class="ms-auto">Free</h5>
</div>

<hr>

<div class="d-flex">
    <h4>Total:</h4>
    <h5 class="ms-auto" id="cartTotal">Rs. 0</h5>
</div>

<a href="{{ url('checkout/product') }}"
class="btn btn-primary w-100 mt-3">
Proceed to Checkout
</a>

</div>

</div>
</div>
</section>


<!-- ================= JS FIXED ================= -->
<script>

let cartQuantities = {};

document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('tr[data-item-id]').forEach(row => {
        let id = row.dataset.itemId;
        let qty = parseInt(row.querySelector('.quantity-display').textContent);
        cartQuantities[id] = qty;
    });

    updateCartTotals();
});


function adjustQty(id, change) {

    let qty = cartQuantities[id] || 1;
    qty = Math.max(1, Math.min(99, qty + change));

    cartQuantities[id] = qty;

    document.querySelector('.quantity-' + id).textContent = qty;

    updateSubtotal(id);
    updateCartTotals();
    updateServer(id, qty);
}


function updateSubtotal(id) {

    let row = document.querySelector(`tr[data-item-id="${id}"]`);
    let price = parseFloat(row.dataset.price);
    let qty = cartQuantities[id];

    let subtotal = price * qty;

    row.querySelector('.item-subtotal').textContent =
        'Rs. ' + subtotal.toLocaleString('en-US', {minimumFractionDigits:2});
}


function updateCartTotals() {

    let subtotal = 0;

    document.querySelectorAll('tr[data-item-id]').forEach(row => {

        let id = row.dataset.itemId;
        let price = parseFloat(row.dataset.price);
        let qty = cartQuantities[id];

        subtotal += price * qty;
    });

    let discount = subtotal * 0.10; // 10% discount
    let total = subtotal - discount;

    document.getElementById('cartSubtotal').textContent =
        'Rs. ' + subtotal.toLocaleString('en-US', {minimumFractionDigits:2});

    document.getElementById('cartDiscount').textContent =
        'Rs. ' + discount.toLocaleString('en-US', {minimumFractionDigits:2});

    document.getElementById('cartTotal').textContent =
        'Rs. ' + total.toLocaleString('en-US', {minimumFractionDigits:2});
}


function updateServer(id, qty) {

    fetch('{{ route("cart.update.quantity") }}', {
        method: 'POST',
        headers: {
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body: JSON.stringify({
            id:id,
            quantity:qty
        })
    });
}

</script>

@endsection