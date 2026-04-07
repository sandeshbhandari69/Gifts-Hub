@extends('admin.includes.main')
@push('title')
    <title>Edit Product</title>
@endpush

@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4 mt-4">
            <div class="card p-4 mt-4">
                <form method="POST" action="{{ route('admin.product.update', $product->p_id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-xl-8 col-md-8">
                            <h5 class="mb-4">Edit Product</h5>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                        <input name="p_name" type="text"
                                            class="form-control @error('p_name') is-invalid @enderror"
                                            value="{{ old('p_name', $product->p_name) }}" required>
                                        @error('p_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Price <span class="text-danger">*</span></label>
                                        <input name="p_price" type="number" step="0.01"
                                            class="form-control @error('p_price') is-invalid @enderror"
                                            value="{{ old('p_price', $product->p_price) }}" required>
                                        @error('p_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Category <span class="text-danger">*</span></label>
                                        <select name="c_id" class="form-select @error('c_id') is-invalid @enderror" required>
                                            <option value="">Select Category</option>
                                            @foreach ($category as $cat)
                                                <option value="{{ $cat->c_id }}" {{ old('c_id', $product->c_id) == $cat->c_id ? 'selected' : '' }}>
                                                    {{ $cat->c_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('c_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                                        <input name="p_stock" type="number"
                                            class="form-control @error('p_stock') is-invalid @enderror"
                                            value="{{ old('p_stock', $product->p_stock) }}" required>
                                        @error('p_stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Product Status <span class="text-danger">*</span></label>
                                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            <option value="out_of_stock" {{ old('status', $product->status) == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                            <option value="discontinued" {{ old('status', $product->status) == 'discontinued' ? 'selected' : '' }}>Discontinued</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Product Description <span class="text-danger">*</span></label>
                                        <textarea name="p_description"
                                            class="form-control @error('p_description') is-invalid @enderror"
                                            rows="3" required>{{ old('p_description', $product->p_description) }}</textarea>
                                        @error('p_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            Update Product
                                        </button>
                                        <a href="{{ route('admin.view-product') }}" class="btn btn-secondary">
                                            Cancel
                                        </a>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="col-md-4 d-flex flex-column align-items-center justify-content-center">

                            <div class="mb-3 text-center">
                                <img id="preview" src="{{ asset('storage/'.$product->p_image) }}" style="width: 200px; height: 200px; object-fit: cover;"
                                    class="rounded-circle shadow">
                            </div>

                            <label class="btn btn-dark btn-sm px-4">
                                Change Image
                                <input type="file" name="p_image" class="form-control d-none" id="image" accept="image/*"
                                    onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])">
                            </label>
                            <small class="text-muted mt-2">Leave empty to keep current image</small>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection