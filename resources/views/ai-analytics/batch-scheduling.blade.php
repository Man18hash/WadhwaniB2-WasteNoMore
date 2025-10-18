@extends('layouts.app')

@section('title', 'AI Batch Scheduling')
@section('page-title', 'AI Batch Scheduling')
@section('page-description', 'AI-powered optimal processing schedule recommendations')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('ai-analytics.index') }}" class="text-gray-500 hover:text-gray-700 transition-colors">
                    <i class="fas fa-arrow-left text-lg"></i>
                </a>
                <h2 class="text-2xl font-semibold text-gray-800">AI Batch Scheduling</h2>
            </div>
            <p class="text-gray-600">Machine learning optimized processing schedules based on waste composition, weather, and demand</p>
        </div>
        <div class="flex space-x-3">
            <div class="bg-gradient-to-r from-blue-500 to-purple-500 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-brain mr-2"></i>
                <span>ML Algorithm Active</span>
            </div>
        </div>
    </div>
    
    <!-- AI Analytics Navigation -->
    <div class="bg-white rounded-lg shadow-sm p-4">
        <div class="flex flex-wrap gap-3 justify-center">
            <a href="{{ route('ai-analytics.yield-prediction') }}" class="bg-green-100 text-green-800 px-4 py-2 rounded-lg font-medium hover:bg-green-200 transition-colors">
                <i class="fas fa-chart-line mr-2"></i>
                Yield Prediction
            </a>
            <a href="{{ route('ai-analytics.quality-assessment') }}" class="bg-purple-100 text-purple-800 px-4 py-2 rounded-lg font-medium hover:bg-purple-200 transition-colors">
                <i class="fas fa-eye mr-2"></i>
                Image Recognition
            </a>
            <a href="{{ route('ai-analytics.batch-scheduling') }}" class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg font-medium border-2 border-blue-300">
                <i class="fas fa-robot mr-2"></i>
                Batch Scheduling
            </a>
        </div>
    </div>
    
    <!-- AI Analysis Factors -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">AI Analysis Factors</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-50 rounded-lg p-4">
                <div class="flex items-center mb-2">
                    <i class="fas fa-leaf text-blue-600 mr-2"></i>
                    <h4 class="font-semibold text-gray-800">Waste Composition</h4>
                </div>
                <p class="text-sm text-gray-600">Analyzing organic content, moisture levels, and contamination</p>
            </div>
            <div class="bg-green-50 rounded-lg p-4">
                <div class="flex items-center mb-2">
                    <i class="fas fa-cloud-sun text-green-600 mr-2"></i>
                    <h4 class="font-semibold text-gray-800">Weather Conditions</h4>
                </div>
                <p class="text-sm text-gray-600">Temperature, humidity, and precipitation forecasts</p>
            </div>
            <div class="bg-purple-50 rounded-lg p-4">
                <div class="flex items-center mb-2">
                    <i class="fas fa-chart-line text-purple-600 mr-2"></i>
                    <h4 class="font-semibold text-gray-800">Demand Patterns</h4>
                </div>
                <p class="text-sm text-gray-600">Market demand and customer order patterns</p>
            </div>
        </div>
    </div>
    
    <!-- Scheduling Recommendations -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">AI Scheduling Recommendations</h3>
        
        @if(count($schedulingRecommendations) > 0)
            <div class="space-y-4">
                @foreach($schedulingRecommendations as $recommendation)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <h4 class="font-semibold text-gray-800">{{ $recommendation['batch_number'] }}</h4>
                                <p class="text-sm text-gray-600">Batch ID: {{ $recommendation['batch_id'] }}</p>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Priority: {{ $recommendation['priority_score'] }}%
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Efficiency: {{ $recommendation['expected_efficiency'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Recommended Start Time</p>
                                <p class="text-sm text-gray-800 font-semibold">{{ $recommendation['recommended_start_time'] }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Weather Factor</p>
                                <p class="text-sm text-gray-800 font-semibold">{{ $recommendation['weather_factor'] }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Demand Factor</p>
                                <p class="text-sm text-gray-800 font-semibold">{{ $recommendation['demand_factor'] }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">AI Recommendation</p>
                                <p class="text-sm text-gray-800 font-semibold">{{ $recommendation['reason'] }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-3 flex space-x-2">
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                <i class="fas fa-check mr-1"></i>Accept Recommendation
                            </button>
                            <button class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm">
                                <i class="fas fa-clock mr-1"></i>Schedule Later
                            </button>
                            <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                <i class="fas fa-times mr-1"></i>Reject
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-calendar-alt text-4xl text-gray-400 mb-4"></i>
                <p class="text-gray-500 text-lg">No pending batches for scheduling</p>
                <p class="text-gray-400 text-sm">AI will analyze new batches as they are created</p>
            </div>
        @endif
    </div>
    
    <!-- Pending Batches -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Pending Batches</h3>
        
        @if(count($pendingBatches) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batch Number</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Process Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Input Weight</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expected Completion</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pendingBatches as $batch)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $batch->batch_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ ucfirst(str_replace('_', ' ', $batch->process_type)) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($batch->input_weight_kg, 0) }} kg
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $batch->expected_completion_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        {{ ucfirst($batch->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
                <p class="text-gray-500 text-lg">No pending batches</p>
                <p class="text-gray-400 text-sm">All batches are scheduled or in progress</p>
            </div>
        @endif
    </div>
    
    <!-- AI Insights -->
    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">AI Insights</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-semibold text-gray-800 mb-2">Optimal Processing Window</h4>
                <p class="text-sm text-gray-600 mb-2">Based on current conditions, the optimal processing window is:</p>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Morning hours (6 AM - 10 AM) for anaerobic digestion</li>
                    <li>• Afternoon hours (2 PM - 6 PM) for BSF larvae cultivation</li>
                    <li>• Evening hours (7 PM - 11 PM) for pyrolysis operations</li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-gray-800 mb-2">Weather Impact</h4>
                <p class="text-sm text-gray-600 mb-2">Current weather conditions favor:</p>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• High humidity: Good for anaerobic digestion</li>
                    <li>• Moderate temperature: Optimal for BSF larvae</li>
                    <li>• Low wind: Safe for pyrolysis operations</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
