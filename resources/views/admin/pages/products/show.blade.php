@extends('admin.layouts.master')

@section('title', 'Product Details')

@section('content')
<div class="page-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Product Details</h4>
            <p class="text-muted mb-0">View product information</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="bg-light rounded-3 p-4 d-inline-block mb-4">
                        <i class="fas fa-box fa-4x text-primary"></i>
                    </div>
                    <h4 class="mb-2">{{ $product->name }}</h4>
                    <span class="badge bg-dark rounded-pill px-3">{{ $product->sku }}</span>
                    
                    <hr class="my-4">
                    
                    <div class="text-start">
                        <div class="mb-3">
                            <span class="text-muted small d-block">Price</span>
                            <strong class="fs-4 text-success">Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
                        </div>
                        
                        <div class="mb-3">
                            <span class="text-muted small d-block">Stock</span>
                            @if($product->stock > 10)
                                <span class="badge badge-success fs-6">
                                    <i class="fas fa-check-circle me-1"></i>{{ $product->stock }} units
                                </span>
                            @elseif($product->stock > 0)
                                <span class="badge badge-warning fs-6">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $product->stock }} units
                                </span>
                            @else
                                <span class="badge badge-danger fs-6">
                                    <i class="fas fa-times-circle me-1"></i>Out of Stock
                                </span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <span class="text-muted small d-block">Status</span>
                            @if($product->status)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-secondary">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle me-2 text-primary"></i>Product Information
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="text-muted" style="width: 160px;">Product ID</td>
                                <td><span class="badge bg-light text-dark">#{{ $product->id }}</span></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Name</td>
                                <td><strong>{{ $product->name }}</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">SKU</td>
                                <td><span class="badge bg-dark">{{ $product->sku }}</span></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Price</td>
                                <td class="text-success fw-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Stock</td>
                                <td>{{ $product->stock }} units</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Created</td>
                                <td>{{ $product->created_at->format('d F Y, H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Last Updated</td>
                                <td>{{ $product->updated_at->format('d F Y, H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            @if($product->description)
                <div class="card mt-4">
                    <div class="card-header">
                        <i class="fas fa-align-left me-2 text-primary"></i>Description
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $product->description }}</p>
                    </div>
                </div>
            @endif

            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            <i class="fas fa-history me-1"></i>
                            Last modified {{ $product->updated_at->diffForHumans() }}
                        </div>
                        <div class="d-flex gap-2">
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Delete this product?')">
                                    <i class="fas fa-trash me-2"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
