@extends('layouts.app')

@section('title', 'Edit Anaerobic Digestion Batch')
@section('page-title', 'Edit Anaerobic Digestion Batch')
@section('page-description', 'Update anaerobic digestion batch information')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('anaerobic-digestion.update', $anaerobicDigestion) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="batch_number" class="block text-sm font-medium text-gray-700 mb-2">Batch Number *</label>
                    <input type="text" name="batch_number" id="batch_number" value="{{ old('batch_number', $anaerobicDigestion->batch_number) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('batch_number') border-red-500 @enderror" 
                           placeholder="e.g., AD-001" required>
                    @error('batch_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="input_weight_kg" class="block text-sm font-medium text-gray-700 mb-2">Input Weight (kg) *</label>
                    <input type="number" name="input_weight_kg" id="input_weight_kg" step="0.01" min="0.01" value="{{ old('input_weight_kg', $anaerobicDigestion->input_weight_kg) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('input_weight_kg') border-red-500 @enderror" 
                           placeholder="0.00" required>
                    @error('input_weight_kg')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="input_type" class="block text-sm font-medium text-gray-700 mb-2">Input Type *</label>
                <select name="input_type" id="input_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('input_type') border-red-500 @enderror" required>
                    <option value="">Select input type</option>
                    <option value="vegetable_waste" {{ old('input_type', $anaerobicDigestion->input_type) == 'vegetable_waste' ? 'selected' : '' }}>Vegetable Waste</option>
                    <option value="fruit_waste" {{ old('input_type', $anaerobicDigestion->input_type) == 'fruit_waste' ? 'selected' : '' }}>Fruit Waste</option>
                    <option value="food_waste" {{ old('input_type', $anaerobicDigestion->input_type) == 'food_waste' ? 'selected' : '' }}>Food Waste</option>
                    <option value="agricultural_residue" {{ old('input_type', $anaerobicDigestion->input_type) == 'agricultural_residue' ? 'selected' : '' }}>Agricultural Residue</option>
                    <option value="manure" {{ old('input_type', $anaerobicDigestion->input_type) == 'manure' ? 'selected' : '' }}>Manure</option>
                    <option value="mixed_organic" {{ old('input_type', $anaerobicDigestion->input_type) == 'mixed_organic' ? 'selected' : '' }}>Mixed Organic Waste</option>
                </select>
                @error('input_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Start Date *</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $anaerobicDigestion->start_date->format('Y-m-d')) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('start_date') border-red-500 @enderror" required>
                    @error('start_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="expected_completion_date" class="block text-sm font-medium text-gray-700 mb-2">Expected Completion Date</label>
                    <input type="date" name="expected_completion_date" id="expected_completion_date" value="{{ old('expected_completion_date', $anaerobicDigestion->expected_completion_date ? $anaerobicDigestion->expected_completion_date->format('Y-m-d') : '') }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('expected_completion_date') border-red-500 @enderror">
                    @error('expected_completion_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                <select name="status" id="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('status') border-red-500 @enderror" required>
                    <option value="pending" {{ old('status', $anaerobicDigestion->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ old('status', $anaerobicDigestion->status) == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ old('status', $anaerobicDigestion->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ old('status', $anaerobicDigestion->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="actual_completion_date" class="block text-sm font-medium text-gray-700 mb-2">Actual Completion Date</label>
                <input type="date" name="actual_completion_date" id="actual_completion_date" value="{{ old('actual_completion_date', $anaerobicDigestion->actual_completion_date ? $anaerobicDigestion->actual_completion_date->format('Y-m-d') : '') }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('actual_completion_date') border-red-500 @enderror">
                @error('actual_completion_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" id="description" rows="4" 
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-500 @enderror" 
                          placeholder="Describe this anaerobic digestion batch...">{{ old('description', $anaerobicDigestion->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('anaerobic-digestion.show', $anaerobicDigestion) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Update Batch
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
