@extends('admin.includes.main')

@push('title')
<title>Sales Report</title>
@endpush

@section('content')
<div id="layoutSidenav_content">
<main>
<div class="container-fluid px-4 mt-4">

<div class="card mb-4">
<div class="card-body">

<h4 class="mb-4">Sales Report</h4>

{{-- Summary Cards --}}
<div class="row mb-4">

<div class="col-md-4">
<div class="card bg-primary text-white">
<div class="card-body">
<h6>Total Sales</h6>
<h4>Rs. {{ number_format($totalSales, 2) }}</h4>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card bg-success text-white">
<div class="card-body">
<h6>Total Orders</h6>
<h4>{{ $totalOrders }}</h4>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card bg-warning text-white">
<div class="card-body">
<h6>Average Order</h6>
<h4>
Rs. {{ number_format($averageOrder, 2) }}
</h4>
</div>
</div>
</div>

</div>

{{-- Filter --}}
<form method="GET" action="{{ route('sales.report') }}">
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
    <a href="{{ route('sales.report') }}" class="btn btn-secondary">Clear</a>
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
<th>Order ID</th>
<th>Customer</th>
<th>Payment</th>
<th>Status</th>
<th class="text-end">Amount</th>
</tr>
</thead>
<tbody>
@forelse($sales as $index => $sale)
<tr>
<td>{{ $sales->firstItem() + $index }}</td>
<td>{{ $sale->created_at->format('Y-m-d') }}</td>
<td>{{ $sale->order_id }}</td>
<td>{{ $sale->user->name ?? 'Guest' }}</td>
<td>{{ ucfirst(str_replace('_', ' ', $sale->payment_method)) }}</td>
<td>{!! $sale->status_badge !!}</td>
<td class="text-end">Rs. {{ number_format($sale->total, 2) }}</td>
</tr>
@empty
<tr>
<td colspan="7" class="text-center py-4 text-muted">
<i class="fas fa-shopping-cart fa-2x mb-2"></i>
<p>No sales found.</p>
</td>
</tr>
@endforelse
</tbody>
<tfoot class="table-light">
<tr>
<th colspan="6" class="text-end">Total:</th>
<th class="text-end">Rs. {{ number_format($sales->sum('total'), 2) }}</th>
</tr>
</tfoot>
</table>
</div>

{{-- Pagination --}}
<div class="d-flex justify-content-between align-items-center mt-3">
<div class="text-muted small">
Showing {{ $sales->firstItem() ?? 0 }} to {{ $sales->lastItem() ?? 0 }} of {{ $sales->total() }} entries
</div>
<nav>
{{ $sales->withQueryString()->links('pagination::bootstrap-4') }}
</nav>
</div>

</div>
</div>

</div>
</main>
@endsection