@extends('admin.layouts.master')

@section('title', 'Create Transaction')

@section('content')
<div class="page-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Create Transaction</h4>
            <p class="text-muted mb-0">Create a new product transaction</p>
        </div>
        <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>

    <form action="{{ route('admin.transactions.store') }}" method="POST" id="transaction-form">
        @csrf
        
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-shopping-cart me-2 text-primary"></i>Transaction Items
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Transaction Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" 
                                   value="{{ old('date', now()->toDateString()) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered" id="items-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th style="width: 120px;">Price</th>
                                        <th style="width: 120px;">Stock</th>
                                        <th style="width: 120px;">Qty</th>
                                        <th style="width: 150px;">Subtotal</th>
                                        <th style="width: 60px;"></th>
                                    </tr>
                                </thead>
                                <tbody id="items-body">
                                    <tr class="item-row" data-index="0">
                                        <td>
                                            <select name="items[0][product_id]" class="form-select product-select @error('items.0.product_id') is-invalid @enderror" required>
                                                <option value="">Select Product</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}" 
                                                            data-price="{{ $product->price }}" 
                                                            data-stock="{{ $product->stock }}">
                                                        {{ $product->name }} ({{ $product->sku }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="text-success fw-semibold price-display">-</td>
                                        <td class="stock-display">-</td>
                                        <td>
                                            <input type="number" name="items[0][qty]" class="form-control qty-input @error('items.0.qty') is-invalid @enderror" 
                                                   min="1" value="1" placeholder="Qty">
                                        </td>
                                        <td class="text-primary fw-semibold subtotal-display">Rp 0</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger remove-item" disabled>
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <button type="button" class="btn btn-outline-primary btn-sm mt-3" id="add-item">
                            <i class="fas fa-plus me-2"></i>Add Item
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-calculator me-2 text-primary"></i>Summary
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Items:</span>
                            <strong id="total-items">0</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Units:</span>
                            <strong id="total-units">0</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold">Grand Total:</span>
                            <strong class="fs-4 text-success" id="grand-total">Rp 0</strong>
                        </div>

                        <hr class="my-4">

                        <button type="submit" class="btn btn-primary w-100 btn-lg" id="submit-btn">
                            <i class="fas fa-save me-2"></i>Create Transaction
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const products = @json($products);
    let itemIndex = 0;

    function updateTotals() {
        let totalItems = 0;
        let totalUnits = 0;
        let grandTotal = 0;

        document.querySelectorAll('.item-row').forEach(row => {
            const price = parseFloat(row.querySelector('.price-display').dataset.price) || 0;
            const qty = parseInt(row.querySelector('.qty-input').value) || 0;
            
            totalItems++;
            totalUnits += qty;
            grandTotal += price * qty;
        });

        document.getElementById('total-items').textContent = totalItems;
        document.getElementById('total-units').textContent = totalUnits;
        document.getElementById('grand-total').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
    }

    function updateRow(row) {
        const select = row.querySelector('.product-select');
        const priceDisplay = row.querySelector('.price-display');
        const stockDisplay = row.querySelector('.stock-display');
        const qtyInput = row.querySelector('.qty-input');
        const subtotalDisplay = row.querySelector('.subtotal-display');

        const option = select.options[select.selectedIndex];
        if (option && option.value) {
            const price = option.dataset.price;
            const stock = option.dataset.stock;
            
            priceDisplay.textContent = 'Rp ' + parseFloat(price).toLocaleString('id-ID');
            priceDisplay.dataset.price = price;
            stockDisplay.textContent = stock;
            stockDisplay.dataset.stock = stock;
            
            qtyInput.max = stock;
        } else {
            priceDisplay.textContent = '-';
            priceDisplay.dataset.price = 0;
            stockDisplay.textContent = '-';
            stockDisplay.dataset.stock = 0;
            subtotalDisplay.textContent = 'Rp 0';
        }

        updateRowSubtotal(row);
    }

    function updateRowSubtotal(row) {
        const price = parseFloat(row.querySelector('.price-display').dataset.price) || 0;
        const qty = parseInt(row.querySelector('.qty-input').value) || 0;
        const subtotal = price * qty;
        
        row.querySelector('.subtotal-display').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        updateTotals();
    }

    document.getElementById('items-body').addEventListener('change', function(e) {
        if (e.target.classList.contains('product-select')) {
            updateRow(e.target.closest('.item-row'));
        }
    });

    document.getElementById('items-body').addEventListener('input', function(e) {
        if (e.target.classList.contains('qty-input')) {
            const row = e.target.closest('.item-row');
            const stock = parseInt(row.querySelector('.stock-display').dataset.stock) || 0;
            let qty = parseInt(e.target.value) || 0;
            
            if (qty > stock) {
                e.target.value = stock;
                qty = stock;
            }
            if (qty < 1) {
                e.target.value = 1;
            }
            
            updateRowSubtotal(row);
        }
    });

    document.getElementById('add-item').addEventListener('click', function() {
        itemIndex++;
        const newRow = document.createElement('tr');
        newRow.className = 'item-row';
        newRow.dataset.index = itemIndex;
        newRow.innerHTML = `
            <td>
                <select name="items[${itemIndex}][product_id]" class="form-select product-select" required>
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">
                            {{ $product->name }} ({{ $product->sku }})
                        </option>
                    @endforeach
                </select>
            </td>
            <td class="text-success fw-semibold price-display">-</td>
            <td class="stock-display">-</td>
            <td>
                <input type="number" name="items[${itemIndex}][qty]" class="form-control qty-input" min="1" value="1" placeholder="Qty">
            </td>
            <td class="text-primary fw-semibold subtotal-display">Rp 0</td>
            <td>
                <button type="button" class="btn btn-sm btn-danger remove-item">
                    <i class="fas fa-times"></i>
                </button>
            </td>
        `;
        
        document.getElementById('items-body').appendChild(newRow);
        updateRemoveButtons();
    });

    document.getElementById('items-body').addEventListener('click', function(e) {
        if (e.target.closest('.remove-item')) {
            const row = e.target.closest('.item-row');
            if (document.querySelectorAll('.item-row').length > 1) {
                row.remove();
                updateRemoveButtons();
                updateTotals();
            }
        }
    });

    function updateRemoveButtons() {
        const rows = document.querySelectorAll('.item-row');
        const removeButtons = document.querySelectorAll('.remove-item');
        removeButtons.forEach(btn => {
            btn.disabled = rows.length <= 1;
        });
    }

    document.getElementById('transaction-form').addEventListener('submit', function(e) {
        const rows = document.querySelectorAll('.item-row');
        let hasItems = false;
        
        rows.forEach(row => {
            const select = row.querySelector('.product-select');
            if (select.value) hasItems = true;
        });

        if (!hasItems) {
            e.preventDefault();
            alert('Please add at least one product to the transaction.');
        }
    });

    updateRemoveButtons();
});
</script>
@endpush
