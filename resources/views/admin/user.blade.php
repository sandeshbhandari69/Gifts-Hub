@extends('admin.includes.main')
@push('title')
    <title>Manage Users</title>
@endpush

@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4 mt-4">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-body">
                    {{-- Header with title, search, and add button --}}
                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                        <h5 class="pt-3 mb-0">Manage Users</h5>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex gap-2">
                                <input type="text" name="search" class="form-control form-control-sm" 
                                       placeholder="Search users..." value="{{ request('search') }}">
                                <select name="status" class="form-select form-select-sm w-auto">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>Blocked</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                @if(request('search') || request('status'))
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-times"></i> Clear
                                    </a>
                                @endif
                            </form>
                            <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-success">
                                <i class="fas fa-plus"></i> Add User
                            </a>
                        </div>
                    </div>

                    {{-- Bulk Actions --}}
                    <form id="bulk-action-form" action="{{ route('admin.users.bulk') }}" method="POST">
                        @csrf
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <select name="action" class="form-select form-select-sm w-auto" id="bulk-action-select">
                                <option value="">Bulk Actions</option>
                                <option value="block">Block Selected</option>
                                <option value="unblock">Unblock Selected</option>
                                <option value="delete" class="text-danger">Delete Selected</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-outline-primary" id="apply-bulk-action" disabled>
                                Apply
                            </button>
                        </div>

                        {{-- Table --}}
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>
                                            <input type="checkbox" class="form-check-input" id="select-all">
                                        </th>
                                        <th>Sr. No.</th>
                                        <th>Customer Name</th>
                                        <th>Phone No.</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Registered</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $index => $user)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input user-checkbox" name="user_ids[]" value="{{ $user->id }}">
                                        </td>
                                        <td>{{ $users->firstItem() + $index }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->phone ?? 'N/A' }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ Str::limit($user->address ?? 'N/A', 30) }}</td>
                                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                                        <td>
                                            @if($user->is_blocked)
                                                <span class="badge bg-danger">Blocked</span>
                                            @else
                                                <span class="badge bg-success">Active</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($user->is_blocked)
                                                    <form action="{{ route('admin.users.unblock', $user->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Unblock" onclick="return confirm('Are you sure you want to unblock this user?')">
                                                            <i class="fas fa-unlock"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.users.block', $user->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-warning" title="Block" onclick="return confirm('Are you sure you want to block this user?')">
                                                            <i class="fas fa-ban"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-users fa-2x mb-2"></i>
                                                <p>No users found.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form>

                    {{-- Pagination --}}
                    <div class="d-flex flex-wrap align-items-center justify-content-between mt-3">
                        <div class="text-muted small">
                            Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} entries
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex align-items-center gap-2">
                                @foreach(request()->except('per_page', 'page') as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                <label for="perPage" class="form-label mb-0 text-muted">Show</label>
                                <select id="perPage" name="per_page" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                                <span class="text-muted">entries per page</span>
                            </form>
                            <nav>
                                {{ $users->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
<script>
    // Select All Checkbox
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActionButton();
    });

    // Individual Checkboxes
    document.querySelectorAll('.user-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAllCheckbox();
            updateBulkActionButton();
        });
    });

    // Bulk Action Select
    document.getElementById('bulk-action-select').addEventListener('change', updateBulkActionButton);

    function updateSelectAllCheckbox() {
        const allCheckboxes = document.querySelectorAll('.user-checkbox');
        const checkedCheckboxes = document.querySelectorAll('.user-checkbox:checked');
        const selectAll = document.getElementById('select-all');
        
        if (checkedCheckboxes.length === 0) {
            selectAll.checked = false;
            selectAll.indeterminate = false;
        } else if (checkedCheckboxes.length === allCheckboxes.length) {
            selectAll.checked = true;
            selectAll.indeterminate = false;
        } else {
            selectAll.checked = false;
            selectAll.indeterminate = true;
        }
    }

    function updateBulkActionButton() {
        const bulkAction = document.getElementById('bulk-action-select').value;
        const checkedCheckboxes = document.querySelectorAll('.user-checkbox:checked');
        const applyButton = document.getElementById('apply-bulk-action');
        
        applyButton.disabled = !bulkAction || checkedCheckboxes.length === 0;
    }

    // Confirm bulk action
    document.getElementById('bulk-action-form').addEventListener('submit', function(e) {
        const action = document.getElementById('bulk-action-select').value;
        const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
        
        if (!confirm(`Are you sure you want to ${action} ${checkedCount} selected user(s)?`)) {
            e.preventDefault();
        }
    });
</script>
@endpush