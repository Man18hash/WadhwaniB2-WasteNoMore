@extends('layouts.app')

@section('title', 'Edit Environmental Impact')
@section('page-title', 'Edit Environmental Impact')
@section('page-description', 'Update environmental impact metrics')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('environmental-impact.update', $environmentalImpact) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="report_date" class="block text-sm font-medium text-gray-700 mb-2">Report Date *</label>
                <input type="date" name="report_date" id="report_date" value="{{ old('report_date', $environmentalImpact->report_date->format('Y-m-d')) }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('report_date') border-red-500 @enderror" required>
                @error('report_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="waste_diverted_from_landfill_kg" class="block text-sm font-medium text-gray-700 mb-2">Waste Diverted from Landfill (kg) *</label>
                    <input type="number" name="waste_diverted_from_landfill_kg" id="waste_diverted_from_landfill_kg" step="0.01" min="0" value="{{ old('waste_diverted_from_landfill_kg', $environmentalImpact->waste_diverted_from_landfill_kg) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('waste_diverted_from_landfill_kg') border-red-500 @enderror" 
                           placeholder="0.00" required>
                    @error('waste_diverted_from_landfill_kg')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="co2_emissions_reduced_kg" class="block text-sm font-medium text-gray-700 mb-2">CO₂ Emissions Reduced (kg) *</label>
                    <input type="number" name="co2_emissions_reduced_kg" id="co2_emissions_reduced_kg" step="0.01" min="0" value="{{ old('co2_emissions_reduced_kg', $environmentalImpact->co2_emissions_reduced_kg) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('co2_emissions_reduced_kg') border-red-500 @enderror" 
                           placeholder="0.00" required>
                    @error('co2_emissions_reduced_kg')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="renewable_energy_generated_kwh" class="block text-sm font-medium text-gray-700 mb-2">Renewable Energy Generated (kWh) *</label>
                    <input type="number" name="renewable_energy_generated_kwh" id="renewable_energy_generated_kwh" step="0.01" min="0" value="{{ old('renewable_energy_generated_kwh', $environmentalImpact->renewable_energy_generated_kwh) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('renewable_energy_generated_kwh') border-red-500 @enderror" 
                           placeholder="0.00" required>
                    @error('renewable_energy_generated_kwh')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="chemical_fertilizer_replaced_kg" class="block text-sm font-medium text-gray-700 mb-2">Chemical Fertilizer Replaced (kg) *</label>
                    <input type="number" name="chemical_fertilizer_replaced_kg" id="chemical_fertilizer_replaced_kg" step="0.01" min="0" value="{{ old('chemical_fertilizer_replaced_kg', $environmentalImpact->chemical_fertilizer_replaced_kg) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('chemical_fertilizer_replaced_kg') border-red-500 @enderror" 
                           placeholder="0.00" required>
                    @error('chemical_fertilizer_replaced_kg')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="plastic_diverted_from_ocean_kg" class="block text-sm font-medium text-gray-700 mb-2">Plastic Diverted from Ocean (kg)</label>
                <input type="number" name="plastic_diverted_from_ocean_kg" id="plastic_diverted_from_ocean_kg" step="0.01" min="0" value="{{ old('plastic_diverted_from_ocean_kg', $environmentalImpact->plastic_diverted_from_ocean_kg) }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('plastic_diverted_from_ocean_kg') border-red-500 @enderror" 
                       placeholder="0.00">
                @error('plastic_diverted_from_ocean_kg')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                <textarea name="notes" id="notes" rows="4" 
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('notes') border-red-500 @enderror" 
                          placeholder="Additional notes about environmental impact...">{{ old('notes', $environmentalImpact->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('environmental-impact.show', $environmentalImpact) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Update Impact
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
