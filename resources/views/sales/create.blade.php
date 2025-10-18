@extends('layouts.app')

@section('title', 'Record Sale')
@section('page-title', 'Record Sale')
@section('page-description', 'Record a new sales transaction')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('sales.store') }}" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="product_type" class="block text-sm font-medium text-gray-700 mb-2">Product Type *</label>
                    <select name="product_type" id="product_type" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('product_type') border-red-500 @enderror" required>
                        <option value="">Select product type</option>
                        <option value="biogas" {{ old('product_type') == 'biogas' ? 'selected' : '' }}>Biogas</option>
                        <option value="digestate" {{ old('product_type') == 'digestate' ? 'selected' : '' }}>Digestate</option>
                        <option value="larvae" {{ old('product_type') == 'larvae' ? 'selected' : '' }}>BSF Larvae</option>
                        <option value="frass" {{ old('product_type') == 'frass' ? 'selected' : '' }}>Frass (Fertilizer)</option>
                        <option value="activated_carbon" {{ old('product_type') == 'activated_carbon' ? 'selected' : '' }}>Activated Carbon</option>
                        <option value="charcoal" {{ old('product_type') == 'charcoal' ? 'selected' : '' }}>Charcoal</option>
                        <option value="pyrolysis_oil" {{ old('product_type') == 'pyrolysis_oil' ? 'selected' : '' }}>Pyrolysis Oil</option>
                        <option value="syngas" {{ old('product_type') == 'syngas' ? 'selected' : '' }}>Syngas</option>
                        <option value="paper_sheets" {{ old('product_type') == 'paper_sheets' ? 'selected' : '' }}>Paper Sheets</option>
                        <option value="packaging_boxes" {{ old('product_type') == 'packaging_boxes' ? 'selected' : '' }}>Packaging Boxes</option>
                        <option value="paper_bags" {{ old('product_type') == 'paper_bags' ? 'selected' : '' }}>Paper Bags</option>
                        <option value="cardboard" {{ old('product_type') == 'cardboard' ? 'selected' : '' }}>Cardboard</option>
                    </select>
                    @error('product_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity *</label>
                    <input type="number" name="quantity" id="quantity" step="0.01" min="0.01" value="{{ old('quantity') }}" 
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
                        <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>kg</option>
                        <option value="liters" {{ old('unit') == 'liters' ? 'selected' : '' }}>Liters</option>
                        <option value="m3" {{ old('unit') == 'm3' ? 'selected' : '' }}>m³</option>
                        <option value="gallons" {{ old('unit') == 'gallons' ? 'selected' : '' }}>Gallons</option>
                        <option value="pieces" {{ old('unit') == 'pieces' ? 'selected' : '' }}>Pieces</option>
                        <option value="sheets" {{ old('unit') == 'sheets' ? 'selected' : '' }}>Sheets</option>
                        <option value="boxes" {{ old('unit') == 'boxes' ? 'selected' : '' }}>Boxes</option>
                        <option value="bags" {{ old('unit') == 'bags' ? 'selected' : '' }}>Bags</option>
                    </select>
                    @error('unit')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="price_per_unit" class="block text-sm font-medium text-gray-700 mb-2">Price per Unit (₱) *</label>
                    <input type="number" name="price_per_unit" id="price_per_unit" step="0.01" min="0.01" value="{{ old('price_per_unit') }}" 
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
                    <input type="date" name="sale_date" id="sale_date" value="{{ old('sale_date', now()->format('Y-m-d')) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('sale_date') border-red-500 @enderror" required>
                    @error('sale_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">Customer Name *</label>
                    <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" 
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
                          placeholder="Additional notes about this sale...">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Total Amount Display -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-medium text-gray-700">Total Amount:</span>
                    <span id="total-amount" class="text-xl font-bold text-primary-600">₱0.00</span>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('sales.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Record Sale
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

// Add event listeners
document.getElementById('quantity').addEventListener('input', calculateTotal);
document.getElementById('price_per_unit').addEventListener('input', calculateTotal);

// Calculate on page load
calculateTotal();
</script>
@endpush
@endsection
