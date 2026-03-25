@extends('layouts.main')
@push('title')
    <title>Home Page</title>
@endpush
@push('styles')
<style>
.product-btn-equal {
    min-height: 32px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 0.75rem !important;
    padding: 0.25rem 0.5rem !important;
}
.custom-btn-container {
    justify-content: space-between !important;
}
.product-img {
    height: 200px;
    object-fit: cover;
}
.category-img {
    height: 180px;
    object-fit: cover;
}
</style>
@endpush
@section('content')

<section class="hero-section">
  <div class="container">
      <div class="hero-content">
          <h1 class="hero-title">
            The Perfect <br>
            Gift <br>
            <span>Finds You</span>
          </h1>

          <p class="hero-text">
            Discover curated gifts for every occasion, handpicked to create
            moments of joy and celebration.
          </p>
          <a href="{{ route('categories') }}" class="btn theme-orange-btn">Explore Now</a>
      </div>
  </div>
</section>


<!-- product section -->
<section class="my-5">
    <div class="container">
    <div class="d-flex align-items-center mb-4">
        <div class="flex-grow-1">
            <span class="badge-purple">Recommendations</span>
            <h2 class="section-title mb-0">Top Deals</h2>
        </div>
        <div><a href="{{ route('categories') }}" class="view-all-btn">View All <i class="fa-solid fa-arrow-right ms-1"></i></a></div>
    </div>
        <div class="row theme-product">
            @forelse($products->take(4) as $product)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100">
                    <a href="{{ route('product.detail', ['slug' => Str::slug($product->p_name)]) }}">
                        @if($product->p_image && !empty($product->p_image))
                            <img src="{{ asset('storage/'.$product->p_image) }}" class="card-img-top product-img" alt="{{ $product->p_name }}" onerror="this.src='{{ asset('assets/images/product/1.png') }}';">
                        @else
                            <img src="{{ asset('assets/images/product/1.png') }}" class="card-img-top product-img" alt="{{ $product->p_name }}">
                        @endif
                    </a>
                    <div class="card-body">
                        <h6 class="card-title text-center">
                            <a href="{{ route('product.detail', ['slug' => Str::slug($product->p_name)]) }}" class="text-dark text-decoration-none">
                                {{ $product->p_name }}
                            </a>
                        </h6>
                        <h5 class="card-title text-center">Rs. {{ number_format($product->p_price, 2) }}</h5>
                        <div class="d-flex gap-2 mt-2 custom-btn-container">
                            <form action="{{ route('cart.add') }}" method="POST" class="flex-fill">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->p_id }}">
                                <input type="hidden" name="name" value="{{ $product->p_name }}">
                                <input type="hidden" name="price" value="{{ $product->p_price }}">
                                <input type="hidden" name="image" value="{{ $product->p_image ? asset('storage/'.$product->p_image) : asset('assets/images/product/1.png') }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary btn-xs rounded-pill w-100 product-btn-equal custom-btn">
                                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                </button>
                            </form>
                            <form action="{{ route('wishlist.store') }}" method="POST" class="flex-fill">
                                @csrf
                                <input type="hidden" name="product_name" value="{{ $product->p_name }}">
                                <input type="hidden" name="product_price" value="{{ $product->p_price }}">
                                <input type="hidden" name="product_image" value="{{ $product->p_image ? asset('storage/'.$product->p_image) : asset('assets/images/product/1.png') }}">
                                <button type="submit" class="btn btn-outline-danger btn-xs rounded-pill w-100 product-btn-equal custom-btn">
                                    <i class="fa-regular fa-heart"></i> Wishlist
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-box fa-3x text-muted mb-3"></i>
                <p class="text-muted">No products available yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- More Products -->
@if($products->count() > 4)
<section class="my-5">
    <div class="container">
    <div class="d-flex align-items-center mb-4">
        <div class="flex-grow-1">
            <span class="badge-purple">Hot</span>
            <h2 class="section-title mb-0">More Products</h2>
        </div>
    </div>
        <div class="row theme-product">
            @foreach($products->slice(4) as $product)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100">
                    <a href="{{ route('product.detail', ['slug' => Str::slug($product->p_name)]) }}">
                        @if($product->p_image && !empty($product->p_image))
                            <img src="{{ asset('storage/'.$product->p_image) }}" class="card-img-top product-img" alt="{{ $product->p_name }}" onerror="this.src='{{ asset('assets/images/product/1.png') }}';">
                        @else
                            <img src="{{ asset('assets/images/product/1.png') }}" class="card-img-top product-img" alt="{{ $product->p_name }}">
                        @endif
                    </a>
                    <div class="card-body">
                        <h6 class="card-title text-center">
                            <a href="{{ route('product.detail', ['slug' => Str::slug($product->p_name)]) }}" class="text-dark text-decoration-none">
                                {{ $product->p_name }}
                            </a>
                        </h6>
                        <h5 class="card-title text-center">Rs. {{ number_format($product->p_price, 2) }}</h5>
                        <div class="d-flex gap-2 mt-2">
                            <form action="{{ route('cart.add') }}" method="POST" class="flex-fill">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->p_id }}">
                                <input type="hidden" name="name" value="{{ $product->p_name }}">
                                <input type="hidden" name="price" value="{{ $product->p_price }}">
                                <input type="hidden" name="image" value="{{ $product->p_image ? asset('storage/'.$product->p_image) : asset('assets/images/product/1.png') }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary btn-xs rounded-pill w-100 product-btn-equal">
                                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                </button>
                            </form>
                            <form action="{{ route('wishlist.store') }}" method="POST" class="flex-fill">
                                @csrf
                                <input type="hidden" name="product_name" value="{{ $product->p_name }}">
                                <input type="hidden" name="product_price" value="{{ $product->p_price }}">
                                <input type="hidden" name="product_image" value="{{ $product->p_image ? asset('storage/'.$product->p_image) : asset('assets/images/product/1.png') }}">
                                <button type="submit" class="btn btn-outline-danger btn-xs rounded-pill w-100 product-btn-equal">
                                    <i class="fa-regular fa-heart"></i> Wishlist
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Gift Categories -->
<section class="my-5">
    <div class="container">
    <div class="d-flex align-items-center mb-4">
        <div class="flex-grow-1">
            <span class="badge-purple">Browse</span>
            <h2 class="section-title mb-0">Gift Categories</h2>
        </div>
        <div><a href="{{ route('categories') }}" class="view-all-btn">All Categories <i class="fa-solid fa-arrow-right ms-1"></i></a></div>
    </div>
        <div class="row theme-product">
            @forelse($categories->take(4) as $category)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100">
                    <a href="{{ route('subcategory.index', ['slug' => Str::slug($category->c_name)]) }}">
                        <div class="bg-light d-flex align-items-center justify-content-center category-img">
                            <i class="fas fa-folder fa-3x text-muted"></i>
                        </div>
                    </a>
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <a href="{{ route('subcategory.index', ['slug' => Str::slug($category->c_name)]) }}" class="text-dark text-decoration-none">
                                {{ $category->c_name }}
                            </a>
                        </h6>
                        <small class="text-muted">{{ $category->products_count }} products</small>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-list fa-3x text-muted mb-3"></i>
                <p class="text-muted">No categories available yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
