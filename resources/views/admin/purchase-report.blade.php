@extends('admin.includes.main')

@push('title')
<title>Purchase Report</title>
@endpush

@push('styles')
<style>
@media print {
    body {
        font-size: 12px;
        line-height: 1.4;
    }
    
    .no-print {
        display: none !important;
    }
    
    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
        margin-bottom: 1rem !important;
    }
    
    .table {
        font-size: 11px;
    }
    
    .table th,
    .table td {
        padding: 8px 4px !important;
        border: 1px solid #ddd !important;
    }
    
    .bg-danger,
    .bg-info,
    .bg-secondary {
        background: #f8f9fa !important;
        color: #000 !important;
        border: 1px solid #ddd !important;
    }
    
    .text-white {
        color: #000 !important;
    }
    
    .btn {
        display: none !important;
    }
    
    .pagination,
    nav {
        display: none !important;
    }
    
    .container-fluid {
        max-width: 100% !important;
        padding: 10px !important;
    }
    
    h4 {
        font-size: 16px !important;
        margin-bottom: 10px !important;
    }
    
    .card-body {
        padding: 15px !important;
    }
    
    .row {
        margin: 0 !important;
    }
    
    .col-md-4 {
        padding: 5px !important;
        width: 33.33% !important;
        float: left !important;
    }
    
    @page {
        margin: 1cm;
        size: A4 portrait;
    }
    
    .table-responsive {
        overflow: visible !important;
    }
    
    .text-end {
        text-align: right !important;
    }
}
</style>
@endpush

@section('content')
<div id="layoutSidenav_content">
<main>
<div class="container-fluid px-4 mt-4">

<div class="card mb-4">
<div class="card-body">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Purchase Report</h4>
    <button onclick="window.print()" class="btn btn-outline-primary no-print">
        <i class="fas fa-print me-2"></i>Print Report
    </button>
</div>

{{-- Summary Cards --}}
<div class="row mb-4">

<div class="col-md-4">
<div class="card bg-danger text-white">
<div class="card-body">
<h6>Total Purchase</h6>
<h4>Rs. {{ number_format($totalPurchase, 2) }}</h4>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card bg-info text-white">
<div class="card-body">
<h6>Total Orders</h6>
<h4>{{ $totalOrders }}</h4>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card bg-secondary text-white">
<div class="card-body">
<h6>Average Purchase</h6>
<h4>
Rs. {{ number_format($averagePurchase, 2) }}
</h4>
</div>
</div>
</div>

</div>

{{-- Date Filter --}}
<form method="GET" action="{{ route('purchase.report') }}" class="no-print">
<div class="row mb-4">
<div class="col-md-4">
<label>From Date</label>
<input type="date" class="form-control" name="from_date" value="{{ request('from_date') }}">
</div>
<div class="col-md-4">
<label>To Date</label>
<input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}">
</div>
<div class="col-md-4 d-flex align-items-end gap-2">
<button type="submit" class="btn btn-primary">Filter</button>
@if(request('from_date') || request('to_date'))
    <a href="{{ route('purchase.report') }}" class="btn btn-secondary">Clear</a>
@endif
</div>
</div>
</form>

{{-- Table --}}
<div class="table-responsive">
<table class="table table-hover">
<thead class="table-light">
<tr>
<th>No</th>
<th>Date</th>
<th>Purchase ID</th>
<th>Supplier</th>
<th>Product</th>
<th>Quantity</th>
<th class="text-end">Amount</th>
</tr>
</thead>
<tbody>
@forelse($purchases as $index => $purchase)
<tr>
<td>{{ $purchases->firstItem() + $index }}</td>
<td>{{ $purchase->purchase_date->format('Y-m-d') }}</td>
<td>{{ $purchase->purchase_id }}</td>
<td>{{ $purchase->supplier }}</td>
<td>{{ $purchase->inventory->product_name ?? 'N/A' }}</td>
<td>{{ $purchase->quantity }}</td>
<td class="text-end">Rs. {{ number_format($purchase->total_amount, 2) }}</td>
</tr>
@empty
<tr>
<td colspan="7" class="text-center py-4 text-muted">
<i class="fas fa-shopping-bag fa-2x mb-2"></i>
<p>No purchases found.</p>
</td>
</tr>
@endforelse
</tbody>
<tfoot class="table-light">
<tr>
<th colspan="6" class="text-end">Total:</th>
<th class="text-end">Rs. {{ number_format($purchases->sum('total_amount'), 2) }}</th>
</tr>
</tfoot>
</table>
</div>

{{-- Pagination --}}
<div class="d-flex justify-content-between align-items-center mt-3 no-print">
<div class="text-muted small">
Showing {{ $purchases->firstItem() ?? 0 }} to {{ $purchases->lastItem() ?? 0 }} of {{ $purchases->total() }} entries
</div>
<nav>
{{ $purchases->withQueryString()->links('pagination::bootstrap-4') }}
</nav>
</div>

</div>
</div>

</div>
</main>
@endsection