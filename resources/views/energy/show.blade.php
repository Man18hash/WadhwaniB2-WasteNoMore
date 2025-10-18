@extends('layouts.app')

@section('title', 'Energy Record Details')
@section('page-title', 'Energy Record Details')
@section('page-description', 'View detailed information about energy consumption record')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Energy Record</h2>
                <p class="text-gray-600">Recorded on {{ $energy->consumption_date->format('M d, Y') }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('energy.edit', $energy) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <i class="fas fa-edit"></i>
                    <span>Edit</span>
                </a>
                <a href="{{ route('energy.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back</span>
                </a>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Energy Information -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Energy Information</h3>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Date:</span>
                    <span class="text-sm text-gray-900">{{ $energy->consumption_date->format('M d, Y') }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Energy Source:</span>
                    <span class="text-sm text-gray-900 font-semibold">{{ ucfirst(str_replace('_', ' ', $energy->energy_source)) }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Quantity:</span>
                    <span class="text-sm text-gray-900">{{ number_format($energy->quantity_consumed, 2) }} {{ $energy->unit }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Used For:</span>
                    <span class="text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $energy->used_for)) }}</span>
                </div>
            </div>
            
            <!-- Cost Information -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Cost Information</h3>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Cost Saved:</span>
                    <span class="text-sm text-gray-900 font-bold text-green-600">₱{{ number_format($energy->cost_saved, 2) }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Record Created:</span>
                    <span class="text-sm text-gray-900">{{ $energy->created_at->format('M d, Y g:i A') }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Last Updated:</span>
                    <span class="text-sm text-gray-900">{{ $energy->updated_at->format('M d, Y g:i A') }}</span>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex justify-end space-x-3">
            <form method="POST" action="{{ route('energy.destroy', $energy) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this energy record?')">
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
