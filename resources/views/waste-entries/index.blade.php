@extends('layouts.app')

@section('title', 'Waste Entries')
@section('page-title', 'Waste Entries')
@section('page-description', 'Manage waste input entries and track processing technologies')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Waste Entries</h2>
            <p class="text-gray-600">Track and manage all waste input entries</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('waste-entries.export.excel') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-download"></i>
                <span>Export Excel</span>
            </a>
            <a href="{{ route('waste-entries.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-plus"></i>
                <span>Add Entry</span>
            </a>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="GET" action="{{ route('waste-entries.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div>
                <label for="waste_type" class="block text-sm font-medium text-gray-700 mb-1">Waste Type</label>
                <select name="waste_type" id="waste_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">All Types</option>
                    <option value="vegetable" {{ request('waste_type') == 'vegetable' ? 'selected' : '' }}>Vegetable</option>
                    <option value="fruit" {{ request('waste_type') == 'fruit' ? 'selected' : '' }}>Fruit</option>
                    <option value="plastic" {{ request('waste_type') == 'plastic' ? 'selected' : '' }}>Plastic</option>
                    <option value="paper" {{ request('waste_type') == 'paper' ? 'selected' : '' }}>Paper</option>
                </select>
            </div>
            
            <div>
                <label for="processing_technology" class="block text-sm font-medium text-gray-700 mb-1">Technology</label>
                <select name="processing_technology" id="processing_technology" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">All Technologies</option>
                    <option value="anaerobic" {{ request('processing_technology') == 'anaerobic' ? 'selected' : '' }}>Anaerobic</option>
                    <option value="bsf" {{ request('processing_technology') == 'bsf' ? 'selected' : '' }}>BSF</option>
                    <option value="activated" {{ request('processing_technology') == 'activated' ? 'selected' : '' }}>Activated</option>
                    <option value="paper" {{ request('processing_technology') == 'paper' ? 'selected' : '' }}>Paper</option>
                    <option value="pyrolysis" {{ request('processing_technology') == 'pyrolysis' ? 'selected' : '' }}>Pyrolysis</option>
                </select>
            </div>
            
            <div>
                <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>
            
            <div>
                <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>
    
    <!-- Waste Entries Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entry Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waste Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Weight</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Technology</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($wasteEntries as $entry)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $entry->entry_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $entry->waste_type == 'vegetable' ? 'bg-green-100 text-green-800' : 
                                       ($entry->waste_type == 'fruit' ? 'bg-yellow-100 text-yellow-800' : 
                                        ($entry->waste_type == 'plastic' ? 'bg-red-100 text-red-800' : 
                                         ($entry->waste_type == 'paper' ? 'bg-gray-100 text-gray-800' : 'bg-blue-100 text-blue-800'))) }}">
                                    <i class="fas fa-{{ $entry->waste_type == 'vegetable' ? 'carrot' : ($entry->waste_type == 'fruit' ? 'apple-alt' : ($entry->waste_type == 'paper' ? 'file-alt' : 'recycle')) }} mr-1"></i>
                                    {{ ucfirst($entry->waste_type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($entry->weight_kg, 2) }} kg
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-{{ $entry->processing_technology == 'anaerobic' ? 'biohazard' : ($entry->processing_technology == 'bsf' ? 'bug' : ($entry->processing_technology == 'pyrolysis' ? 'fire' : 'cog')) }} mr-1"></i>
                                    {{ ucfirst($entry->processing_technology) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate">
                                @if($entry->notes && trim($entry->notes) !== '')
                                    {{ $entry->notes }}
                                @else
                                    <span class="text-gray-500 italic">No notes</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('waste-entries.show', $entry) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('waste-entries.edit', $entry) }}" class="text-indigo-600 hover:text-indigo-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('waste-entries.destroy', $entry) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this entry?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-4"></i>
                                <p class="text-lg">No waste entries found</p>
                                <p class="text-sm">Start by adding your first waste entry</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($wasteEntries->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $wasteEntries->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
