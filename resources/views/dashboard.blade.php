@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Overview of waste management operations at NVAT')

@section('content')
<div class="space-y-6">
    <!-- Summary Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Waste This Week</p>
                    <p class="text-3xl font-bold">{{ number_format($weeklyStats->total_waste_kg ?? 0, 0) }} kg</p>
                </div>
                <div class="bg-blue-400 rounded-full p-3">
                    <i class="fas fa-trash-alt text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Biogas Generated</p>
                    <p class="text-3xl font-bold">{{ number_format($weeklyStats->biogas_generated_m3 ?? 0, 0) }} m³</p>
                </div>
                <div class="bg-green-400 rounded-full p-3">
                    <i class="fas fa-fire text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Revenue This Month</p>
                    <p class="text-3xl font-bold">₱{{ number_format($monthlySales->sum('total_amount') ?? 0, 0) }}</p>
                </div>
                <div class="bg-purple-400 rounded-full p-3">
                    <i class="fas fa-dollar-sign text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">CO₂ Reduced</p>
                    <p class="text-3xl font-bold">{{ number_format($monthlyEnvironmentalImpact->co2_emissions_reduced_kg ?? 0, 0) }} kg</p>
                </div>
                <div class="bg-orange-400 rounded-full p-3">
                    <i class="fas fa-leaf text-2xl"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Process Streams Overview -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Process Streams Overview</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                <div class="flex items-center justify-between mb-2">
                    <i class="fas fa-biohazard text-blue-600 text-xl"></i>
                    <span class="text-sm font-medium text-blue-800">Anaerobic</span>
                </div>
                <p class="text-2xl font-bold text-blue-900">{{ $activeBatches->where('process_type', 'anaerobic_digestion')->count() }}</p>
                <p class="text-xs text-blue-600">Active Batches</p>
            </div>
            
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                <div class="flex items-center justify-between mb-2">
                    <i class="fas fa-bug text-green-600 text-xl"></i>
                    <span class="text-sm font-medium text-green-800">BSF Larvae</span>
                </div>
                <p class="text-2xl font-bold text-green-900">{{ $activeBatches->where('process_type', 'bsf_larvae')->count() }}</p>
                <p class="text-xs text-green-600">Active Cycles</p>
            </div>
            
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                <div class="flex items-center justify-between mb-2">
                    <i class="fas fa-atom text-purple-600 text-xl"></i>
                    <span class="text-sm font-medium text-purple-800">Activated Carbon</span>
                </div>
                <p class="text-2xl font-bold text-purple-900">{{ $activeBatches->where('process_type', 'activated_carbon')->count() }}</p>
                <p class="text-xs text-purple-600">Active Batches</p>
            </div>
            
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-4 border border-yellow-200">
                <div class="flex items-center justify-between mb-2">
                    <i class="fas fa-file-alt text-yellow-600 text-xl"></i>
                    <span class="text-sm font-medium text-yellow-800">Paper & Packaging</span>
                </div>
                <p class="text-2xl font-bold text-yellow-900">{{ $activeBatches->where('process_type', 'paper_packaging')->count() }}</p>
                <p class="text-xs text-yellow-600">Active Batches</p>
            </div>
            
            <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-4 border border-red-200">
                <div class="flex items-center justify-between mb-2">
                    <i class="fas fa-fire text-red-600 text-xl"></i>
                    <span class="text-sm font-medium text-red-800">Pyrolysis</span>
                </div>
                <p class="text-2xl font-bold text-red-900">{{ $activeBatches->where('process_type', 'pyrolysis')->count() }}</p>
                <p class="text-xs text-red-600">Active Batches</p>
            </div>
        </div>
    </div>
    
    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Waste Distribution Chart -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Waste Distribution This Week</h3>
            <div class="h-64">
                <canvas id="wasteDistributionChart"></canvas>
            </div>
        </div>
        
        <!-- Weekly Trends Chart -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Weekly Trends (Last 4 Weeks)</h3>
            <div class="h-64">
                <canvas id="weeklyTrendsChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Output Production Chart -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Output Production This Week</h3>
        <div class="h-64">
            <canvas id="outputProductionChart"></canvas>
        </div>
    </div>
    
    <!-- Recent Activities and Low Stock Alerts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activities -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activities</h3>
            <div class="space-y-3">
                @forelse($recentActivities as $activity)
                    <div class="flex items-center space-x-3 p-3 bg-green-50 rounded-lg">
                        <div class="bg-green-500 rounded-full p-2">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">{{ $activity->batch_number }}</p>
                            <p class="text-sm text-gray-600">{{ $activity->process_type }}</p>
                            <p class="text-xs text-gray-500">{{ $activity->actual_completion_date->format('M d, Y') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No recent activities</p>
                @endforelse
            </div>
        </div>
        
        <!-- Low Stock Alerts -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Low Stock Alerts</h3>
            <div class="space-y-3">
                @forelse($lowStockItems as $item)
                    <div class="flex items-center space-x-3 p-3 bg-yellow-50 rounded-lg">
                        <div class="bg-yellow-500 rounded-full p-2">
                            <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">{{ ucfirst(str_replace('_', ' ', $item->product_type)) }}</p>
                            <p class="text-sm text-gray-600">{{ number_format($item->current_stock, 2) }} {{ $item->unit }}</p>
                            <p class="text-xs text-yellow-600">Low Stock Alert</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">All items are well stocked</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Wait for Chart.js to be loaded
document.addEventListener('DOMContentLoaded', function() {
    // Waste Distribution Chart
    const wasteCtx = document.getElementById('wasteDistributionChart').getContext('2d');
    new Chart(wasteCtx, {
        type: 'doughnut',
        data: {
            labels: ['Vegetable', 'Fruit', 'Plastic'],
            datasets: [{
                data: [
                    {{ $wasteDistribution['vegetable'] ?? 0 }},
                    {{ $wasteDistribution['fruit'] ?? 0 }},
                    {{ $wasteDistribution['plastic'] ?? 0 }}
                ],
                backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Weekly Trends Chart
    const trendsCtx = document.getElementById('weeklyTrendsChart').getContext('2d');
    new Chart(trendsCtx, {
        type: 'line',
        data: {
            labels: [
                @if($weeklyTrends->isNotEmpty())
                    @foreach($weeklyTrends as $week)
                        'Week {{ $week->week_number }}',
                    @endforeach
                @else
                    'Week {{ $currentWeekNumber - 3 }}', 'Week {{ $currentWeekNumber - 2 }}', 'Week {{ $currentWeekNumber - 1 }}', 'Week {{ $currentWeekNumber }}'
                @endif
            ],
            datasets: [{
                label: 'Total Waste (kg)',
                data: [
                    @if($weeklyTrends->isNotEmpty())
                        @foreach($weeklyTrends as $week)
                            {{ $week->total_waste_kg ?? 0 }},
                        @endforeach
                    @else
                        150, 200, 180, 220
                    @endif
                ],
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Output Production Chart
    const outputCtx = document.getElementById('outputProductionChart').getContext('2d');
    new Chart(outputCtx, {
        type: 'bar',
        data: {
            labels: ['Biogas (m³)', 'Digestate (kg)', 'Larvae (kg)', 'Pyrolysis Oil (L)', 'Activated Carbon (kg)'],
            datasets: [{
                label: 'Production This Week',
                data: [
                    {{ $outputProduction['biogas'] ?? 0 }},
                    {{ $outputProduction['digestate'] ?? 0 }},
                    {{ $outputProduction['larvae'] ?? 0 }},
                    {{ $outputProduction['pyrolysis_oil'] ?? 0 }},
                    {{ $outputProduction['activated_carbon'] ?? 0 }}
                ],
                backgroundColor: [
                    '#10B981',
                    '#3B82F6',
                    '#8B5CF6',
                    '#F59E0B',
                    '#EF4444'
                ],
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endpush
@endsection
