@extends('admin.layouts.master')

@section('title', 'Transactions')

@section('content')
<div class="page-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Transactions</h4>
            <p class="text-muted mb-0">Manage product transactions</p>
        </div>
        <a href="{{ route('admin.transactions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>New Transaction
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <form action="{{ route('admin.transactions.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Search transaction no..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="date" name="date_from" class="form-control" 
                           value="{{ request('date_from') }}" placeholder="From">
                </div>
                <div class="col-md-3">
                    <input type="date" name="date_to" class="form-control" 
                           value="{{ request('date_to') }}" placeholder="To">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Transaction No</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Created By</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr>
                            <td class="ps-4 text-muted">{{ $transaction->id }}</td>
                            <td><span class="badge bg-primary">{{ $transaction->transaction_no }}</span></td>
                            <td>{{ $transaction->date->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $transaction->details->count() }} items</span>
                                <small class="text-muted">({{ $transaction->total_items }} units)</small>
                            </td>
                            <td><strong class="text-success">Rp {{ number_format($transaction->total, 0, ',', '.') }}</strong></td>
                            <td>{{ $transaction->user->name ?? 'N/A' }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.transactions.show', $transaction) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-receipt"></i>
                                    <p class="mb-0">No transactions found</p>
                                    <a href="{{ route('admin.transactions.create') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus me-2"></i>Create First Transaction
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
            <div class="card-footer bg-white">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
