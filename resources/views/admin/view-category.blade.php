@extends('admin.includes.main')

@push('title')
<title>View Categories</title>
@endpush

@section('content')
<div id="layoutSidenav_content">
<main>
<div class="container-fluid px-4 mt-4">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5>View Categories</h5>
            <a href="{{ route('admin.add-category') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Category
            </a>
        </div>

        <div class="mt-3">
            <table id="datatablesSimple" class="table table-hover">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Category Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $index => $cat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $cat->c_name }}</td>
                        <td>
                            <a href="{{ route('admin.edit-category', $cat->c_id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <form method="POST" action="{{ route('admin.delete-category', $cat->c_id) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-muted">
                            <i class="fas fa-folder fa-2x mb-2"></i>
                            <p>No categories found.</p>
                            <a href="{{ route('admin.add-category') }}" class="btn btn-sm btn-primary">Add First Category</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</main>
@endsection