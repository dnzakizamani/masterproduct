@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="page-wrapper">
    <div class="mb-4">
        <h4 class="mb-1">Dashboard</h4>
        <p class="text-muted mb-0">Welcome back! Here's what's happening today.</p>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-box"></i>
                            </div>
                        </div>
                        <div>
                            <p class="text-muted mb-1">Total Products</p>
                            <h4 class="mb-0">{{ number_format($stats['total_products']) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="stat-icon bg-info bg-opacity-10 text-info">
                                <i class="fas fa-cubes"></i>
                            </div>
                        </div>
                        <div>
                            <p class="text-muted mb-1">Total Stock</p>
                            <h4 class="mb-0">{{ number_format($stats['total_stock']) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="stat-icon bg-success bg-opacity-10 text-success">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div>
                            <p class="text-muted mb-1">Total Transactions</p>
                            <h4 class="mb-0">{{ number_format($stats['total_transactions']) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                        <div>
                            <p class="text-muted mb-1">Total Revenue</p>
                            <h4 class="mb-0">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Transactions -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-clock me-2 text-primary"></i>Recent Transactions</h5>
                    <a href="{{ route('admin.transactions.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Transaction</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $transaction)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.transactions.show', $transaction) }}" class="text-decoration-none">
                                            <span class="badge bg-primary">{{ $transaction->transaction_no }}</span>
                                        </a>
                                    </td>
                                    <td>{{ $transaction->date->format('d M Y') }}</td>
                                    <td>{{ $transaction->details->count() }} items</td>
                                    <td class="text-end">
                                        <strong class="text-success">Rp {{ number_format($transaction->total, 0, ',', '.') }}</strong>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <div class="empty-state">
                                            <i class="fas fa-receipt"></i>
                                            <p class="mb-0">No transactions yet</p>
                                            <a href="{{ route('admin.transactions.create') }}" class="btn btn-primary btn-sm mt-3">
                                                <i class="fas fa-plus me-2"></i>Create Transaction
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2 text-warning"></i>Low Stock Alert</h5>
                    <a href="{{ route('admin.products.index', ['stock' => 'low']) }}" class="btn btn-sm btn-outline-warning">View All</a>
                </div>
                <div class="list-group list-group-flush">
                    @forelse($lowStockProducts as $product)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $product->name }}</strong>
                                <p class="text-muted small mb-0">{{ $product->sku }}</p>
                            </div>
                            <span class="badge @if($product->stock <= 5) bg-danger @else bg-warning @endif">
                                {{ $product->stock }} left
                            </span>
                        </div>
                    @empty
                        <div class="list-group-item text-center py-4">
                            <i class="fas fa-check-circle text-success fs-4 mb-2"></i>
                            <p class="mb-0">All products are well stocked!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.stat-card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    transition: transform 0.2s;
}
.stat-card:hover {
    transform: translateY(-2px);
}
.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}
</style>
@endpush
