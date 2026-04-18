@extends('admin.includes.main')

@push('title')
    <title>View Products</title>
@endpush

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 mt-4">
                <div class="card p-4">
                    <div>
                        <div class="row">
                        <div class="col-xl-12 col-md-12">

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4>View Products</h4>
                                <a href="{{ route('admin.add-product') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Product
                                </a>
                            </div>

                            <!-- Bulk Actions -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="checkbox" id="selectAllProducts" class="form-check-input">
                                        <label for="selectAllProducts" class="form-check-label">Select All</label>
                                        <select id="bulkProductStatus" class="form-select" style="width: auto;">
                                            <option value="">Update Status...</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                            <option value="out_of_stock">Out of Stock</option>
                                            <option value="discontinued">Discontinued</option>
                                        </select>
                                        <button type="button" id="bulkProductUpdateBtn" class="btn btn-warning" disabled>
                                            <i class="fas fa-edit me-1"></i> Update Selected
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <table id="datatablesSimple" class="table table-hover">
                                        <thead>
                                            <tr>
                                            <th scope="col"><h5><input type="checkbox" id="selectAllTable" class="form-check-input"></h5></th>
                                            <th scope="col"><h5>Product</h5></th>
                                            <th scope="col"><h5>Price</h5></th>
                                            <th scope="col"><h5>Category</h5></th>
                                            <th scope="col"><h5>Stock</h5></th>
                                            <th scope="col"><h5>Status</h5></th>
                                            <th scope="col"><h5>Description</h5></th>
                                            <th scope="col"><h5>Action</h5></th>
                                            </tr>
                                        </thead>
                                    <tbody>

                                        @if ($products->count() > 0)
                                            @foreach ($products as $product)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="product-checkbox form-check-input" value="{{ $product->p_id }}">
                                                    </td>
                                                    <th>
                                                        <div class="d-flex">
                                                            <div>
                                                                @if($product->p_image && !empty($product->p_image))
                                                                    <img src="{{ asset('storage/'.$product->p_image) }}" class="img-fluid rounded" style="width: 70px; height: 70px; object-fit: cover;" alt="{{ $product->p_name }}" onerror="this.src='{{ asset('assets/images/product/1.png') }}';">
                                                                @else
                                                                    <img src="{{ asset('assets/images/product/1.png') }}" class="img-fluid rounded" style="width: 70px; height: 70px; object-fit: cover;" alt="{{ $product->p_name }}">
                                                                @endif
                                                                </div>
                                                                <div class="p-3"><h6>{{ $product->p_name }}</h6></div>
                                                            </div>
                                                    </th>
                                                    <td>Rs. {{ number_format($product->p_price, 2) }}</td>
                                                    <td>{{ $product->category->c_name ?? 'N/A' }}</td>
                                                    <td>{{ $product->p_stock }}</td>
                                                    <td>{!! $product->status_badge !!}</td>
                                                    <td>{{ Str::limit($product->p_description, 50) }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.edit-product', $product->p_id) }}" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <form action="{{ route('admin.delete-product', $product->p_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" class="text-center py-4 text-muted">
                                                    <i class="fas fa-box fa-2x mb-2"></i>
                                                    <p>No products found.</p>
                                                    <a href="{{ route('admin.add-product') }}" class="btn btn-sm btn-primary">Add First Product</a>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAllProducts');
        const selectAllTable = document.getElementById('selectAllTable');
        const productCheckboxes = document.querySelectorAll('.product-checkbox');
        const bulkUpdateBtn = document.getElementById('bulkProductUpdateBtn');
        const bulkStatus = document.getElementById('bulkProductStatus');
        
        // Handle select all checkboxes
        function toggleSelectAll() {
            productCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked || selectAllTable.checked;
            });
            updateBulkButton();
        }
        
        selectAll.addEventListener('change', toggleSelectAll);
        selectAllTable.addEventListener('change', toggleSelectAll);
        
        // Handle individual checkbox changes
        productCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateBulkButton();
                updateSelectAllState();
            });
        });
        
        function updateSelectAllState() {
            const totalCheckboxes = productCheckboxes.length;
            const checkedCheckboxes = document.querySelectorAll('.product-checkbox:checked').length;
            
            selectAll.checked = totalCheckboxes === checkedCheckboxes;
            selectAllTable.checked = totalCheckboxes === checkedCheckboxes;
            selectAll.indeterminate = checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes;
        }
        
        function updateBulkButton() {
            const selectedCount = document.querySelectorAll('.product-checkbox:checked').length;
            const hasValidStatus = bulkStatus.value !== '';
            bulkUpdateBtn.disabled = selectedCount === 0 || !hasValidStatus;
            
            if (selectedCount > 0) {
                bulkUpdateBtn.textContent = `Update Selected (${selectedCount})`;
            } else {
                bulkUpdateBtn.textContent = 'Update Selected';
            }
        }
        
        bulkStatus.addEventListener('change', updateBulkButton);
        
        // Handle bulk update
        bulkUpdateBtn.addEventListener('click', function() {
            const selectedIds = Array.from(document.querySelectorAll('.product-checkbox:checked'))
                                    .map(cb => cb.value);
            const status = bulkStatus.value;
            
            if (selectedIds.length === 0 || !status) {
                alert('Please select products and a status to update');
                return;
            }
            
            if (confirm(`Update status for ${selectedIds.length} product(s) to ${status.replace('_', ' ')}?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.products.bulk.update") }}';
                
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.appendChild(csrf);
                
                selectedIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'product_ids[]';
                    input.value = id;
                    form.appendChild(input);
                });
                
                const statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'status';
                statusInput.value = status;
                form.appendChild(statusInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
    </script>
@endsection