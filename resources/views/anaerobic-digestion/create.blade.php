@extends('layouts.app')

@section('title', 'Create Anaerobic Digestion Batch')
@section('page-title', 'Create Anaerobic Digestion Batch')
@section('page-description', 'Start a new anaerobic digestion process')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('anaerobic-digestion.store') }}" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="batch_number" class="block text-sm font-medium text-gray-700 mb-2">Batch Number *</label>
                    <input type="text" name="batch_number" id="batch_number" value="{{ old('batch_number') }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('batch_number') border-red-500 @enderror" 
                           placeholder="e.g., AD-001" required>
                    @error('batch_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="input_weight_kg" class="block text-sm font-medium text-gray-700 mb-2">Input Weight (kg) *</label>
                    <input type="number" name="input_weight_kg" id="input_weight_kg" step="0.01" min="0.01" value="{{ old('input_weight_kg') }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('input_weight_kg') border-red-500 @enderror" 
                           placeholder="0.00" required>
                    @error('input_weight_kg')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="input_type" class="block text-sm font-medium text-gray-700 mb-2">Input Type *</label>
                <input type="text" name="input_type" id="input_type" value="{{ old('input_type') }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('input_type') border-red-500 @enderror" 
                       placeholder="e.g., Vegetable waste" required>
                @error('input_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Start Date *</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date', now()->format('Y-m-d')) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('start_date') border-red-500 @enderror" required>
                    @error('start_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="expected_completion_date" class="block text-sm font-medium text-gray-700 mb-2">Expected Completion Date</label>
                    <input type="date" name="expected_completion_date" id="expected_completion_date" value="{{ old('expected_completion_date') }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('expected_completion_date') border-red-500 @enderror">
                    @error('expected_completion_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" id="description" rows="4" 
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-500 @enderror" 
                          placeholder="Describe this anaerobic digestion batch...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('anaerobic-digestion.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Create Batch
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
