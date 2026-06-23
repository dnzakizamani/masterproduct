@extends('admin.layouts.master')

@section('title', 'Add Product')

@section('content')
<div class="page-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Add New Product</h4>
            <p class="text-muted mb-0">Create a new product</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-plus-circle me-2 text-primary"></i>Product Information
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST">
                @csrf

                <div class="row g-4">
                    <div class="col-md-8">
                        <label class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" placeholder="Enter product name" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">SKU <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                            <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" 
                                   value="{{ old('sku') }}" placeholder="PRD-001" required>
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row g-4 mt-2">
                    <div class="col-md-6">
                        <label class="form-label">Price <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                                   value="{{ old('price') }}" min="0" step="0.01" placeholder="0" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Stock <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-boxes"></i></span>
                            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" 
                                   value="{{ old('stock', 0) }}" min="0" placeholder="0" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row g-4 mt-2">
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" 
                                  placeholder="Enter product description (optional)">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-4 mt-2">
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary px-4">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
