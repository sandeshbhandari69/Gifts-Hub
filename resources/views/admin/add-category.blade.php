@extends('admin.includes.main')

@push('title')
    <title>Add Category</title>
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

                        <h5 class="mb-4">Add Category</h5>

                        <form method="POST" action="{{ route('admin.add-category') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input type="text"
                                       name="c_name"
                                       class="form-control"
                                       placeholder="Enter category name"
                                       value="{{ old('c_name') }}">
                                @error('c_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    Add Category
                                </button>
                                <a href="{{ route('admin.view-category') }}" class="btn btn-secondary">
                                    View Categories
                                </a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection