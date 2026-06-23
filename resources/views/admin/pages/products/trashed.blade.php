@extends('admin.layouts.master')

@section('title', 'Trashed Products')

@section('content')
<div class="page-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Trashed Products</h4>
            <p class="text-muted mb-0">Manage deleted products</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Products
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <span><i class="fas fa-trash-alt me-2 text-danger"></i>Deleted Products</span>
                <span class="badge bg-danger rounded-pill">
                    {{ $products->total() }} Items
                </span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 50px;">#</th>
                        <th>Name</th>
                        <th style="width: 120px;">SKU</th>
                        <th style="width: 130px;">Price</th>
                        <th style="width: 110px;">Stock</th>
                        <th style="width: 150px;">Deleted At</th>
                        <th style="width: 160px;" class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td class="ps-4 text-muted">{{ $product->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="product-icon me-3 bg-danger bg-opacity-10">
                                        <i class="fas fa-trash text-danger"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $product->name }}</strong>
                                        @if($product->description)
                                            <p class="text-muted small mb-0">{{ Str::limit($product->description, 30) }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-dark">{{ $product->sku }}</span></td>
                            <td><strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong></td>
                            <td>
                                @if($product->stock > 10)
                                    <span class="badge badge-success">{{ $product->stock }}</span>
                                @elseif($product->stock > 0)
                                    <span class="badge badge-warning">{{ $product->stock }}</span>
                                @else
                                    <span class="badge badge-danger">Out</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-muted small">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $product->deleted_at->format('d M Y, H:i') }}
                                </span>
                                <br>
                                <span class="text-danger small">
                                    ({{ $product->deleted_at->diffForHumans() }})
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.products.restore', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" title="Restore">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.products.force-delete', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Permanently delete this product? This cannot be undone!')" title="Delete Permanently">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-trash-alt"></i>
                                    <p class="mb-0">No trashed products found</p>
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-boxes-stacked me-2"></i>View Products
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="card-footer bg-white">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
