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
<section >
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col"><h4>Product</h4></th>
                    <th scope="col"><h4>Price</h4></th>
                    <th scope="col"><h4>Quantity</h4></th>
                    <th scope="col"><h4>Sub Total</h4></th>
                    <th scope="col"><h4>Remove</h4></th>
                    </tr>
                </thead>
                <tbody>
                    @if($cartItems && count($cartItems) > 0)
                        @foreach($cartItems as $item)
                        <tr data-item-id="{{ $item['id'] }}">
                            <th>
                                <div class="d-flex">
                                    <div>    
                                        <img src="{{ asset($item['image']) }}" class="img-fluid rounded" style="width: 70px;" class="rounded-3" alt="{{ $item['name'] }}">
                                    </div>
                                    <div class="p-3"><h5>{{ $item['name'] }}</h5></div>
                                </div>
                            </th>
                            <td>Rs. {{ number_format((float)str_replace(['$', 'Rs.', 'Rs '],'',$item['price']),2) }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-secondary rounded-start-pill quantity-btn" data-id="{{ $item['id'] }}" data-action="decrease">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>
                                    <span class="quantity-display quantity-{{ $item['id'] }} px-3">{{ $item['quantity'] }}</span>
                                    <button class="btn btn-secondary rounded-end-pill quantity-btn" data-id="{{ $item['id'] }}" data-action="increase">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="item-subtotal">Rs. {{ number_format((float)str_replace(['$', 'Rs.', 'Rs '],'',$item['price']) * $item['quantity'],2) }}</td>
                            <td>
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                    <button type="submit" class="btn-close" aria-label="Close" onclick="return confirm('Are you sure you want to remove this item from your cart?')"></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="empty-cart text-center">
                                    <i class="fa-solid fa-cart-shopping fa-4x text-muted mb-3"></i>
                                    <h4>Your cart is empty</h4>
                                    <p class="text-muted">Looks like you haven't added any items to your cart yet.</p>
                                    <a href="{{ route('home') }}" class="btn btn-primary">
                                        <i class="fa-solid fa-shopping-bag me-2"></i>Start Shopping
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            </div>
            <div class="col-lg-5 ms-auto my-5">
                <div>
                    <h3>Price Details</h3><hr>
                </div>
                    <div class="d-flex">
                        <div><h5>Subtotal:</h5></div>
                        <div class="ms-auto cart-subtotal"><h5>Rs. {{ number_format(collect($cartItems)->sum(function($item) { return (float)str_replace(['$', 'Rs.', 'Rs '], '', $item['price']) * $item['quantity']; }), 2) }}</h5></div>
                    </div>

                    <div class="d-flex">
                        <div><h5>Discount:</h5></div>
                        <div class="ms-auto"><h5>Rs. 0</h5></div>
                    </div>  

                    <div class="d-flex">
                        <div><h5>Shipping Cost:</h5></div>
                        <div class="ms-auto"><h5>Free</h5></div>
                    </div><hr>

                    <div class="d-flex">
                        <div><h4>Total:</h4></div>
                        <div class="ms-auto cart-total"><h5>Rs. {{ number_format(collect($cartItems)->sum(function($item) { return (float)str_replace(['$', 'Rs.', 'Rs '], '', $item['price']) * $item['quantity']; }), 2) }}</h5></div>  
                    </div>
                    <div class="mt-4"> <a href="{{url('checkout/product')}}" class="btn theme-orange-btn text-light btn-sm rounded-pill w-100">Proceed to Checkout</a></div>
            </div>



            </div>   
        </div>
    </div>
</section>

<script>
$(document).ready(function(){
    console.log('Cart page loaded');
    console.log('Cart items count:', {{ count($cartItems ?? []) }});
    
    // CSRF token for Laravel
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    $('.quantity-btn').click(function(e){
        e.preventDefault();
        
        var button = $(this);
        var itemId = button.data('id');
        var action = button.data('action');
        
        console.log('Button clicked:', itemId, action);
        console.log('Current quantity:', $('.quantity-' + itemId).text());
        console.log('Button exists:', button.length > 0);
        console.log('Item ID found:', itemId);
        
        if (!itemId) {
            console.error('No item ID found!');
            alert('Error: Item ID not found');
            return;
        }
        
        // Disable button to prevent multiple clicks
        button.prop('disabled', true);
        
        $.ajax({
            url: "{{ route('cart.update.quantity') }}",
            method: "POST",
            data: {
                id: itemId,
                action: action,
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function() {
                console.log('Sending AJAX request...');
            },
            success: function(response){
                console.log('AJAX Success:', response);
                
                if(response.success){
                    // Update quantity display
                    $('.quantity-' + itemId).text(response.quantity);
                    console.log('Updated quantity to:', response.quantity);
                    
                    // Update subtotal
                    var price = parseFloat(
                        $('tr[data-item-id="' + itemId + '"] td:nth-child(2)')
                        .text()
                        .replace('Rs. ','')
                    );
                    var newSubtotal = (price * response.quantity).toFixed(2);
                    $('tr[data-item-id="' + itemId + '"] .item-subtotal').text('Rs. ' + newSubtotal);
                    console.log('Updated subtotal to:', newSubtotal);
                    
                    // Update cart totals
                    updateCartTotals();
                    
                    console.log('Quantity updated successfully');
                } else {
                    console.error('Update failed:', response.message);
                    alert(response.message || 'Error updating quantity');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                console.log('Status:', status);
                console.log('Response Text:', xhr.responseText);
                console.log('XHR Object:', xhr);
                alert('Error updating quantity. Please check console for details.');
            },
            complete: function() {
                // Re-enable button
                button.prop('disabled', false);
                console.log('AJAX request completed');
            }
        });
    });
    
    function updateCartTotals(){
        var subtotal = 0;
        $('.item-subtotal').each(function(){
            var itemSubtotal = parseFloat(
                $(this).text().replace('Rs. ','')
            );
            subtotal += itemSubtotal;
        });
        
        $('.cart-subtotal h5').text('Rs. ' + subtotal.toFixed(2));
        $('.cart-total h5').text('Rs. ' + subtotal.toFixed(2));
        
        console.log('Cart totals updated:', subtotal);
    }
    
    // Initialize totals on page load
    updateCartTotals();
    
    // Log all quantity buttons found
    console.log('Quantity buttons found:', $('.quantity-btn').length);
    $('.quantity-btn').each(function() {
        console.log('Button data:', {
            id: $(this).data('id'),
            action: $(this).data('action')
        });
    });
});
</script>

@endsection
