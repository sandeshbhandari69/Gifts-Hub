@extends('admin.includes.main')

@push('title')
    <title>Add Inventory</title>
@endpush

@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4 mt-4">
            <div class="card mb-4">
                <div class="card-body">

                    <h4 class="mt-2 mb-4">Add Inventory</h4>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('inventory.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Product <span class="text-danger">*</span></label>
                                <select name="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->p_id }}" {{ old('product_id') == $product->p_id ? 'selected' : '' }}>{{ $product->p_name }} ({{ $product->category->c_name ?? 'No Category' }})</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Warehouse Location <span class="text-danger">*</span></label>
                                <select name="location" class="form-select @error('location') is-invalid @enderror" required>
                                    <option value="">Select Warehouse</option>
                                    @foreach($locations as $loc)
                                        <option value="{{ $loc }}" {{ old('location') == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                                    @endforeach
                                </select>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Available Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="available" class="form-control @error('available') is-invalid @enderror" value="{{ old('available', 0) }}" min="0" required>
                                @error('available')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Reserved Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="reserved" class="form-control @error('reserved') is-invalid @enderror" value="{{ old('reserved', 0) }}" min="0" required>
                                @error('reserved')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">On Hand Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="on_hand" class="form-control @error('on_hand') is-invalid @enderror" value="{{ old('on_hand', 0) }}" min="0" required>
                                @error('on_hand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Unit Cost (Rs.)</label>
                                <input type="number" name="unit_cost" class="form-control @error('unit_cost') is-invalid @enderror" value="{{ old('unit_cost') }}" min="0" step="0.01">
                                @error('unit_cost')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('inventory.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Inventory</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </main>
@endsection