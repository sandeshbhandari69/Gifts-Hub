@extends('admin.includes.main')

@push('title')
<title>Add Product</title>
@endpush

@section('content')
<div id="layoutSidenav_content">
<main>

<div class="container-fluid px-4 mt-4">

    <div class="card p-4">

        <h5 class="mb-4">Add Product</h5>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.add-product') }}" enctype="multipart/form-data">
        @csrf

        <div class="row">

        {{-- LEFT SIDE FORM --}}
        <div class="col-lg-8">

            {{-- Product Name --}}
            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input 
                    type="text" 
                    name="p_name" 
                    class="form-control" 
                    placeholder="Enter Product Name"
                    value="{{ old('p_name') }}"
                >

                @error('p_name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>


            {{-- Price --}}
            <div class="mb-3">
                <label class="form-label">Price</label>
                <input 
                    type="text" 
                    name="p_price" 
                    class="form-control" 
                    placeholder="Enter Product Price"
                    value="{{ old('p_price') }}"
                >

                @error('p_price')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>


            {{-- Category --}}
            <div class="mb-3">
                <label class="form-label">Category</label>

                <select name="c_id" class="form-select">

                    <option value="">Select Category</option>

                    @foreach ($category as $cat)
                        <option value="{{ $cat->c_id }}">
                            {{ $cat->c_name }}
                        </option>
                    @endforeach

                </select>

                @error('c_id')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>


            {{-- Stock --}}
            <div class="mb-3">
                <label class="form-label">Stock Quantity</label>

                <input 
                    type="number" 
                    name="p_stock" 
                    class="form-control" 
                    placeholder="Enter Stock Quantity"
                    value="{{ old('p_stock') }}"
                >

                @error('p_stock')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>


            {{-- Status --}}
            <div class="mb-3">
                <label class="form-label">Product Status</label>

                <select name="status" class="form-select">
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="out_of_stock" {{ old('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    <option value="discontinued" {{ old('status') == 'discontinued' ? 'selected' : '' }}>Discontinued</option>
                </select>

                @error('status')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>


            {{-- Description --}}
            <div class="mb-3">
                <label class="form-label">Product Description</label>

                <textarea 
                    name="p_description" 
                    class="form-control" 
                    rows="3"
                    placeholder="Enter Product Description"
                >{{ old('p_description') }}</textarea>

                @error('p_description')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>


            {{-- Submit Button --}}
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    Add Product
                </button>
                <a href="{{ route('admin.view-product') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>

        </div>

        <div class="col-lg-4 d-flex flex-column align-items-center justify-content-center">

            <div class="text-center mb-3">

                <img 
                    id="preview"
                    src="https://via.placeholder.com/200"
                    class="rounded-circle shadow"
                    style="width:200px;height:200px;object-fit:cover;">

            </div>

            <label class="btn btn-dark btn-sm px-4">

                Choose Image

                <input 
                    type="file" 
                    name="p_image" 
                    id="image" 
                    accept="image/*" 
                    hidden
                    onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])"
                >

            </label>

        </div>

        </div>

        </form>

    </div>

</div>

</main>
@endsection