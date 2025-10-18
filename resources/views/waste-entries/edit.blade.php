@extends('layouts.app')

@section('title', 'Edit Waste Entry')
@section('page-title', 'Edit Waste Entry')
@section('page-description', 'Update waste entry information')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('waste-entries.update', $wasteEntry) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="entry_date" class="block text-sm font-medium text-gray-700 mb-2">Entry Date *</label>
                    <input type="date" name="entry_date" id="entry_date" value="{{ old('entry_date', $wasteEntry->entry_date->format('Y-m-d')) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('entry_date') border-red-500 @enderror" required>
                    @error('entry_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="waste_type" class="block text-sm font-medium text-gray-700 mb-2">Waste Type *</label>
                    <select name="waste_type" id="waste_type" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('waste_type') border-red-500 @enderror" required>
                        <option value="">Select waste type</option>
                        <option value="vegetable" {{ old('waste_type', $wasteEntry->waste_type) == 'vegetable' ? 'selected' : '' }}>Vegetable</option>
                        <option value="fruit" {{ old('waste_type', $wasteEntry->waste_type) == 'fruit' ? 'selected' : '' }}>Fruit</option>
                        <option value="plastic" {{ old('waste_type', $wasteEntry->waste_type) == 'plastic' ? 'selected' : '' }}>Plastic</option>
                    </select>
                    @error('waste_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="weight_kg" class="block text-sm font-medium text-gray-700 mb-2">Weight (kg) *</label>
                    <input type="number" name="weight_kg" id="weight_kg" step="0.01" min="0.01" value="{{ old('weight_kg', $wasteEntry->weight_kg) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('weight_kg') border-red-500 @enderror" 
                           placeholder="0.00" required>
                    @error('weight_kg')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="processing_technology" class="block text-sm font-medium text-gray-700 mb-2">Processing Technology *</label>
                    <select name="processing_technology" id="processing_technology" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('processing_technology') border-red-500 @enderror" required>
                        <option value="">Select technology</option>
                        <option value="anaerobic" {{ old('processing_technology', $wasteEntry->processing_technology) == 'anaerobic' ? 'selected' : '' }}>Anaerobic Digestion</option>
                        <option value="bsf" {{ old('processing_technology', $wasteEntry->processing_technology) == 'bsf' ? 'selected' : '' }}>BSF Larvae</option>
                        <option value="activated" {{ old('processing_technology', $wasteEntry->processing_technology) == 'activated' ? 'selected' : '' }}>Activated Carbon</option>
                        <option value="paper" {{ old('processing_technology', $wasteEntry->processing_technology) == 'paper' ? 'selected' : '' }}>Paper & Packaging</option>
                        <option value="pyrolysis" {{ old('processing_technology', $wasteEntry->processing_technology) == 'pyrolysis' ? 'selected' : '' }}>Pyrolysis</option>
                    </select>
                    @error('processing_technology')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                <textarea name="notes" id="notes" rows="4" 
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('notes') border-red-500 @enderror" 
                          placeholder="Additional notes about this waste entry...">{{ old('notes', $wasteEntry->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('waste-entries.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Update Entry
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
