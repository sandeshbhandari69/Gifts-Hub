@extends('layouts.main')

@push('title')
<title>{{ $product->p_name ?? 'Product Detail' }} - Gifts Hub</title>
@endpush

@section('content')

<!-- Page Header -->
<div class="container-fluid bg-light p-5">
    <h1 class="text-center">
        <i class="fa-solid fa-layer-group"></i> Product Detail
    </h1>
</div>

<!-- Product Detail 1 -->
<section class="my-5">
    <div class="container">
        <div class="row">
            <!-- Product Image -->
            <div class="col-lg-4 mb-4">
                <img src="{{ asset($product->p_image ? 'storage/'.$product->p_image : 'assets/images/product/1.png') }}"
                     class="img-fluid rounded" alt="{{ $product->p_name ?? 'Product' }}">
            </div>
           
            <!-- Product Info -->
            <div class="col-lg-8">
                <h2>{{ $product->p_name ?? 'Product Name' }}</h2>
                <h5>Rs. {{ number_format($product->p_price, 2) }}</h5>
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
                        <h6>{{ rand(1, 5) }} Customer Reviews</h6>
                        </div>
                    </div>
                </div>

                <p>
                    {{ $product->p_description ?? 'A premium quality product from Gifts Hub. This item is carefully selected to provide the best experience for our customers.' }}
                </p>

                <div>
                    <div class="d-flex flex-row mb-3">
                        <div class="p-1"><h6>Quantity</h6></div>
                        <div class="p-1">
                            <button class="btn btn-secondary rounded-start-pill" onclick="decreaseQuantity()">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                            <span id="quantity" class="px-3">1</span>
                            <button class="btn btn-secondary rounded-end-pill" onclick="increaseQuantity()">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->p_id }}">
                    <input type="hidden" name="name" value="{{ $product->p_name ?? 'Product' }}">
                    <input type="hidden" name="price" value="{{ $product->p_price ?? 0 }}">
                    <input type="hidden" name="image" value="{{ $product->p_image ? asset('storage/'.$product->p_image) : asset('assets/images/product/1.png') }}">
                    <input type="hidden" name="quantity" id="cart_quantity" value="1">
                    
                    <button type="submit" class="btn theme-green-btn text-light rounded-pill me-2">
                        Add to Cart
                    </button>
                </form>
                
                <form action="{{ route('cart.add') }}" method="POST" class="d-inline me-2">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->p_id }}">
                    <input type="hidden" name="name" value="{{ $product->p_name ?? 'Product' }}">
                    <input type="hidden" name="price" value="{{ $product->p_price ?? 0 }}">
                    <input type="hidden" name="image" value="{{ $product->p_image ? asset('storage/'.$product->p_image) : asset('assets/images/product/1.png') }}">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="redirect_to" value="checkout">
                    <button type="submit" class="btn theme-orange-btn text-light rounded-pill">
                        Buy Now
                    </button>
                </form>
            </div>
        </div>

        <!-- Product Description -->
        <div class="my-5">
            <h4>Product Description</h4>
            <p>
                {{ $product->p_description ?? 'This premium product from Gifts Hub represents the finest quality and craftsmanship. Each item is carefully selected to ensure customer satisfaction and provide an exceptional gifting experience. Perfect for any occasion, this product combines functionality with elegant design to create a memorable gift that will be cherished for years to come.' }}
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
            <a href="{{ route('home') }}" class="btn btn-sm theme-green-btn text-light rounded-pill">View All</a>
            </div>
        </div>

        <div class="row">
            @forelse($relatedProducts as $relatedProduct)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100">
                    <a href="{{ route('product.detail', ['slug' => Str::slug($relatedProduct->p_name)]) }}">
                        @if($relatedProduct->p_image && !empty($relatedProduct->p_image))
                            <img src="{{ asset('storage/'.$relatedProduct->p_image) }}" class="card-img-top" alt="{{ $relatedProduct->p_name }}" onerror="this.src='{{ asset('assets/images/product/1.png') }}';">
                        @else
                            <img src="{{ asset('assets/images/product/1.png') }}" class="card-img-top" alt="{{ $relatedProduct->p_name }}">
                        @endif
                    </a>
                    <div class="card-body text-center">
                        <h6>{{ $relatedProduct->p_name }}</h6>
                        <h5>Rs. {{ number_format($relatedProduct->p_price, 2) }}</h5>
                        <div class="d-flex gap-2 justify-content-center mt-2">
                            <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="id" value="{{ $relatedProduct->p_id }}">
                                <input type="hidden" name="name" value="{{ $relatedProduct->p_name }}">
                                <input type="hidden" name="price" value="{{ $relatedProduct->p_price }}">
                                <input type="hidden" name="image" value="{{ asset('storage/'.$relatedProduct->p_image) }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-sm btn-primary">Add to Cart</button>
                            </form>
                            <a href="{{ route('product.detail', ['slug' => Str::slug($relatedProduct->p_name)]) }}" class="btn btn-sm btn-outline-secondary">View</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4">
                <p class="text-muted">No related products found.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<hr>

<!-- Reviews -->
<section class="my-5">
    <div class="container">
        <h2>{{ count($reviews ?? []) }} Reviews</h2>

        @if(isset($reviews) && count($reviews) > 0)
            @foreach($reviews as $review)
            <!-- Review {{ $loop->index + 1 }} -->
            <div class="row mt-4">
                <div class="col-2 col-md-1">
                    <img src="{{ asset('assets/images/Review/user.png') }}"
                         class="rounded-circle img-fluid"
                         style="width:70px;height:70px;object-fit:cover;">
                </div>

                <div class="col-10 col-md-11">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ $review['name'] }}</h5>
                            <small>{{ $review['created_at'] }}</small>
                        </div>
                        <div>
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review['rating'])
                                    <span class="fa fa-star checked"></span>
                                @else
                                    <span class="fa fa-star"></span>
                                @endif
                            @endfor
                        </div>
                    </div>

                    <p class="mt-2">
                        {{ $review['comment'] }}
                    </p>

                    <a href="#" class="btn theme-orange-btn btn-sm text-light rounded-pill">
                        Reply
                    </a>
                </div>
            </div>
            @endforeach
        @else
            <div class="text-center py-5">
                <i class="fa-solid fa-comment fa-3x text-muted mb-3"></i>
                <h4>No reviews yet</h4>
                <p class="text-muted">Be the first to review this product!</p>
            </div>
        @endif
    </div>
</section>

<section>
    <div class="container bg-light p-4">
        <h3>Add a Review</h3>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
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
        
        <form action="{{ route('review.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->p_id }}">
            <input type="hidden" name="product_name" value="{{ $product->p_name ?? 'Product' }}">
            
            <div class="form-text mb-3">Rate this Product.
                <div class="star-rating">
                    <span class="fa fa-star" data-rating="1"></span>
                    <span class="fa fa-star" data-rating="2"></span>
                    <span class="fa fa-star" data-rating="3"></span>
                    <span class="fa fa-star" data-rating="4"></span>
                    <span class="fa fa-star" data-rating="5"></span>
                </div>
                <input type="hidden" name="rating" id="rating" value="0" required>
            </div>
            
            <div class="row mb-3">
                <div class="col-lg-6 mb-3">
                    <input type="text" class="form-control form-control-lg" name="name" placeholder="Your Name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-lg-6 mb-3">
                    <input type="email" class="form-control form-control-lg" name="email" placeholder="Your Email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="col-lg-12 mb-3">
                <textarea class="form-control form-control-lg" name="comment" rows="7" placeholder="Your Review" required>{{ old('comment') }}</textarea>
                @error('comment')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            
            <div>
                <button type="submit" class="btn theme-orange-btn text-light rounded-pill">
                    Post a Comment <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </form>
    </div>
</section>

<script>
// Star rating functionality for review form
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-rating .fa-star');
    const ratingInput = document.getElementById('rating');
    let currentRating = 0;
    
    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            currentRating = index + 1;
            ratingInput.value = currentRating;
            updateStars();
        });
        
        star.addEventListener('mouseenter', function() {
            highlightStars(index + 1);
        });
    });
    
    document.querySelector('.star-rating').addEventListener('mouseleave', function() {
        updateStars();
    });
    
    function updateStars() {
        stars.forEach((star, index) => {
            if (index < currentRating) {
                star.classList.add('checked');
            } else {
                star.classList.remove('checked');
            }
        });
    }
    
    function highlightStars(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.add('checked');
            } else {
                star.classList.remove('checked');
            }
        });
    }
});

function increaseQuantity() {
    const quantityElement = document.getElementById('quantity');
    const cartQuantityElement = document.getElementById('cart_quantity');
    let currentQuantity = parseInt(quantityElement.textContent);
    currentQuantity++;
    quantityElement.textContent = currentQuantity;
    cartQuantityElement.value = currentQuantity;
}

function decreaseQuantity() {
    const quantityElement = document.getElementById('quantity');
    const cartQuantityElement = document.getElementById('cart_quantity');
    let currentQuantity = parseInt(quantityElement.textContent);
    if (currentQuantity > 1) {
        currentQuantity--;
        quantityElement.textContent = currentQuantity;
        cartQuantityElement.value = currentQuantity;
    }
}

// Star rating functionality for review form
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.fa-star');
    let currentRating = 0;
    
    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            currentRating = index + 1;
            updateStars();
        });
        
        star.addEventListener('mouseenter', function() {
            highlightStars(index + 1);
        });
    });
    
    document.querySelector('.fa-star').parentElement.addEventListener('mouseleave', function() {
        updateStars();
    });
    
    function updateStars() {
        stars.forEach((star, index) => {
            if (index < currentRating) {
                star.classList.add('checked');
            } else {
                star.classList.remove('checked');
            }
        });
    }
    
    function highlightStars(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.add('checked');
            } else {
                star.classList.remove('checked');
            }
        });
    }
});
</script>

@endsection
