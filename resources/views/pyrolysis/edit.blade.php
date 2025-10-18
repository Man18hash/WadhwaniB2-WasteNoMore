@extends('layouts.app')

@section('title', 'Edit Pyrolysis Operation')
@section('page-title', 'Edit Pyrolysis Operation')
@section('page-description', 'Update pyrolysis operation information')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('pyrolysis.update', $pyrolysis) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="batch_number" class="block text-sm font-medium text-gray-700 mb-2">Batch Number *</label>
                    <input type="text" name="batch_number" id="batch_number" value="{{ old('batch_number', $pyrolysis->batch_number) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('batch_number') border-red-500 @enderror" 
                           placeholder="e.g., PY-001" required>
                    @error('batch_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="input_weight_kg" class="block text-sm font-medium text-gray-700 mb-2">Input Weight (kg) *</label>
                    <input type="number" name="input_weight_kg" id="input_weight_kg" step="0.01" min="0.01" value="{{ old('input_weight_kg', $pyrolysis->input_weight_kg) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('input_weight_kg') border-red-500 @enderror" 
                           placeholder="0.00" required>
                    @error('input_weight_kg')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="input_type" class="block text-sm font-medium text-gray-700 mb-2">Plastic Type *</label>
                <select name="input_type" id="input_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('input_type') border-red-500 @enderror" required>
                    <option value="">Select plastic type</option>
                    <option value="pet" {{ old('input_type', $pyrolysis->input_type) == 'pet' ? 'selected' : '' }}>PET (Polyethylene Terephthalate)</option>
                    <option value="hdpe" {{ old('input_type', $pyrolysis->input_type) == 'hdpe' ? 'selected' : '' }}>HDPE (High-Density Polyethylene)</option>
                    <option value="pvc" {{ old('input_type', $pyrolysis->input_type) == 'pvc' ? 'selected' : '' }}>PVC (Polyvinyl Chloride)</option>
                    <option value="ldpe" {{ old('input_type', $pyrolysis->input_type) == 'ldpe' ? 'selected' : '' }}>LDPE (Low-Density Polyethylene)</option>
                    <option value="pp" {{ old('input_type', $pyrolysis->input_type) == 'pp' ? 'selected' : '' }}>PP (Polypropylene)</option>
                    <option value="ps" {{ old('input_type', $pyrolysis->input_type) == 'ps' ? 'selected' : '' }}>PS (Polystyrene)</option>
                    <option value="mixed_plastic" {{ old('input_type', $pyrolysis->input_type) == 'mixed_plastic' ? 'selected' : '' }}>Mixed Plastic Waste</option>
                </select>
                @error('input_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Start Date *</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $pyrolysis->start_date->format('Y-m-d')) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('start_date') border-red-500 @enderror" required>
                    @error('start_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="expected_completion_date" class="block text-sm font-medium text-gray-700 mb-2">Expected Completion Date</label>
                    <input type="date" name="expected_completion_date" id="expected_completion_date" value="{{ old('expected_completion_date', $pyrolysis->expected_completion_date ? $pyrolysis->expected_completion_date->format('Y-m-d') : '') }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('expected_completion_date') border-red-500 @enderror">
                    @error('expected_completion_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                <select name="status" id="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('status') border-red-500 @enderror" required>
                    <option value="pending" {{ old('status', $pyrolysis->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ old('status', $pyrolysis->status) == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ old('status', $pyrolysis->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ old('status', $pyrolysis->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="actual_completion_date" class="block text-sm font-medium text-gray-700 mb-2">Actual Completion Date</label>
                <input type="date" name="actual_completion_date" id="actual_completion_date" value="{{ old('actual_completion_date', $pyrolysis->actual_completion_date ? $pyrolysis->actual_completion_date->format('Y-m-d') : '') }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('actual_completion_date') border-red-500 @enderror">
                @error('actual_completion_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" id="description" rows="4" 
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-500 @enderror" 
                          placeholder="Describe this pyrolysis operation...">{{ old('description', $pyrolysis->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('pyrolysis.show', $pyrolysis) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Update Operation
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
