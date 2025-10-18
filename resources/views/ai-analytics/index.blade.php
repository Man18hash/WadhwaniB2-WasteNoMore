@extends('layouts.app')

@section('title', 'AI Analytics')
@section('page-title', 'AI Analytics')
@section('page-description', 'AI-powered waste management optimization and predictions')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">AI Analytics Dashboard</h2>
            <p class="text-gray-600">Leverage artificial intelligence for optimal waste processing</p>
        </div>
        <div class="flex space-x-3">
            <div class="bg-gradient-to-r from-purple-500 to-blue-500 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-brain mr-2"></i>
                <span>AI Powered</span>
            </div>
        </div>
    </div>
    
    <!-- AI Features Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Batch Scheduling -->
        <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-blue-100 rounded-full p-3 mr-4">
                    <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">AI Batch Scheduling</h3>
                    <p class="text-sm text-gray-600">Optimize processing schedules</p>
                </div>
            </div>
            <p class="text-gray-700 mb-4">Machine learning algorithms analyze waste composition, weather conditions, and demand patterns to recommend optimal processing schedules.</p>
            <a href="{{ route('ai-analytics.batch-scheduling') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                <i class="fas fa-arrow-right mr-2"></i>
                View Scheduling
            </a>
        </div>
        
        <!-- Yield Prediction -->
        <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-green-100 rounded-full p-3 mr-4">
                    <i class="fas fa-chart-line text-green-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Yield Prediction</h3>
                    <p class="text-sm text-gray-600">Predict output quantities</p>
                </div>
            </div>
            <p class="text-gray-700 mb-4">AI models predict biogas, digestate, and larvae production based on input waste characteristics and historical data.</p>
            <a href="{{ route('ai-analytics.yield-prediction') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                <i class="fas fa-arrow-right mr-2"></i>
                Predict Yields
            </a>
        </div>
        
        <!-- Quality Assessment -->
        <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-purple-100 rounded-full p-3 mr-4">
                    <i class="fas fa-eye text-purple-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Quality Assessment</h3>
                    <p class="text-sm text-gray-600">AI image recognition</p>
                </div>
            </div>
            <p class="text-gray-700 mb-4">Computer vision technology assesses waste quality and contamination levels using image recognition algorithms.</p>
            <a href="{{ route('ai-analytics.quality-assessment') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                <i class="fas fa-arrow-right mr-2"></i>
                Assess Quality
            </a>
        </div>
    </div>
    
    <!-- AI Predictions Overview -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Current AI Predictions</h3>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Optimal Schedule -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4">
                <div class="flex items-center mb-3">
                    <i class="fas fa-clock text-blue-600 text-xl mr-3"></i>
                    <h4 class="font-semibold text-gray-800">Optimal Schedule</h4>
                </div>
                <div class="space-y-2">
                    <p class="text-sm text-gray-600">Next Batch Time:</p>
                    <p class="font-semibold text-blue-800">{{ $aiPredictions['optimal_schedule']['next_batch_time'] }}</p>
                    <p class="text-sm text-gray-600">Recommended Process:</p>
                    <p class="font-semibold text-blue-800">{{ ucfirst(str_replace('_', ' ', $aiPredictions['optimal_schedule']['recommended_process'])) }}</p>
                    <p class="text-sm text-gray-600">Efficiency Score:</p>
                    <p class="font-semibold text-blue-800">{{ $aiPredictions['optimal_schedule']['efficiency_score'] }}%</p>
                </div>
            </div>
            
            <!-- Yield Forecast -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4">
                <div class="flex items-center mb-3">
                    <i class="fas fa-seedling text-green-600 text-xl mr-3"></i>
                    <h4 class="font-semibold text-gray-800">Yield Forecast</h4>
                </div>
                <div class="space-y-2">
                    <p class="text-sm text-gray-600">Biogas Predicted:</p>
                    <p class="font-semibold text-green-800">{{ $aiPredictions['yield_forecast']['biogas_predicted'] }} m³</p>
                    <p class="text-sm text-gray-600">Digestate Predicted:</p>
                    <p class="font-semibold text-green-800">{{ $aiPredictions['yield_forecast']['digestate_predicted'] }} kg</p>
                    <p class="text-sm text-gray-600">Confidence Level:</p>
                    <p class="font-semibold text-green-800">{{ $aiPredictions['yield_forecast']['confidence_level'] }}%</p>
                </div>
            </div>
            
            <!-- Quality Score -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4">
                <div class="flex items-center mb-3">
                    <i class="fas fa-star text-purple-600 text-xl mr-3"></i>
                    <h4 class="font-semibold text-gray-800">Quality Score</h4>
                </div>
                <div class="space-y-2">
                    <p class="text-sm text-gray-600">Overall Quality:</p>
                    <p class="font-semibold text-purple-800">{{ $aiPredictions['quality_score']['overall_quality'] }}%</p>
                    <p class="text-sm text-gray-600">Contamination Level:</p>
                    <p class="font-semibold text-purple-800">{{ $aiPredictions['quality_score']['contamination_level'] }}</p>
                    <p class="text-sm text-gray-600">Status:</p>
                    <p class="font-semibold text-purple-800">Good</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Analysis -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Waste Entries -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Waste Entries for Analysis</h3>
            <div class="space-y-3">
                @forelse($recentWasteEntries as $entry)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">{{ ucfirst($entry->waste_type) }} Waste</p>
                            <p class="text-sm text-gray-600">{{ number_format($entry->weight_kg, 0) }} kg - {{ $entry->entry_date->format('M d, Y') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst($entry->technology) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No recent waste entries</p>
                @endforelse
            </div>
        </div>
        
        <!-- Active Batches -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Active Batches</h3>
            <div class="space-y-3">
                @forelse($activeBatches as $batch)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">{{ $batch->batch_number }}</p>
                            <p class="text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $batch->process_type)) }} - {{ $batch->status }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                @if($batch->status === 'processing') bg-green-100 text-green-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($batch->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No active batches</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
