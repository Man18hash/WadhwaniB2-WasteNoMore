@extends('layouts.app')

@section('title', 'Environmental Impact Details')
@section('page-title', 'Environmental Impact Details')
@section('page-description', 'View detailed environmental impact metrics')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Environmental Impact Report</h2>
                <p class="text-gray-600">Reported on {{ $environmentalImpact->report_date->format('M d, Y') }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('environmental-impact.edit', $environmentalImpact) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <i class="fas fa-edit"></i>
                    <span>Edit</span>
                </a>
                <a href="{{ route('environmental-impact.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back</span>
                </a>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Waste Management Impact -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Waste Management Impact</h3>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Waste Diverted from Landfill:</span>
                    <span class="text-sm text-gray-900 font-semibold">{{ number_format($environmentalImpact->waste_diverted_from_landfill_kg, 0) }} kg</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Plastic Diverted from Ocean:</span>
                    <span class="text-sm text-gray-900">{{ number_format($environmentalImpact->plastic_diverted_from_ocean_kg, 0) }} kg</span>
                </div>
            </div>
            
            <!-- Climate Impact -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Climate Impact</h3>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">CO₂ Emissions Reduced:</span>
                    <span class="text-sm text-gray-900 font-semibold text-green-600">{{ number_format($environmentalImpact->co2_emissions_reduced_kg, 0) }} kg</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Renewable Energy Generated:</span>
                    <span class="text-sm text-gray-900">{{ number_format($environmentalImpact->renewable_energy_generated_kwh, 0) }} kWh</span>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Agricultural Impact -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Agricultural Impact</h3>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Chemical Fertilizer Replaced:</span>
                    <span class="text-sm text-gray-900 font-semibold">{{ number_format($environmentalImpact->chemical_fertilizer_replaced_kg, 0) }} kg</span>
                </div>
            </div>
            
            <!-- Report Information -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Report Information</h3>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Report Date:</span>
                    <span class="text-sm text-gray-900">{{ $environmentalImpact->report_date->format('M d, Y') }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Record Created:</span>
                    <span class="text-sm text-gray-900">{{ $environmentalImpact->created_at->format('M d, Y g:i A') }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Last Updated:</span>
                    <span class="text-sm text-gray-900">{{ $environmentalImpact->updated_at->format('M d, Y g:i A') }}</span>
                </div>
            </div>
        </div>
        
        @if($environmentalImpact->notes)
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2 mb-4">Notes</h3>
                <div class="bg-gray-50 rounded-lg p-4 text-sm text-gray-900">
                    {{ $environmentalImpact->notes }}
                </div>
            </div>
        @endif
        
        <!-- Action Buttons -->
        <div class="flex justify-end space-x-3">
            <form method="POST" action="{{ route('environmental-impact.destroy', $environmentalImpact) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this environmental impact record?')">
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
