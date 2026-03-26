@extends('layouts.main')

@push('title')
<title>Product Detail</title>
@endpush

@section('content')

<!-- Page Header -->
<div class="container-fluid bg-light p-5">
    <h1 class="text-center">
        <i class="fa-solid fa-layer-group"></i> Product Detail
    </h1>
</div>

<!-- Product Detail  -->
<section class="my-5">
    <div class="container">
        <div class="row">
            <!-- Product Image -->
            <div class="col-lg-4 mb-4">
                <img src="{{ asset($product['image']) }}"
                     class="img-fluid rounded" alt="{{ $product['name'] }}" style="width: 100%; max-height: 400px; object-fit: contain;">
            </div>
           
            <!-- Product Info -->
            <div class="col-lg-8">
                <h2>{{ $product['name'] }}</h2>
                <h5>{{ $product['price'] }}</h5>
                <div>
                    <div class="d-flex flex-row mb-3">
                        <div>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                        </div>
                        <div class="p-1">    
                        <h6>2 Customer Reviews</h6>
                        </div>
                    </div>
                </div>

                <p>
                    {{ $product['name'] }} is a premium gift item perfect for your loved ones. 
                    Top quality and best price guaranteed.
                </p>

                <div>
                    <div class="d-flex flex-row mb-3">
                        <div class="p-1"><h6>Quantity</h6></div>
                        <div class="p-1">
                            <span class="btn btn-secondary rounded-start-pill"><i class="fa-solid fa-minus"></i></span>
                            <span>01</span>
                            <span class="btn btn-secondary rounded-end-pill"><i class="fa-solid fa-plus"></i></span>
                        </div>
                    
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="id" value="{{ md5($product['name'] ?? uniqid()) }}">
                        <input type="hidden" name="name" value="{{ $product['name'] ?? 'Product' }}">
                        <input type="hidden" name="price" value="{{ $product['price'] ?? '$0.00' }}">
                        <input type="hidden" name="image" value="{{ $product['image'] ?? 'assets/images/product/1.png' }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn theme-green-btn text-light rounded-pill me-2">
                            Add to Cart
                        </button>
                    </form>
                    <form action="{{ route('wishlist.store') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="product_name" value="{{ $product['name'] ?? 'Product' }}">
                        <input type="hidden" name="product_price" value="{{ $product['price'] ?? '$0.00' }}">
                        <input type="hidden" name="product_image" value="{{ $product['image'] ?? 'assets/images/product/1.png' }}">
                        <button type="submit" class="btn theme-green-btn text-light rounded-pill me-2">
                            <i class="fa-regular fa-heart"></i> Add to Wishlist
                        </button>
                    </form>
                    <form action="{{ route('cart.add') }}" method="POST" class="d-inline me-2">
                        @csrf
                        <input type="hidden" name="id" value="{{ md5($product['name'] ?? uniqid()) }}">
                        <input type="hidden" name="name" value="{{ $product['name'] ?? 'Product' }}">
                        <input type="hidden" name="price" value="{{ $product['price'] ?? '$0.00' }}">
                        <input type="hidden" name="image" value="{{ $product['image'] ?? 'assets/images/product/1.png' }}">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="redirect_to" value="checkout">
                        <button type="submit" class="btn theme-orange-btn text-light rounded-pill">
                            Buy Now
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Product Description -->
        <div class="my-5">
            <h4>Product Description</h4>
            <p>
                 Detailed description for {{ $product['name'] }} will go here. currently using mock description.
            </p>
        </div>
    </div>
</section>




<!-- Related Products -->
<section class="my-5">
    <div class="container">
        <div class="d-flex mb-3">
            <h2 class="flex-grow-1">Related Products</h2>
            <div class="ms-auto">
            <a href="#" class="btn btn-sm theme-green-btn text-light rounded-pill">View All</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <img src="{{ asset('assets/images/SubCategory/Gadgets/headphone.png') }}" class="card-img-top">
                    <div class="card-body text-center">
                        <h6>Headphone</h6>
                        <h5>$110.99</h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <img src="{{ asset('assets/images/SubCategory/Gadgets/Iphone.png') }}" class="card-img-top">
                    <div class="card-body text-center">
                        <h6>Iphone</h6>
                        <h5>$1299.99</h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <img src="{{ asset('assets/images/SubCategory/Gadgets/laptop.png') }}" class="card-img-top">
                    <div class="card-body text-center">
                        <h6>Hp Laptop</h6>
                        <h5>$799.99</h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <img src="{{ asset('assets/images/SubCategory/Gadgets/Tab.png') }}" class="card-img-top">
                    <div class="card-body text-center">
                        <h6>Samsung Tab</h6>
                        <h5>$499.99</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<hr>

<!-- Reviews -->
<section class="my-5">
    <div class="container">
        <h2>02 Reviews</h2>

        <!-- Review 1 -->
        <div class="row mt-4">
            <div class="col-2 col-md-1">
                <img src="{{ asset('assets/images/Review/user.png') }}"
                     class="rounded-circle img-fluid"
                     style="width:70px;height:70px;object-fit:cover;">
            </div>

            <div class="col-10 col-md-11">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="mb-0">John Doe</h5>
                        <small>18 Feb, 2026</small>
                    </div>
                    <div>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                    </div>
                </div>

                <p class="mt-2">
                    Great product! Really helped me during outdoor adventures.
                </p>

                <a href="#" class="btn theme-orange-btn btn-sm text-light rounded-pill">
                    Reply
                </a>
            </div>
        </div>

        <!-- Review 2 -->
        <div class="row mt-4">
            <div class="col-2 col-md-1">
                <img src="{{ asset('assets/images/Review/user.png') }}"
                     class="rounded-circle img-fluid"
                     style="width:70px;height:70px;object-fit:cover;">
            </div>

            <div class="col-10 col-md-11">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="mb-0">Alen Doe</h5>
                        <small>18 Jan, 2026</small>
                    </div>
                    <div>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                    </div>
                </div>

                <p class="mt-2">
                    Excellent quality and very useful product.
                </p>

                <a href="#" class="btn theme-orange-btn btn-sm text-light rounded-pill">
                    Reply
                </a>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container bg-light p-4">
        <h3>Add a Review</h3>
        <div class="row">
            <div class="col-lg-12">
               <form>
               <div class="form-text">Rate this Product.
                <span class="fa fa-star "></span>
                <span class="fa fa-star "></span>
                <span class="fa fa-star "></span>
                <span class="fa fa-star "></span>
                <span class="fa fa-star"></span>
               </div>
               <div class="row mb-5">
               <div class="col-lg-6 mb-3">
                <input type="text" class="form-control form-control-lg" placeholder="Your Name">
               </div>
                <div class="col-lg-6 mb-3">
                 <input type="email" class="form-control form-control-lg" placeholder="Your Email">
               </div>
                <div class="col-lg-12 mb-3">
                 <textarea class="form-control form-control-lg" rows="7" placeholder="Your Review"></textarea>
                </div>
                <div>
                <a href="#" class="btn theme-orange-btn text-light rounded-pill">
                    Post a Comment<i class="fa-solid fa-arrow-right"></i>
                </a>
                </div>
                </div>

               </form>
               
               </div>
        
            </div>

        </div>
       
</section>
@endsection
