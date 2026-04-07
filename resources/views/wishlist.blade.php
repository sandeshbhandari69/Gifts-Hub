@extends('layouts.main')
@push('title')
    <title>My Wishlist - Gifts Hub</title>
@endpush
@section('content')
<div class="container my-5">
    <h2 class="mb-4 text-center">My Wishlist</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($wishlists->isEmpty())
        <div class="alert alert-info text-center">
            Your wishlist is empty. <a href="{{ route('home') }}">Start Shopping</a>
        </div>
    @else
        <div class="row theme-product">
            @foreach($wishlists as $item)
            <div class="col-lg-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $item->product_image }}" class="card-img-top p-3" alt="{{ $item->product_name }}" style="height: 250px; object-fit: contain;">
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title text-center">{{ $item->product_name }}</h6>
                        <h5 class="card-title text-center text-primary">{{ $item->product_price }}</h5>
                        <div class="mt-auto text-center">
                            <form action="{{ route('wishlist.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3" onclick="return confirm('Are you sure you want to remove this item from your wishlist?')">
                                    <i class="fas fa-trash"></i> Remove
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
