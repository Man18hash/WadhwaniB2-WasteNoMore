@extends('layouts.app')

@section('title', 'AI Batch Scheduling')
@section('page-title', 'AI Batch Scheduling')
@section('page-description', 'AI-powered optimal processing schedule recommendations')

@section('content')
<style>
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.loading {
    animation: pulse 1.5s ease-in-out infinite;
    pointer-events: none;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.message-slide-in {
    animation: slideIn 0.3s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

.modal-fade-in {
    animation: fadeIn 0.2s ease-out;
}
</style>

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
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-3">
                <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-2 rounded-lg">
                    <i class="fas fa-robot text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">AI Scheduling Recommendations</h3>
                    <p class="text-sm text-gray-600">Smart recommendations based on waste composition, weather, and demand patterns</p>
                </div>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg px-3 py-2">
                <span class="text-green-700 text-sm font-medium">
                    <i class="fas fa-check-circle mr-1"></i>
                    {{ count($schedulingRecommendations) }} Recommendations
                </span>
            </div>
        </div>
        
        @if(count($schedulingRecommendations) > 0)
            <div class="space-y-6">
                @foreach($schedulingRecommendations as $recommendation)
                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 border border-blue-200 rounded-xl p-6 hover:shadow-md transition-all duration-300">
                        <!-- Header Section -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-4">
                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                    <i class="fas fa-cogs text-blue-600 text-xl"></i>
                                </div>
                            <div>
                                    <h4 class="text-lg font-bold text-gray-800">{{ $recommendation['batch_number'] }}</h4>
                                <p class="text-sm text-gray-600">Batch ID: {{ $recommendation['batch_id'] }}</p>
                                    <div class="flex items-center mt-1">
                                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                        <span class="text-xs text-green-600 font-medium">Ready for Processing</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center space-x-2 mb-2">
                                    <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                        <i class="fas fa-star mr-1"></i>
                                        Priority: {{ $recommendation['priority_score'] }}%
                                    </div>
                                    <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                        <i class="fas fa-chart-line mr-1"></i>
                                        Efficiency: {{ $recommendation['expected_efficiency'] }}
                                    </div>
                                </div>
                                <div class="text-xs text-gray-500">
                                    <i class="fas fa-clock mr-1"></i>
                                    Recommended: {{ $recommendation['recommended_start_time'] }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Batch Information -->
                        <div class="bg-white rounded-lg p-4 border border-gray-100 mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <h5 class="text-sm font-semibold text-gray-700 mb-2">Batch Details</h5>
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Process Type:</span>
                                            <span class="text-sm font-medium text-gray-800">{{ ucfirst(str_replace('_', ' ', $recommendation['process_type'])) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Input Type:</span>
                                            <span class="text-sm font-medium text-gray-800">{{ ucfirst($recommendation['input_type']) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Weight:</span>
                                            <span class="text-sm font-medium text-gray-800">{{ number_format($recommendation['input_weight_kg'], 2) }} kg</span>
                                        </div>
                                    </div>
                                </div>
                            <div>
                                    <h5 class="text-sm font-semibold text-gray-700 mb-2">Processing Schedule</h5>
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Input Start:</span>
                                            <span class="text-sm font-medium text-gray-800">{{ $recommendation['input_start_date']->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Input End:</span>
                                            <span class="text-sm font-medium text-gray-800">{{ $recommendation['input_end_date']->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Duration:</span>
                                            <span class="text-sm font-medium text-gray-800">{{ round($recommendation['processing_duration_hours'] / 24, 1) }} days</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Countdown Timer -->
                        <div class="bg-gradient-to-r {{ $recommendation['is_scheduled'] ? 'from-green-50 to-blue-50 border-green-200' : 'from-orange-50 to-red-50 border-orange-200' }} border rounded-lg p-4 mb-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-clock {{ $recommendation['is_scheduled'] ? 'text-green-600' : 'text-orange-600' }} mr-2"></i>
                                    <span class="text-sm font-semibold text-gray-700">
                                        {{ $recommendation['is_scheduled'] ? 'Scheduled Start Time:' : 'Recommended Start Time:' }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold {{ $recommendation['is_scheduled'] ? 'text-green-600' : 'text-orange-600' }}" id="countdown-{{ $recommendation['batch_id'] }}">
                                        {{ $recommendation['time_until_recommended'] }}
                                    </div>
                                    <div class="text-xs text-gray-500" id="date-{{ $recommendation['batch_id'] }}">
                                        {{ $recommendation['is_scheduled'] ? $recommendation['countdown_time']->format('Y-m-d H:i') : $recommendation['recommended_start_time'] }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Information Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="bg-white rounded-lg p-4 border border-gray-100">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-cloud-sun text-blue-500 mr-2"></i>
                                    <span class="text-sm font-semibold text-gray-700">Weather Factor</span>
                                </div>
                                <p class="text-sm text-gray-600">{{ $recommendation['weather_factor'] }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-gray-100">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-chart-bar text-green-500 mr-2"></i>
                                    <span class="text-sm font-semibold text-gray-700">Demand Factor</span>
                                </div>
                                <p class="text-sm text-gray-600">{{ $recommendation['demand_factor'] }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-gray-100">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                                    <span class="text-sm font-semibold text-gray-700">AI Insight</span>
                                </div>
                                <p class="text-sm text-gray-600">{{ $recommendation['reason'] }}</p>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-3 justify-end">
                            @if($recommendation['is_scheduled'])
                                <!-- Scheduled Batch Actions -->
                                <form method="POST" action="{{ route('ai-analytics.batch.approve', $recommendation['batch_id']) }}" class="inline" onsubmit="return confirmApproval('{{ $recommendation['batch_number'] }}')">
                                    @csrf
                                    <button type="submit" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-lg text-sm font-semibold transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                        <i class="fas fa-play mr-2"></i>Start Now
                                    </button>
                                </form>
                                
                                <button onclick="showScheduleModal('{{ $recommendation['batch_id'] }}', '{{ $recommendation['batch_number'] }}', '{{ $recommendation['process_type'] }}')" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-lg text-sm font-semibold transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                    <i class="fas fa-edit mr-2"></i>Reschedule
                                </button>
                                
                                <form method="POST" action="{{ route('ai-analytics.batch.reject', $recommendation['batch_id']) }}" class="inline" onsubmit="return confirmRejection('{{ $recommendation['batch_number'] }}')">
                                    @csrf
                                    <button type="submit" class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-3 rounded-lg text-sm font-semibold transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                        <i class="fas fa-times mr-2"></i>Cancel
                                    </button>
                                </form>
                            @else
                                <!-- Unscheduled Batch Actions -->
                                <form method="POST" action="{{ route('ai-analytics.batch.approve', $recommendation['batch_id']) }}" class="inline" onsubmit="return confirmApproval('{{ $recommendation['batch_number'] }}')">
                                    @csrf
                                    <button type="submit" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-lg text-sm font-semibold transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                        <i class="fas fa-check mr-2"></i>Accept & Start Processing
                                    </button>
                                </form>
                                
                                <button onclick="showScheduleModal('{{ $recommendation['batch_id'] }}', '{{ $recommendation['batch_number'] }}', '{{ $recommendation['process_type'] }}')" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-lg text-sm font-semibold transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                    <i class="fas fa-calendar-plus mr-2"></i>Schedule Later
                                </button>
                                
                                <form method="POST" action="{{ route('ai-analytics.batch.reject', $recommendation['batch_id']) }}" class="inline" onsubmit="return confirmRejection('{{ $recommendation['batch_number'] }}')">
                                    @csrf
                                    <button type="submit" class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-3 rounded-lg text-sm font-semibold transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                        <i class="fas fa-times mr-2"></i>Reject
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="bg-gray-50 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-alt text-4xl text-gray-400"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-600 mb-2">No Pending Batches</h4>
                <p class="text-gray-500 mb-4">All batches are currently scheduled or in progress</p>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 max-w-md mx-auto">
                    <p class="text-sm text-blue-700">
                        <i class="fas fa-info-circle mr-2"></i>
                        AI will automatically analyze new batches as they are created and provide scheduling recommendations.
                    </p>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Pending Batches -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-3">
                <div class="bg-gradient-to-r from-yellow-500 to-orange-500 p-2 rounded-lg">
                    <i class="fas fa-clock text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Pending Batches</h3>
                    <p class="text-sm text-gray-600">Batches waiting for AI analysis and scheduling</p>
                </div>
            </div>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg px-3 py-2">
                <span class="text-yellow-700 text-sm font-medium">
                    <i class="fas fa-hourglass-half mr-1"></i>
                    {{ count($pendingBatches) }} Pending
                </span>
            </div>
        </div>
        
        @if(count($pendingBatches) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($pendingBatches as $batch)
                    <div class="bg-gradient-to-br from-yellow-50 to-orange-50 border border-yellow-200 rounded-xl p-5 hover:shadow-md transition-all duration-300">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white p-2 rounded-lg shadow-sm">
                                    <i class="fas fa-cube text-yellow-600 text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">{{ $batch->batch_number }}</h4>
                                    <p class="text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $batch->process_type)) }}</p>
                                </div>
                            </div>
                            <div class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-clock mr-1"></i>
                                        {{ ucfirst($batch->status) }}
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Input Weight</span>
                                <span class="text-sm font-semibold text-gray-800">{{ number_format($batch->input_weight_kg, 0) }} kg</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Expected Completion</span>
                                <span class="text-sm font-semibold text-gray-800">{{ $batch->expected_completion_date->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Input Type</span>
                                <span class="text-sm font-semibold text-gray-800">{{ ucfirst($batch->input_type) }}</span>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-yellow-200">
                            <div class="flex items-center text-xs text-yellow-600">
                                <i class="fas fa-robot mr-2"></i>
                                <span>Awaiting AI analysis for optimal scheduling</span>
                            </div>
                        </div>
                    </div>
                        @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="bg-gray-50 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check-circle text-4xl text-green-400"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-600 mb-2">All Batches Scheduled</h4>
                <p class="text-gray-500 mb-4">Great! All batches are currently scheduled or in progress</p>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 max-w-md mx-auto">
                    <p class="text-sm text-green-700">
                        <i class="fas fa-thumbs-up mr-2"></i>
                        Your waste processing pipeline is running smoothly with no pending batches.
                    </p>
                </div>
            </div>
        @endif
    </div>
    
    <!-- AI Insights -->
    <div class="bg-gradient-to-br from-blue-50 via-purple-50 to-indigo-50 rounded-xl border border-blue-200 p-6">
        <div class="flex items-center space-x-3 mb-6">
            <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-2 rounded-lg">
                <i class="fas fa-brain text-white text-lg"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-800">AI Insights & Recommendations</h3>
                <p class="text-sm text-gray-600">Real-time analysis of optimal processing conditions</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl p-5 border border-blue-100 shadow-sm">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 p-2 rounded-lg mr-3">
                        <i class="fas fa-clock text-blue-600"></i>
                    </div>
                    <h4 class="font-bold text-gray-800">Optimal Processing Windows</h4>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border border-green-200">
                        <div class="flex items-center">
                            <i class="fas fa-sun text-yellow-500 mr-2"></i>
                            <span class="text-sm font-medium text-gray-700">Morning (6 AM - 10 AM)</span>
                        </div>
                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Anaerobic Digestion</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center">
                            <i class="fas fa-sun text-orange-500 mr-2"></i>
                            <span class="text-sm font-medium text-gray-700">Afternoon (2 PM - 6 PM)</span>
                        </div>
                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">BSF Larvae</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg border border-purple-200">
                        <div class="flex items-center">
                            <i class="fas fa-moon text-indigo-500 mr-2"></i>
                            <span class="text-sm font-medium text-gray-700">Evening (7 PM - 11 PM)</span>
                        </div>
                        <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded-full">Pyrolysis</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-5 border border-blue-100 shadow-sm">
                <div class="flex items-center mb-4">
                    <div class="bg-green-100 p-2 rounded-lg mr-3">
                        <i class="fas fa-cloud-sun text-green-600"></i>
                    </div>
                    <h4 class="font-bold text-gray-800">Weather Impact Analysis</h4>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center p-3 bg-green-50 rounded-lg border border-green-200">
                        <i class="fas fa-tint text-blue-500 mr-3"></i>
                        <div>
                            <span class="text-sm font-medium text-gray-700">High Humidity</span>
                            <p class="text-xs text-gray-600">Optimal for anaerobic digestion processes</p>
                        </div>
                    </div>
                    <div class="flex items-center p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                        <i class="fas fa-thermometer-half text-orange-500 mr-3"></i>
                        <div>
                            <span class="text-sm font-medium text-gray-700">Moderate Temperature</span>
                            <p class="text-xs text-gray-600">Perfect conditions for BSF larvae cultivation</p>
                        </div>
                    </div>
                    <div class="flex items-center p-3 bg-blue-50 rounded-lg border border-blue-200">
                        <i class="fas fa-wind text-gray-500 mr-3"></i>
                        <div>
                            <span class="text-sm font-medium text-gray-700">Low Wind Conditions</span>
                            <p class="text-xs text-gray-600">Safe environment for pyrolysis operations</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-6 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl p-4 text-white">
            <div class="flex items-center">
                <i class="fas fa-lightbulb text-yellow-300 text-xl mr-3"></i>
                <div>
                    <h4 class="font-bold">Pro Tip</h4>
                    <p class="text-sm opacity-90">AI continuously monitors conditions and adjusts recommendations in real-time for maximum efficiency and safety.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Schedule Later Modal -->
<div id="scheduleModal" class="fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 backdrop-blur-sm">
    <div class="relative top-20 mx-auto p-0 w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden modal-fade-in">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                            <i class="fas fa-calendar-plus text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">Schedule Batch Later</h3>
                            <p class="text-sm opacity-90">Choose optimal processing time</p>
                        </div>
                    </div>
                    <button onclick="closeScheduleModal()" class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <form id="scheduleForm" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="scheduled_date" class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-clock mr-2 text-blue-500"></i>
                            New Scheduled Date & Time
                        </label>
                        <input type="datetime-local" name="scheduled_date" id="scheduled_date" 
                               class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                               min="{{ now()->format('Y-m-d\TH:i') }}" required
                               onchange="calculateCompletionDate()">
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Select today or any future date and time for optimal processing conditions
                        </p>
                    </div>
                    
                    <!-- Calculated Completion Date -->
                    <div id="completionDateInfo" class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6 hidden">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-calendar-check text-green-500 mr-2"></i>
                            <span class="text-sm font-semibold text-green-800">Expected Completion</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-green-700">
                                    <span class="font-medium">Start Date:</span>
                                    <span id="calculatedStartDate" class="ml-2">-</span>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-green-700">
                                    <span class="font-medium">Completion Date:</span>
                                    <span id="calculatedCompletionDate" class="ml-2">-</span>
                                </p>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-sm text-green-700">
                                <span class="font-medium">Processing Duration:</span>
                                <span id="processingDuration" class="ml-2">-</span>
                            </p>
                        </div>
                    </div>
                    
                    <!-- AI Recommendation -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-robot text-blue-500 mr-2"></i>
                            <span class="text-sm font-semibold text-blue-800">AI Recommendation</span>
                        </div>
                        <p class="text-sm text-blue-700">
                            Consider scheduling during optimal processing windows for maximum efficiency and safety.
                        </p>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex space-x-3">
                        <button type="button" onclick="closeScheduleModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-xl font-semibold transition-all duration-200">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </button>
                        <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white px-4 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="fas fa-calendar-check mr-2"></i>Schedule
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
<div id="messageContainer" class="fixed top-4 right-4 z-50 hidden">
    <div id="messageBox" class="bg-white rounded-xl shadow-2xl border border-gray-100 p-4 max-w-sm message-slide-in">
        <div class="flex items-start">
            <div id="messageIcon" class="flex-shrink-0 mr-3">
                <div class="w-8 h-8 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                </div>
            </div>
            <div class="flex-1">
                <p id="messageText" class="text-sm font-semibold text-gray-900 mb-1"></p>
                <p id="messageSubtext" class="text-xs text-gray-600"></p>
            </div>
            <button onclick="hideMessage()" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <!-- Progress Bar -->
        <div class="mt-3 bg-gray-200 rounded-full h-1 overflow-hidden">
            <div id="progressBar" class="h-full bg-green-500 transition-all duration-5000 ease-linear"></div>
        </div>
    </div>
</div>

<script>
function confirmApproval(batchNumber) {
    return confirm(`Are you sure you want to approve batch ${batchNumber} for processing? This will start the batch immediately.`);
}

function confirmRejection(batchNumber) {
    return confirm(`Are you sure you want to reject batch ${batchNumber}? This will cancel the batch permanently.`);
}

// Store current batch info for calculations
let currentBatchInfo = {};

function showScheduleModal(batchId, batchNumber, processType) {
    document.getElementById('scheduleForm').action = `/ai-analytics/batch/${batchId}/schedule-later`;
    
    // Store batch info for calculations
    currentBatchInfo = {
        batchId: batchId,
        batchNumber: batchNumber,
        processType: processType
    };
    
    // Reset form and hide completion info
    document.getElementById('scheduled_date').value = '';
    document.getElementById('completionDateInfo').classList.add('hidden');
    
    document.getElementById('scheduleModal').classList.remove('hidden');
}

function closeScheduleModal() {
    document.getElementById('scheduleModal').classList.add('hidden');
    document.getElementById('completionDateInfo').classList.add('hidden');
}

function calculateCompletionDate() {
    const scheduledDate = document.getElementById('scheduled_date').value;
    if (!scheduledDate) {
        document.getElementById('completionDateInfo').classList.add('hidden');
        return;
    }
    
    // Get processing duration based on batch type
    const processingDurations = {
        'anaerobic_digestion': 168, // 7 days
        'bsf_larvae': 336, // 14 days
        'activated_carbon': 72, // 3 days
        'paper_packaging': 48, // 2 days
        'pyrolysis': 24 // 1 day
    };
    
    // Use the actual process type from current batch info
    const processType = currentBatchInfo.processType || 'activated_carbon';
    const processingHours = processingDurations[processType] || 72; // Default to 3 days
    
    const startDate = new Date(scheduledDate);
    const completionDate = new Date(startDate.getTime() + (processingHours * 60 * 60 * 1000));
    
    // Update the display
    document.getElementById('calculatedStartDate').textContent = startDate.toLocaleString();
    document.getElementById('calculatedCompletionDate').textContent = completionDate.toLocaleString();
    document.getElementById('processingDuration').textContent = `${processingHours / 24} days`;
    
    // Show the completion info
    document.getElementById('completionDateInfo').classList.remove('hidden');
}

function showMessage(message, type = 'success', subtext = '') {
    const container = document.getElementById('messageContainer');
    const messageBox = document.getElementById('messageBox');
    const messageText = document.getElementById('messageText');
    const messageSubtext = document.getElementById('messageSubtext');
    const messageIcon = document.getElementById('messageIcon');
    const progressBar = document.getElementById('progressBar');
    
    messageText.textContent = message;
    messageSubtext.textContent = subtext;
    
    if (type === 'success') {
        messageBox.className = 'bg-white rounded-xl shadow-2xl border border-gray-100 p-4 max-w-sm';
        messageIcon.innerHTML = '<div class="w-8 h-8 rounded-full flex items-center justify-center"><i class="fas fa-check-circle text-green-500 text-xl"></i></div>';
        progressBar.className = 'h-full bg-green-500 transition-all duration-5000 ease-linear';
    } else {
        messageBox.className = 'bg-white rounded-xl shadow-2xl border border-gray-100 p-4 max-w-sm';
        messageIcon.innerHTML = '<div class="w-8 h-8 rounded-full flex items-center justify-center"><i class="fas fa-exclamation-circle text-red-500 text-xl"></i></div>';
        progressBar.className = 'h-full bg-red-500 transition-all duration-5000 ease-linear';
    }
    
    container.classList.remove('hidden');
    
    // Reset and start progress bar
    progressBar.style.width = '0%';
    setTimeout(() => {
        progressBar.style.width = '100%';
    }, 100);
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        hideMessage();
    }, 5000);
}

function hideMessage() {
    document.getElementById('messageContainer').classList.add('hidden');
}

// Handle form submissions with AJAX for better UX
document.addEventListener('DOMContentLoaded', function() {
    // Handle approval forms
    document.querySelectorAll('form[action*="/approve"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const url = this.action;
            
            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(data.message, 'success', 'Batch status updated successfully');
                    // Reload page after 2 seconds to show updated status
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    showMessage('Error: ' + (data.message || 'Something went wrong'), 'error', 'Please try again or contact support');
                }
            })
            .catch(error => {
                showMessage('Error: ' + error.message, 'error', 'Network or server error occurred');
            });
        });
    });
    
    // Handle rejection forms
    document.querySelectorAll('form[action*="/reject"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const url = this.action;
            
            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(data.message, 'success', 'Batch rejected and cancelled');
                    // Reload page after 2 seconds to show updated status
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    showMessage('Error: ' + (data.message || 'Something went wrong'), 'error', 'Please try again or contact support');
                }
            })
            .catch(error => {
                showMessage('Error: ' + error.message, 'error', 'Network or server error occurred');
            });
        });
    });
    
    // Handle schedule later form
    document.getElementById('scheduleForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const url = this.action;
        
        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const successMessage = `${data.message}\n\nStart: ${data.scheduled_date}\nCompletion: ${data.expected_completion_date}`;
                showMessage(data.message, 'success', `Start: ${data.scheduled_date} | Completion: ${data.expected_completion_date}`);
                closeScheduleModal();
                // Reload page after 2 seconds to show updated status
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                showMessage('Error: ' + (data.message || 'Something went wrong'), 'error', 'Please try again or contact support');
            }
        })
        .catch(error => {
            showMessage('Error: ' + error.message, 'error', 'Network or server error occurred');
        });
    });
    
    // Initialize countdown timers
    initializeCountdownTimers();
});

// Countdown timer functionality
function initializeCountdownTimers() {
    @foreach($schedulingRecommendations as $recommendation)
        startCountdown('{{ $recommendation['batch_id'] }}', '{{ $recommendation['countdown_time']->format('Y-m-d H:i:s') }}');
    @endforeach
}

function startCountdown(batchId, targetTime) {
    const countdownElement = document.getElementById('countdown-' + batchId);
    if (!countdownElement) return;
    
    const target = new Date(targetTime).getTime();
    
    function updateCountdown() {
        const now = new Date().getTime();
        const distance = target - now;
        
        if (distance < 0) {
            // Show OVERDUE with more prominent styling
            const overdueText = '<span class="text-red-600 font-bold text-xl">⚠️ OVERDUE</span>';
            countdownElement.innerHTML = overdueText;
            
            // Update the date display to show it's overdue with prominent styling
            const dateElement = document.getElementById('date-' + batchId);
            if (dateElement) {
                dateElement.innerHTML = `<span class="text-red-600 font-bold">${new Date(target).toLocaleString()} - OVERDUE</span>`;
            }
            
            // Change container styling to red with animation
            const parentContainer = countdownElement.closest('.bg-gradient-to-r');
            if (parentContainer) {
                parentContainer.className = 'bg-gradient-to-r from-red-100 to-red-200 border-red-400 border-2 rounded-lg p-4 mb-4 animate-pulse';
            }
            return;
        }
        
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        let countdownText = '';
        if (days > 0) {
            countdownText = `${days}d ${hours}h ${minutes}m`;
        } else if (hours > 0) {
            countdownText = `${hours}h ${minutes}m ${seconds}s`;
        } else if (minutes > 0) {
            countdownText = `${minutes}m ${seconds}s`;
        } else {
            countdownText = `${seconds}s`;
        }
        
        countdownElement.innerHTML = countdownText;
        
        // Ensure the date is always visible
        const dateElement = document.getElementById('date-' + batchId);
        if (dateElement && !dateElement.innerHTML.includes('OVERDUE')) {
            dateElement.innerHTML = `<span class="text-gray-500">${new Date(target).toLocaleString()}</span>`;
        }
        
        // Change color based on urgency and status
        const parentContainer = countdownElement.closest('.bg-gradient-to-r');
        if (distance < 3600000) { // Less than 1 hour
            countdownElement.className = 'text-red-600 font-bold';
        } else if (distance < 7200000) { // Less than 2 hours
            countdownElement.className = 'text-orange-600 font-bold';
        } else {
            // Keep the original color based on scheduled status
            const isScheduled = parentContainer && parentContainer.classList.contains('border-green-200');
            countdownElement.className = isScheduled ? 'text-green-600 font-bold' : 'text-orange-600 font-bold';
        }
    }
    
    // Update immediately and then every second
    updateCountdown();
    setInterval(updateCountdown, 1000);
}
</script>
@endsection
