@extends('layouts.app')

@section('title', 'Activated Carbon Batch Details')
@section('page-title', 'Activated Carbon Batch Details')
@section('page-description', 'View detailed information about activated carbon batch')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">{{ $activatedCarbon->batch_number }}</h2>
                <p class="text-gray-600">Activated carbon batch started on {{ $activatedCarbon->start_date->format('M d, Y') }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('activated-carbon.edit', $activatedCarbon) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <i class="fas fa-edit"></i>
                    <span>Edit</span>
                </a>
                <a href="{{ route('activated-carbon.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back</span>
                </a>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Basic Information -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Batch Information</h3>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Batch Number:</span>
                    <span class="text-sm text-gray-900 font-semibold">{{ $activatedCarbon->batch_number }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Input Type:</span>
                    <span class="text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $activatedCarbon->input_type)) }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Input Weight:</span>
                    <span class="text-sm text-gray-900 font-semibold">{{ number_format($activatedCarbon->input_weight_kg, 2) }} kg</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Status:</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $activatedCarbon->status_badge }}">
                        {{ ucfirst($activatedCarbon->status) }}
                    </span>
                </div>
            </div>
            
            <!-- Timeline Information -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Timeline</h3>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Start Date:</span>
                    <span class="text-sm text-gray-900">{{ $activatedCarbon->start_date->format('M d, Y') }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Expected Completion:</span>
                    <span class="text-sm text-gray-900">{{ $activatedCarbon->expected_completion_date ? $activatedCarbon->expected_completion_date->format('M d, Y') : '-' }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-gray-600">Actual Completion:</span>
                    <span class="text-sm text-gray-900">{{ $activatedCarbon->actual_completion_date ? $activatedCarbon->actual_completion_date->format('M d, Y') : '-' }}</span>
                </div>
                
                @if($activatedCarbon->description)
                    <div class="py-2">
                        <span class="text-sm font-medium text-gray-600 block mb-2">Description:</span>
                        <div class="bg-gray-50 rounded-lg p-3 text-sm text-gray-900">
                            {{ $activatedCarbon->description }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Outputs Section -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Production Outputs</h3>
                <button onclick="openOutputModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <i class="fas fa-plus"></i>
                    <span>Add Output</span>
                </button>
            </div>
            
            @if($activatedCarbon->batchOutputs->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Output Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quality</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($activatedCarbon->batchOutputs as $output)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ ucfirst(str_replace('_', ' ', $output->output_type)) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ number_format($output->quantity, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $output->unit }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $output->is_expected ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $output->is_expected ? 'Expected' : 'Actual' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $output->quality_grade ? $output->quality_grade . '%' : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <button onclick="editOutput({{ $output->id }})" class="text-indigo-600 hover:text-indigo-900">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form method="POST" action="{{ route('activated-carbon.outputs.destroy', [$activatedCarbon, $output]) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this output?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-cube text-3xl mb-3"></i>
                    <p>No outputs recorded yet</p>
                    <p class="text-sm">Add outputs to track activated carbon production</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Output Modal -->
<div id="outputModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Add Output</h3>
                <form method="POST" action="{{ route('activated-carbon.outputs.store', $activatedCarbon) }}" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="output_type" class="block text-sm font-medium text-gray-700 mb-2">Output Type *</label>
                        <select name="output_type" id="output_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                            <option value="">Select output type</option>
                            <option value="activated_carbon">Activated Carbon</option>
                            <option value="charcoal">Charcoal</option>
                            <option value="ash">Ash</option>
                            <option value="tar">Tar</option>
                        </select>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity *</label>
                            <input type="number" name="quantity" id="quantity" step="0.01" min="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                        </div>
                        
                        <div>
                            <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">Unit *</label>
                            <select name="unit" id="unit" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500" required>
                                <option value="kg">kg</option>
                                <option value="g">g</option>
                                <option value="tons">Tons</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_expected" value="1" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            <span class="ml-2 text-sm text-gray-700">This is an expected output</span>
                        </label>
                    </div>
                    
                    <div>
                        <label for="quality_grade" class="block text-sm font-medium text-gray-700 mb-2">Quality Grade (%)</label>
                        <input type="number" name="quality_grade" id="quality_grade" min="0" max="100" step="0.1" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    
                    <div>
                        <label for="remarks" class="block text-sm font-medium text-gray-700 mb-2">Remarks</label>
                        <textarea name="remarks" id="remarks" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeOutputModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition-colors">
                            Add Output
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openOutputModal() {
    document.getElementById('outputModal').classList.remove('hidden');
}

function closeOutputModal() {
    document.getElementById('outputModal').classList.add('hidden');
}

function editOutput(outputId) {
    // Implementation for editing outputs
    console.log('Edit output:', outputId);
}

// Close modal when clicking outside
document.getElementById('outputModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeOutputModal();
    }
});
</script>
@endpush
@endsection
