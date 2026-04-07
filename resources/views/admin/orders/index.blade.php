@extends('admin.includes.main')

@section('title')
    <title>Manage Orders - Admin</title>
@endsection

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4 mb-4">Manage Orders</h1>
                
                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary h-100">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-uppercase text-primary small fw-bold">Total Orders</div>
                                        <div class="h4 mb-0 fw-bold">{{ $totalOrders }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-shopping-bag fa-2x text-primary opacity-25"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success h-100">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-uppercase text-success small fw-bold">Total Sales</div>
                                        <div class="h4 mb-0 fw-bold">Rs. {{ number_format($totalSales, 2) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-success opacity-25"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters and Bulk Actions -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3 mb-3">
                                    <div class="col-md-3">
                                        <label for="search" class="form-label">Search</label>
                                        <input type="text" class="form-control" id="search" name="search" 
                                               value="{{ request('search') }}" placeholder="Search by Order ID or Customer">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="">All Status</option>
                                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            <option value="on_the_way" {{ request('status') == 'on_the_way' ? 'selected' : '' }}>On the way</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="from_date" class="form-label">From Date</label>
                                        <input type="date" class="form-control" id="from_date" name="from_date" 
                                               value="{{ request('from_date') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="to_date" class="form-label">To Date</label>
                                        <input type="date" class="form-control" id="to_date" name="to_date" 
                                               value="{{ request('to_date') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-search me-2"></i> Filter
                                        </button>
                                    </div>
                                </form>
                                
                                <!-- Bulk Actions -->
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" id="selectAll" class="form-check-input me-2">
                                            <label for="selectAll" class="form-check-label me-3">Select All</label>
                                            <select id="bulkStatus" class="form-select me-2" style="width: auto;">
                                                <option value="">Update Status...</option>
                                                <option value="processing">Processing</option>
                                                <option value="shipped">Shipped</option>
                                                <option value="delivered">Delivered</option>
                                                <option value="cancelled">Cancelled</option>
                                                <option value="on_the_way">On the way</option>
                                            </select>
                                            <button type="button" id="bulkUpdateBtn" class="btn btn-warning" disabled>
                                                <i class="fas fa-edit me-1"></i> Update Selected
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <span class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            {{ $orders->count() }} orders found
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                @if($orders->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" id="selectAllTable" class="form-check-input">
                                                    </th>
                                                    <th>Order ID</th>
                                                    <th>Customer</th>
                                                    <th>Date</th>
                                                    <th>Total</th>
                                                    <th>Payment Method</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($orders as $order)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="order-checkbox form-check-input" value="{{ $order->id }}">
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold">#{{ $order->order_id }}</span>
                                                    </td>
                                                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                    <td class="fw-bold text-success">Rs. {{ number_format($order->total, 2) }}</td>
                                                    <td>
                                                        <span class="badge bg-light text-dark">
                                                            {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                                                        </span>
                                                    </td>
                                                    <td>{!! $order->status_badge !!}</td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('admin.orders.show', $order->id) }}" 
                                                               class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-eye me-1"></i> View
                                                            </a>
                                                            <button type="button" class="btn btn-sm btn-outline-warning quick-status-btn" 
                                                                    data-order-id="{{ $order->id }}" data-current-status="{{ $order->status }}">
                                                                <i class="fas fa-edit me-1"></i> Quick Status
                                                            </button>
                                                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                        onclick="return confirm('Delete this order?')">
                                                                    <i class="fas fa-trash me-1"></i> Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-center mt-4">
                                        {{ $orders->links() }}
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted mb-3">No orders found</h5>
                                        <p class="text-muted">No orders match your current filters.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    <!-- Quick Status Modal -->
    <div class="modal fade" id="quickStatusModal" tabindex="-1" aria-labelledby="quickStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quickStatusModalLabel">Quick Status Update</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="quickStatusForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="quickOrderId" name="order_id">
                        <div class="mb-3">
                            <label for="quickStatusSelect" class="form-label">Order Status</label>
                            <select class="form-select" id="quickStatusSelect" name="status" required>
                                <option value="">Select Status...</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="on_the_way">On the way</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-1"></i> Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
</div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        const selectAllTable = document.getElementById('selectAllTable');
        const orderCheckboxes = document.querySelectorAll('.order-checkbox');
        const bulkUpdateBtn = document.getElementById('bulkUpdateBtn');
        const bulkStatus = document.getElementById('bulkStatus');
        const quickStatusModal = new bootstrap.Modal(document.getElementById('quickStatusModal'));
        
        // Handle select all checkboxes
        function toggleSelectAll() {
            orderCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked || selectAllTable.checked;
            });
            updateBulkButton();
        }
        
        selectAll.addEventListener('change', toggleSelectAll);
        selectAllTable.addEventListener('change', toggleSelectAll);
        
        // Handle individual checkbox changes
        orderCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateBulkButton();
                updateSelectAllState();
            });
        });
        
        function updateSelectAllState() {
            const totalCheckboxes = orderCheckboxes.length;
            const checkedCheckboxes = document.querySelectorAll('.order-checkbox:checked').length;
            
            selectAll.checked = totalCheckboxes === checkedCheckboxes;
            selectAllTable.checked = totalCheckboxes === checkedCheckboxes;
            selectAll.indeterminate = checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes;
        }
        
        function updateBulkButton() {
            const selectedCount = document.querySelectorAll('.order-checkbox:checked').length;
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
            const selectedIds = Array.from(document.querySelectorAll('.order-checkbox:checked'))
                                    .map(cb => cb.value);
            const status = bulkStatus.value;
            
            if (selectedIds.length === 0 || !status) {
                alert('Please select orders and a status to update');
                return;
            }
            
            if (confirm(`Update status for ${selectedIds.length} order(s) to ${status.replace('_', ' ')}?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.orders.bulk.update") }}';
                
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.appendChild(csrf);
                
                selectedIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'order_ids[]';
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
        
        // Handle quick status buttons
        document.querySelectorAll('.quick-status-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const orderId = this.getAttribute('data-order-id');
                const currentStatus = this.getAttribute('data-current-status');
                
                console.log('Order ID:', orderId);
                console.log('Current Status:', currentStatus);
                
                document.getElementById('quickOrderId').value = orderId;
                document.getElementById('quickStatusSelect').value = currentStatus;
                
                // Update form action
                document.getElementById('quickStatusForm').action = `/admin/orders/${orderId}`;
                
                quickStatusModal.show();
            });
        });
        
        // Handle quick status form submission
        document.getElementById('quickStatusForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const orderId = document.getElementById('quickOrderId').value;
            const status = document.getElementById('quickStatusSelect').value;
            
            console.log('Form submission - Order ID:', orderId);
            console.log('Form submission - Status:', status);
            console.log('Form action before setting:', this.action);
            
            if (!status) {
                alert('Please select a status');
                return;
            }
            
            if (!orderId) {
                alert('Order ID not found');
                return;
            }
            
            // Set the form action and submit
            this.action = `/admin/orders/${orderId}`;
            console.log('Form action after setting:', this.action);
            console.log('About to submit form...');
            
            this.submit();
        });
    });
    </script>
@endsection
