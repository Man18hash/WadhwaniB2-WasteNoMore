@extends('layouts.app')

@section('title', 'Sale Details')
@section('page-title', 'Sale Details')
@section('page-description', 'View detailed information about sales record')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Sale #{{ $sale->id }}</h2>
                <p class="text-gray-600">Sale recorded on {{ $sale->sale_date->format('M d, Y') }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('sales.edit', $sale) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <i class="fas fa-edit"></i>
                    <span>Edit</span>
                </a>
                <a href="{{ route('sales.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back</span>
                </a>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Sale Information -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Sale Information</h3>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Product Type:</span>
                    <span class="text-sm text-gray-900 font-semibold">{{ ucfirst(str_replace('_', ' ', $sale->product_type)) }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Quantity:</span>
                    <span class="text-sm text-gray-900">{{ number_format($sale->quantity, 2) }} {{ $sale->unit }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Price per Unit:</span>
                    <span class="text-sm text-gray-900">₱{{ number_format($sale->price_per_unit, 2) }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Total Amount:</span>
                    <span class="text-sm text-gray-900 font-bold text-primary-600">₱{{ number_format($sale->total_amount, 2) }}</span>
                </div>
            </div>
            
            <!-- Customer Information -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Customer Information</h3>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Customer Name:</span>
                    <span class="text-sm text-gray-900">{{ $sale->customer_name }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Sale Date:</span>
                    <span class="text-sm text-gray-900">{{ $sale->sale_date->format('M d, Y') }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Recorded:</span>
                    <span class="text-sm text-gray-900">{{ $sale->created_at->format('M d, Y g:i A') }}</span>
                </div>
                
                @if($sale->notes)
                    <div class="py-2">
                        <span class="text-sm font-medium text-gray-600 block mb-2">Notes:</span>
                        <div class="bg-gray-50 rounded-lg p-3 text-sm text-gray-900">
                            {{ $sale->notes }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex justify-end space-x-3">
            <form method="POST" action="{{ route('sales.destroy', $sale) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this sale record?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <i class="fas fa-trash"></i>
                    <span>Delete</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
