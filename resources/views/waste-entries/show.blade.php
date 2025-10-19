@extends('layouts.app')

@section('title', 'Waste Entry Details')
@section('page-title', 'Waste Entry Details')
@section('page-description', 'View detailed information about waste entry')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Waste Entry #{{ $wasteEntry->id }}</h2>
                <p class="text-gray-600">Entry recorded on {{ $wasteEntry->entry_date->format('M d, Y') }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('waste-entries.edit', $wasteEntry) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <i class="fas fa-edit"></i>
                    <span>Edit</span>
                </a>
                <a href="{{ route('waste-entries.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back</span>
                </a>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Basic Information -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Basic Information</h3>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Entry Date:</span>
                    <span class="text-sm text-gray-900">{{ $wasteEntry->entry_date->format('M d, Y') }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Waste Type:</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $wasteEntry->waste_type == 'vegetable' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $wasteEntry->waste_type == 'fruit' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $wasteEntry->waste_type == 'plastic' ? 'bg-red-100 text-red-800' : '' }}
                        {{ $wasteEntry->waste_type == 'paper' ? 'bg-gray-100 text-gray-800' : '' }}">
                        <i class="fas fa-{{ $wasteEntry->waste_type == 'vegetable' ? 'carrot' : ($wasteEntry->waste_type == 'fruit' ? 'apple-alt' : ($wasteEntry->waste_type == 'paper' ? 'file-alt' : 'recycle')) }} mr-1"></i>
                        {{ ucfirst($wasteEntry->waste_type) }}
                    </span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Weight:</span>
                    <span class="text-sm text-gray-900 font-semibold">{{ number_format($wasteEntry->weight_kg, 2) }} kg</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Processing Technology:</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        <i class="fas fa-{{ $wasteEntry->processing_technology == 'anaerobic' ? 'biohazard' : ($wasteEntry->processing_technology == 'bsf' ? 'bug' : ($wasteEntry->processing_technology == 'pyrolysis' ? 'fire' : 'cog')) }} mr-1"></i>
                        {{ ucfirst($wasteEntry->processing_technology) }}
                    </span>
                </div>
            </div>
            
            <!-- Additional Information -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Additional Information</h3>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Created:</span>
                    <span class="text-sm text-gray-900">{{ $wasteEntry->created_at->format('M d, Y H:i') }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Last Updated:</span>
                    <span class="text-sm text-gray-900">{{ $wasteEntry->updated_at->format('M d, Y H:i') }}</span>
                </div>
                
                <div class="py-2">
                    <span class="text-sm font-medium text-gray-600 block mb-2">Notes:</span>
                    <div class="bg-gray-50 rounded-lg p-3 text-sm text-gray-900">
                        @if($wasteEntry->notes && trim($wasteEntry->notes) !== '')
                            {{ $wasteEntry->notes }}
                        @else
                            <span class="text-gray-500 italic">No notes provided</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related Process Batches -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2 mb-4">Related Process Batches</h3>
            @php
                $relatedBatches = $wasteEntry->processBatches()->where('input_type', $wasteEntry->waste_type)->get();
            @endphp
            
            @if($relatedBatches->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batch Number</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Process Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($relatedBatches as $batch)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $batch->batch_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ ucfirst(str_replace('_', ' ', $batch->process_type)) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $batch->status_badge }}">
                                            {{ ucfirst($batch->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $batch->start_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('anaerobic-digestion.show', $batch) }}" class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-info-circle text-3xl mb-3"></i>
                    <p>No related process batches found</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
