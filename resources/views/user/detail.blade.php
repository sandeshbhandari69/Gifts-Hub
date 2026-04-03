@extends('user.layouts.main')
@push('title')
    <title>Order Details</title>
@endpush
@section('content')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-5">
                        <div class="row my-5">
                            <div class="d-flex align-items-center mb-3">
                                <a href="{{ route('user.order.history') }}" class="text-decoration-none btn btn-secondary btn-sm me-3">
                                    <i class="fas fa-arrow-left me-1"></i> Back to Orders
                                </a>
                                <h4 class="mb-0">Order details: {{ $order->created_at->format('M d, Y') ?? 'January 15, 2024' }} ({{ count($order->items ?? []) ?: 3 }} Products)</h4>
                            </div>
                            
                            <div class="col-xl-6 col-md-6 mt-3 border border-primary p-3"> 
                                <h5 class="text-dark">Billing Address</h5>
                                <h6 class="text-dark">
                                    @if(isset($order->billing))
                                        {{ $order->billing['first_name'] }} {{ $order->billing['last_name'] }}<br>
                                        {{ $order->billing['address'] }}<br>
                                        {{ $order->billing['city'] }}, {{ $order->billing['state'] }} {{ $order->billing['pin_code'] }}<br>
                                        {{ $order->billing['country'] }}
                                    @else
                                        Sandesh Shrestha<br>
                                        123 Main Street<br>
                                        Kathmandu, Nepal 44600
                                    @endif
                                </h6>
                                <span class="text-dark"><strong>Email:</strong> {{ $order->billing['email'] ?? 'sandesh@example.com' }}</span><br>
                                <span class="text-dark"><strong>Phone:</strong> {{ $order->billing['phone'] ?? '(123) 456-7890' }}</span>
                            </div>
                            <div class="col-xl-6 col-md-6 mt-3 border border-primary p-3"> 
                                <h5 class="text-dark">Order Summary</h5>
                                <p class="text-dark"><strong>Order Id:</strong> {{ $order->order_id ?? '1001' }}</p>
                                <p class="text-dark"><strong>Payment Method:</strong> {{ ucfirst($order->payment_method ?? 'cod') }}</p>
                                <p class="text-dark"><strong>Sub Total:</strong> Rs. {{ number_format($order->total ?? 150.00, 2) }}</p>
                                <p class="text-dark"><strong>Discount:</strong> Rs. 0.00</p>
                                <p class="text-dark"><strong>Shipping Fee:</strong> Rs. 0.00</p><hr>
                                <h5 class="text-dark mt-3">Order Total: Rs. {{ number_format($order->total ?? 150.00, 2) }}</h5>
                                <div class="mt-2">
                                    <strong>Status:</strong> {!! $order->status_badge ?? '<span class="badge rounded-pill bg-success">Shipped</span>' !!}
                                </div>
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-xl-12 col-md-12 pd-3">
                                    <div class="position-relative m-4">

                                        <div class="progress" style="height:5px;">
                                            <div class="progress-bar" style="width:50%"></div>
                                        </div>

                                        <!-- Step 1 -->
                                        <button type="button"
                                            class="position-absolute top-0 translate-middle btn btn-sm btn-primary rounded-pill"
                                            style="left:0%; width:2rem; height:2rem;">
                                            1
                                        </button>
                                        <span class="position-absolute translate-middle text-center"
                                            style="left:0%; top:30px; font-size:12px; white-space:nowrap;">
                                            Order Received
                                        </span>

                                        <!-- Step 2 -->
                                        <button type="button"
                                            class="position-absolute top-0 translate-middle btn btn-sm @if(($order->status ?? 'shipped') === 'processing' || ($order->status ?? 'shipped') === 'shipped' || ($order->status ?? 'shipped') === 'delivered') btn-primary @else btn-secondary @endif rounded-pill"
                                            style="left:25%; width:2rem; height:2rem;">
                                            2
                                        </button>
                                        <span class="position-absolute translate-middle text-center"
                                            style="left:25%; top:30px; font-size:12px; white-space:nowrap;">
                                            Processing
                                        </span>

                                        <!-- Step 3 -->
                                        <button type="button"
                                            class="position-absolute top-0 translate-middle btn btn-sm @if(($order->status ?? 'shipped') === 'shipped' || ($order->status ?? 'shipped') === 'delivered') btn-primary @else btn-secondary @endif rounded-pill"
                                            style="left:50%; width:2rem; height:2rem;">
                                            3
                                        </button>
                                        <span class="position-absolute translate-middle text-center"
                                            style="left:50%; top:30px; font-size:12px; white-space:nowrap;">
                                            On the Way
                                        </span>

                                        <!-- Step 4 -->
                                        <button type="button"
                                            class="position-absolute top-0 translate-middle btn btn-sm @if(($order->status ?? 'shipped') === 'delivered') btn-primary @else btn-secondary @endif rounded-pill"
                                            style="left:100%; width:2rem; height:2rem;">
                                            4
                                        </button>
                                        <span class="position-absolute translate-middle text-center"
                                            style="left:100%; top:30px; font-size:12px; white-space:nowrap;">
                                            Delivered
                                        </span>

                                    </div>
                                </div>
                            </div>

                            <div class="row my-5">
                                <div class="col-lg-12">
                                    <table id="datatablesSimple">
                                        <thead>
                                            <tr>
                                            <th scope="col"><h5>Product</h5></th>
                                            <th scope="col"><h5>Price</h5></th>
                                            <th scope="col"><h5>Quantity</h5></th>
                                            <th scope="col"><h5>Sub Total</h5></th>
                                            </tr>
                                        </thead>
                                    <tbody>
                                        @if(isset($order->items) && count($order->items) > 0)
                                            @foreach($order->items as $item)
                                            <tr>
                                            <th>
                                                <div class="d-flex">
                                                    <div>    
                                                        <img src="{{ asset($item['image']) }}" class="img-fluid rounded" style="width: 70px;" alt="{{ $item['name'] }}">
                                                        </div>
                                                        <div class="p-3"><h6>{{ $item['name'] }}</h6></div>
                                                    </div>
                                                </th>
                                                <td>Rs. {{ number_format((float)str_replace(['$', 'Rs.', 'Rs '],'',$item['price']),2) }}</td>
                                                <td>{{ $item['quantity'] }}</td>
                                                <td>Rs. {{ number_format((float)str_replace(['$', 'Rs.', 'Rs '],'',$item['price']) * $item['quantity'],2) }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <!-- Sample order items for demo/sample orders -->
                                            <tr>
                                            <th>
                                                <div class="d-flex">
                                                    <div>    
                                                        <img src="{{ asset('assets/images/SubCategory/Gadgets/watch.png') }}" class="img-fluid rounded" style="width: 70px;" alt="Mar Watch">
                                                        </div>
                                                        <div class="p-3"><h6>Mar Watch</h6></div>
                                                </div>
                                            </th>
                                            <td>Rs. 100</td>
                                            <td>01</td>
                                            <td>Rs. 100</td>
                                            </tr>

                                            <tr>
                                            <th>
                                                <div class="d-flex">
                                                    <div>    
                                                        <img src="{{ asset('assets/images/Product/2.png') }}" class="img-fluid rounded" style="width: 70px;" alt="Cake">
                                                    </div>
                                                    <div class="p-3"><h6>Cake</h6></div>
                                                </div>
                                            </th>
                                            <td>Rs. 50</td>
                                            <td>01</td>
                                            <td>Rs. 50</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3"><h5>Total:</h5></th>
                                                <th><h5>Rs. {{ number_format($order->total ?? 150.00, 2) }}</h5></th>
                                            </tr>
                                        </tfoot>
                                    </table>  
                                </div> 
                            </div> 
                    </div>
                </main>
@endsection