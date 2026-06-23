@extends('admin.layouts.master')

@section('title', 'Transaction Details')

@section('content')
<div class="page-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Transaction Details</h4>
            <p class="text-muted mb-0">{{ $transaction->transaction_no }}</p>
        </div>
        <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-list me-2 text-primary"></i>Items
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th class="text-center">SKU</th>
                                <th class="text-end">Price</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaction->details as $detail)
                                <tr>
                                    <td>
                                        <strong>{{ $detail->product->name }}</strong>
                                        @if($detail->product->description)
                                            <p class="text-muted small mb-0">{{ Str::limit($detail->product->description, 40) }}</p>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-dark">{{ $detail->product->sku }}</span>
                                    </td>
                                    <td class="text-end">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $detail->qty }}</td>
                                    <td class="text-end fw-semibold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">No items found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle me-2 text-primary"></i>Transaction Info
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Transaction No</label>
                        <p class="fw-semibold mb-0">{{ $transaction->transaction_no }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="text-muted small">Date</label>
                        <p class="fw-semibold mb-0">{{ $transaction->date->format('d M Y') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="text-muted small">Created By</label>
                        <p class="fw-semibold mb-0">{{ $transaction->user->name ?? 'N/A' }}</p>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="text-muted small">Total Items</label>
                        <p class="fw-semibold mb-0">{{ $transaction->details->count() }} items</p>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Total Units</label>
                        <p class="fw-semibold mb-0">{{ $transaction->total_items }} units</p>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Grand Total</span>
                        <span class="fs-4 text-success fw-bold">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <small class="text-muted">
                        Created: {{ $transaction->created_at->format('d M Y, H:i') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
