@extends('layouts.app')

@section('title', 'Record Energy Consumption')
@section('page-title', 'Record Energy Consumption')
@section('page-description', 'Record energy consumption or generation data')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('energy.store') }}" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="consumption_date" class="block text-sm font-medium text-gray-700 mb-2">Date *</label>
                    <input type="date" name="consumption_date" id="consumption_date" value="{{ old('consumption_date', now()->format('Y-m-d')) }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('consumption_date') border-red-500 @enderror" required>
                    @error('consumption_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="energy_source" class="block text-sm font-medium text-gray-700 mb-2">Energy Source *</label>
                    <select name="energy_source" id="energy_source" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('energy_source') border-red-500 @enderror" required>
                        <option value="">Select energy source</option>
                        <option value="biogas" {{ old('energy_source') == 'biogas' ? 'selected' : '' }}>Biogas</option>
                        <option value="solar" {{ old('energy_source') == 'solar' ? 'selected' : '' }}>Solar</option>
                        <option value="wind" {{ old('energy_source') == 'wind' ? 'selected' : '' }}>Wind</option>
                        <option value="grid" {{ old('energy_source') == 'grid' ? 'selected' : '' }}>Grid Electricity</option>
                        <option value="pyrolysis_gas" {{ old('energy_source') == 'pyrolysis_gas' ? 'selected' : '' }}>Pyrolysis Gas</option>
                        <option value="diesel" {{ old('energy_source') == 'diesel' ? 'selected' : '' }}>Diesel Generator</option>
                        <option value="wood" {{ old('energy_source') == 'wood' ? 'selected' : '' }}>Wood/Biomass</option>
                    </select>
                    @error('energy_source')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="quantity_consumed" class="block text-sm font-medium text-gray-700 mb-2">Quantity *</label>
                    <input type="number" name="quantity_consumed" id="quantity_consumed" step="0.01" min="0.01" value="{{ old('quantity_consumed') }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('quantity_consumed') border-red-500 @enderror" 
                           placeholder="0.00" required>
                    @error('quantity_consumed')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">Unit *</label>
                    <select name="unit" id="unit" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('unit') border-red-500 @enderror" required>
                        <option value="">Select unit</option>
                        <option value="kwh" {{ old('unit') == 'kwh' ? 'selected' : '' }}>kWh</option>
                        <option value="m3" {{ old('unit') == 'm3' ? 'selected' : '' }}>m³</option>
                        <option value="liters" {{ old('unit') == 'liters' ? 'selected' : '' }}>Liters</option>
                        <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>kg</option>
                        <option value="gallons" {{ old('unit') == 'gallons' ? 'selected' : '' }}>Gallons</option>
                    </select>
                    @error('unit')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="used_for" class="block text-sm font-medium text-gray-700 mb-2">Used For *</label>
                <select name="used_for" id="used_for" 
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('used_for') border-red-500 @enderror" required>
                    <option value="">Select usage</option>
                    <option value="anaerobic_digestion" {{ old('used_for') == 'anaerobic_digestion' ? 'selected' : '' }}>Anaerobic Digestion</option>
                    <option value="bsf_larvae" {{ old('used_for') == 'bsf_larvae' ? 'selected' : '' }}>BSF Larvae Cultivation</option>
                    <option value="activated_carbon" {{ old('used_for') == 'activated_carbon' ? 'selected' : '' }}>Activated Carbon Production</option>
                    <option value="paper_production" {{ old('used_for') == 'paper_production' ? 'selected' : '' }}>Paper & Packaging Production</option>
                    <option value="pyrolysis" {{ old('used_for') == 'pyrolysis' ? 'selected' : '' }}>Pyrolysis Operations</option>
                    <option value="facility_operations" {{ old('used_for') == 'facility_operations' ? 'selected' : '' }}>Facility Operations</option>
                    <option value="lighting" {{ old('used_for') == 'lighting' ? 'selected' : '' }}>Lighting</option>
                    <option value="heating" {{ old('used_for') == 'heating' ? 'selected' : '' }}>Heating</option>
                    <option value="cooling" {{ old('used_for') == 'cooling' ? 'selected' : '' }}>Cooling</option>
                    <option value="other" {{ old('used_for') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('used_for')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="cost_saved" class="block text-sm font-medium text-gray-700 mb-2">Cost Saved (₱)</label>
                <input type="number" name="cost_saved" id="cost_saved" step="0.01" min="0" value="{{ old('cost_saved') }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('cost_saved') border-red-500 @enderror" 
                       placeholder="0.00">
                @error('cost_saved')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Enter the cost savings from using renewable energy instead of grid electricity</p>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('energy.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Record Energy
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
