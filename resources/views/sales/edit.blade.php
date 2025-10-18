@extends('layouts.app')

@section('title', 'Edit Sale')
@section('page-title', 'Edit Sale')
@section('page-description', 'Update sales record information')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('sales.update', $sale) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="product_type" class="block text-sm font-medium text-gray-700 mb-2">Product Type *</label>
                    <select name="product_type" id="product_type" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('product_type') border-red-500 @enderror" required>
                        <option value="">Select product type</option>
                        @foreach($inventory as $item)
                            @php
                                $currentStock = $item->product_type === $sale->product_type 
                                    ? $item->current_stock + $sale->quantity 
                                    : $item->current_stock;
                            @endphp
                            @if($currentStock > 0)
                                <option value="{{ $item->product_type }}" 
                                        data-stock="{{ $currentStock }}" 
                                        data-unit="{{ $item->unit }}"
                                        data-original-quantity="{{ $sale->product_type === $item->product_type ? $sale->quantity : 0 }}"
                                        {{ old('product_type', $sale->product_type) == $item->product_type ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $item->product_type)) }} 
                                    (Available: {{ $currentStock }} {{ $item->unit }})
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('product_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity *</label>
                    <input type="number" name="quantity" id="quantity" step="0.01" min="0.01" value="{{ old('quantity', $sale->quantity) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('quantity') border-red-500 @enderror" 
                           placeholder="0.00" required>
                    @error('quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">Unit *</label>
                    <select name="unit" id="unit" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('unit') border-red-500 @enderror" required>
                        <option value="">Select unit</option>
                        <option value="kg" {{ old('unit', $sale->unit) == 'kg' ? 'selected' : '' }}>kg</option>
                        <option value="liters" {{ old('unit', $sale->unit) == 'liters' ? 'selected' : '' }}>Liters</option>
                        <option value="m3" {{ old('unit', $sale->unit) == 'm3' ? 'selected' : '' }}>m³</option>
                        <option value="gallons" {{ old('unit', $sale->unit) == 'gallons' ? 'selected' : '' }}>Gallons</option>
                        <option value="pieces" {{ old('unit', $sale->unit) == 'pieces' ? 'selected' : '' }}>Pieces</option>
                        <option value="sheets" {{ old('unit', $sale->unit) == 'sheets' ? 'selected' : '' }}>Sheets</option>
                        <option value="boxes" {{ old('unit', $sale->unit) == 'boxes' ? 'selected' : '' }}>Boxes</option>
                        <option value="bags" {{ old('unit', $sale->unit) == 'bags' ? 'selected' : '' }}>Bags</option>
                    </select>
                    @error('unit')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="price_per_unit" class="block text-sm font-medium text-gray-700 mb-2">Price per Unit (₱) *</label>
                    <input type="number" name="price_per_unit" id="price_per_unit" step="0.01" min="0.01" value="{{ old('price_per_unit', $sale->price_per_unit) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('price_per_unit') border-red-500 @enderror" 
                           placeholder="0.00" required>
                    @error('price_per_unit')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="sale_date" class="block text-sm font-medium text-gray-700 mb-2">Sale Date *</label>
                    <input type="date" name="sale_date" id="sale_date" value="{{ old('sale_date', $sale->sale_date->format('Y-m-d')) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('sale_date') border-red-500 @enderror" required>
                    @error('sale_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">Customer Name *</label>
                    <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', $sale->customer_name) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('customer_name') border-red-500 @enderror" 
                           placeholder="Enter customer name" required>
                    @error('customer_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                <textarea name="notes" id="notes" rows="4" 
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('notes') border-red-500 @enderror" 
                          placeholder="Additional notes about this sale...">{{ old('notes', $sale->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Total Amount Display -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-medium text-gray-700">Total Amount:</span>
                    <span id="total-amount" class="text-xl font-bold text-primary-600">₱{{ number_format($sale->total_amount, 2) }}</span>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('sales.show', $sale) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Update Sale
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Calculate total amount automatically
function calculateTotal() {
    const quantity = parseFloat(document.getElementById('quantity').value) || 0;
    const pricePerUnit = parseFloat(document.getElementById('price_per_unit').value) || 0;
    const total = quantity * pricePerUnit;
    document.getElementById('total-amount').textContent = '₱' + total.toFixed(2);
}

// Update unit field and validate quantity when product type changes
function updateUnitAndValidate() {
    const productSelect = document.getElementById('product_type');
    const unitSelect = document.getElementById('unit');
    const quantityInput = document.getElementById('quantity');
    const selectedOption = productSelect.options[productSelect.selectedIndex];
    
    if (selectedOption.value) {
        const stock = parseFloat(selectedOption.dataset.stock);
        const unit = selectedOption.dataset.unit;
        const originalQuantity = parseFloat(selectedOption.dataset.originalQuantity) || 0;
        
        // Update unit field
        unitSelect.value = unit;
        
        // Update quantity max attribute (considering original quantity is already "returned" to stock)
        quantityInput.max = stock;
        quantityInput.placeholder = `Max: ${stock} ${unit}`;
        
        // Show stock info
        showStockInfo(stock, unit, originalQuantity);
    } else {
        // Reset when no product selected
        unitSelect.value = '';
        quantityInput.max = '';
        quantityInput.placeholder = '0.00';
        hideStockInfo();
    }
}

// Show stock information
function showStockInfo(stock, unit, originalQuantity) {
    let stockInfo = document.getElementById('stock-info');
    if (!stockInfo) {
        stockInfo = document.createElement('div');
        stockInfo.id = 'stock-info';
        stockInfo.className = 'mt-2 p-2 bg-blue-50 border border-blue-200 rounded text-sm text-blue-800';
        document.getElementById('product_type').parentNode.appendChild(stockInfo);
    }
    
    let message = `<i class="fas fa-info-circle mr-1"></i>Available stock: ${stock} ${unit}`;
    if (originalQuantity > 0) {
        message += ` (includes ${originalQuantity} ${unit} from this sale)`;
    }
    stockInfo.innerHTML = message;
}

// Hide stock information
function hideStockInfo() {
    const stockInfo = document.getElementById('stock-info');
    if (stockInfo) {
        stockInfo.remove();
    }
}

// Validate quantity against available stock
function validateQuantity() {
    const productSelect = document.getElementById('product_type');
    const quantityInput = document.getElementById('quantity');
    const selectedOption = productSelect.options[productSelect.selectedIndex];
    
    if (selectedOption.value) {
        const stock = parseFloat(selectedOption.dataset.stock);
        const quantity = parseFloat(quantityInput.value);
        
        if (quantity > stock) {
            quantityInput.setCustomValidity(`Cannot exceed available stock of ${stock}`);
            quantityInput.classList.add('border-red-500');
            
            // Show error message
            let errorMsg = document.getElementById('quantity-error');
            if (!errorMsg) {
                errorMsg = document.createElement('p');
                errorMsg.id = 'quantity-error';
                errorMsg.className = 'mt-1 text-sm text-red-600';
                quantityInput.parentNode.appendChild(errorMsg);
            }
            errorMsg.textContent = `Insufficient stock! Available: ${stock}`;
        } else {
            quantityInput.setCustomValidity('');
            quantityInput.classList.remove('border-red-500');
            
            // Remove error message
            const errorMsg = document.getElementById('quantity-error');
            if (errorMsg) {
                errorMsg.remove();
            }
        }
    }
}

// Add event listeners
document.getElementById('product_type').addEventListener('change', updateUnitAndValidate);
document.getElementById('quantity').addEventListener('input', function() {
    validateQuantity();
    calculateTotal();
});
document.getElementById('price_per_unit').addEventListener('input', calculateTotal);

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateUnitAndValidate();
    calculateTotal();
});
</script>
@endpush
@endsection
