@extends('admin.includes.main')

@push('title')
    <title>Edit Category</title>
@endpush

@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4 mt-4">
            <div class="card p-4 mt-4">
                <div class="row">
                    <div class="col-xl-8 col-md-8">

                        {{-- Success Message --}}
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <h5 class="mb-4">Edit Category</h5>
                        <div class="row my-3">
                        <form method="POST" action="{{ url('admin/edit-category', $category->c_id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input type="text"
                                       name="c_name"
                                       class="form-control"
                                       placeholder="Enter category name"
                                       value="{{ old('c_name', $category->c_name) }}">
                                       @error('c_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    Update Category
                                </button>
                                <a href="{{ route('admin.view-category') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection