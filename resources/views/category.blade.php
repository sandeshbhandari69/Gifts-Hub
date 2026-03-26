@extends('layouts.main')
@push('title')
    <title>Categories - Gifts Hub</title>
@endpush
@push('styles')
<style>
.category-img {
    height: 200px;
    object-fit: cover;
}
</style>
@endpush
@section('content')
<div class="container-fluid bg-white py-5 shadow-sm mb-5">
    <div class="container">
        <span class="badge-purple">Explore</span>
        <h1 class="section-title mt-2 mb-0">
            <i class="fa-solid fa-layer-group me-2"></i>
            Categories
        </h1>
    </div>
</div>

<!-- Categories List -->
<section class="my-5">
    <div class="container">
        <div class="row theme-product">
            @forelse($categories as $category)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100">
                    <a href="{{ route('categories.products', ['slug' => Str::slug($category->c_name)]) }}">
                        <div class="bg-light d-flex align-items-center justify-content-center category-img">
                            <i class="fas fa-folder fa-4x text-muted"></i>
                        </div>
                    </a>
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <a href="{{ route('categories.products', ['slug' => Str::slug($category->c_name)]) }}" class="text-dark text-decoration-none">
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