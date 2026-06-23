@extends('admin.layouts.master')

@section('title', 'Products')

@section('content')
<div class="page-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Products</h4>
            <p class="text-muted mb-0">Manage your product inventory</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Product
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
            <div class="row align-items-center g-3">
                <div class="col-md-6">
                    <form action="{{ route('admin.products.index') }}" method="GET" class="d-flex gap-2">
                        <div class="input-group" style="max-width: 300px;">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Search name or SKU..." 
                                   value="{{ request('search') }}">
                        </div>
                        
                        <select name="status" class="form-select" style="max-width: 150px;">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        
                        <select name="stock" class="form-select" style="max-width: 150px;">
                            <option value="">All Stock</option>
                            <option value="low" {{ request('stock') == 'low' ? 'selected' : '' }}>Low Stock</option>
                            <option value="out" {{ request('stock') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                        
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </form>
                </div>
                <div class="col-md-6 text-end">
                    <span class="text-muted">
                        Showing {{ $products->count() }} of {{ $products->total() }} products
                    </span>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 50px;">
                            <a href="{{ route('admin.products.index', array_merge(request()->query(), ['sort' => 'id', 'direction' => request('sort') == 'id' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                               class="text-decoration-none text-muted">
                                # {!! request('sort') == 'id' ? '<i class="fas fa-sort-' . (request('direction') == 'asc' ? 'up' : 'down') . ' ms-1"></i>' : '' !!}
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('admin.products.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => request('sort') == 'name' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                               class="text-decoration-none text-muted">
                                Product {!! request('sort') == 'name' ? '<i class="fas fa-sort-' . (request('direction') == 'asc' ? 'up' : 'down') . ' ms-1"></i>' : '' !!}
                            </a>
                        </th>
                        <th style="width: 120px;">
                            <a href="{{ route('admin.products.index', array_merge(request()->query(), ['sort' => 'sku', 'direction' => request('sort') == 'sku' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                               class="text-decoration-none text-muted">
                                SKU {!! request('sort') == 'sku' ? '<i class="fas fa-sort-' . (request('direction') == 'asc' ? 'up' : 'down') . ' ms-1"></i>' : '' !!}
                            </a>
                        </th>
                        <th style="width: 130px;">
                            <a href="{{ route('admin.products.index', array_merge(request()->query(), ['sort' => 'price', 'direction' => request('sort') == 'price' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                               class="text-decoration-none text-muted">
                                Price {!! request('sort') == 'price' ? '<i class="fas fa-sort-' . (request('direction') == 'asc' ? 'up' : 'down') . ' ms-1"></i>' : '' !!}
                            </a>
                        </th>
                        <th style="width: 110px;">
                            <a href="{{ route('admin.products.index', array_merge(request()->query(), ['sort' => 'stock', 'direction' => request('sort') == 'stock' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                               class="text-decoration-none text-muted">
                                Stock {!! request('sort') == 'stock' ? '<i class="fas fa-sort-' . (request('direction') == 'asc' ? 'up' : 'down') . ' ms-1"></i>' : '' !!}
                            </a>
                        </th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 150px;">
                            <a href="{{ route('admin.products.index', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => request('sort') == 'created_at' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                               class="text-decoration-none text-muted">
                                Created {!! request('sort') == 'created_at' ? '<i class="fas fa-sort-' . (request('direction') == 'asc' ? 'up' : 'down') . ' ms-1"></i>' : '' !!}
                            </a>
                        </th>
                        <th style="width: 140px;" class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td class="ps-4 text-muted">{{ $product->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="product-icon me-3">
                                        <i class="fas fa-box"></i>
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
                            <td><strong class="text-success">Rp {{ number_format($product->price, 0, ',', '.') }}</strong></td>
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
                                @if($product->status)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-muted small">
                                    {{ $product->created_at->format('d M Y') }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-outline-secondary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('Move this product to trash?')" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-box-open"></i>
                                    <p class="mb-0">No products found</p>
                                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus me-2"></i>Add First Product
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
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
                    </div>
                    {{ $products->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
