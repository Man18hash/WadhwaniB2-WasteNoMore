<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WasteEntry;
use App\Models\ProcessBatch;
use App\Models\BatchOutput;
use App\Models\WeeklyStatistic;
use App\Models\OutputInventory;
use App\Models\SalesRecord;
use App\Models\EnergyConsumption;
use App\Models\EnvironmentalImpact;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get current week statistics
        $currentWeek = Carbon::now()->startOfWeek();
        $currentYear = Carbon::now()->year;
        $currentWeekNumber = Carbon::now()->week;
        
        // Summary statistics for this week
        $weeklyStats = WeeklyStatistic::where('year', $currentYear)
            ->where('week_number', $currentWeekNumber)
            ->first();
            
        // If no weekly stats exist, calculate from raw data
        if (!$weeklyStats) {
            $weeklyStats = $this->calculateWeeklyStats($currentWeek, $currentWeek->copy()->endOfWeek());
        }
        
        // Recent waste entries (last 7 days)
        $recentWasteEntries = WasteEntry::where('entry_date', '>=', $currentWeek)
            ->orderBy('entry_date', 'desc')
            ->limit(5)
            ->get();
            
        // Active process batches
        $activeBatches = ProcessBatch::whereIn('status', ['pending', 'processing'])
            ->orderBy('start_date', 'desc')
            ->limit(5)
            ->get();
            
        // Recent activities (completed batches)
        $recentActivities = ProcessBatch::where('status', 'completed')
            ->where('actual_completion_date', '>=', Carbon::now()->subDays(7))
            ->orderBy('actual_completion_date', 'desc')
            ->limit(5)
            ->get();
            
        // Inventory alerts (low stock)
        $lowStockItems = OutputInventory::where('current_stock', '<', 100)
            ->orderBy('current_stock', 'asc')
            ->get();
            
        // Energy consumption this month
        $monthlyEnergyConsumption = EnergyConsumption::whereMonth('consumption_date', Carbon::now()->month)
            ->whereYear('consumption_date', Carbon::now()->year)
            ->get();
            
        // Sales this month
        $monthlySales = SalesRecord::whereMonth('sale_date', Carbon::now()->month)
            ->whereYear('sale_date', Carbon::now()->year)
            ->get();
            
        // Environmental impact this month
        $monthlyEnvironmentalImpact = EnvironmentalImpact::whereMonth('report_date', Carbon::now()->month)
            ->whereYear('report_date', Carbon::now()->year)
            ->first();
            
        // Chart data for waste distribution
        $wasteDistribution = [
            'vegetable' => WasteEntry::where('waste_type', 'vegetable')
                ->where('entry_date', '>=', $currentWeek)
                ->sum('weight_kg') ?: 0,
            'fruit' => WasteEntry::where('waste_type', 'fruit')
                ->where('entry_date', '>=', $currentWeek)
                ->sum('weight_kg') ?: 0,
            'plastic' => WasteEntry::where('waste_type', 'plastic')
                ->where('entry_date', '>=', $currentWeek)
                ->sum('weight_kg') ?: 0
        ];
        
        // Weekly trends data (last 4 weeks) - create sample data if none exists
        $weeklyTrends = WeeklyStatistic::where('year', $currentYear)
            ->where('week_number', '>=', $currentWeekNumber - 3)
            ->orderBy('week_number')
            ->get();
            
        // If no weekly trends data exists, create sample data for demonstration
        if ($weeklyTrends->isEmpty()) {
            $weeklyTrends = collect();
            for ($i = 3; $i >= 0; $i--) {
                $weekNumber = $currentWeekNumber - $i;
                $weekData = new \stdClass();
                $weekData->week_number = $weekNumber;
                $weekData->total_waste_kg = rand(100, 500); // Sample data
                $weeklyTrends->push($weekData);
            }
        }
            
        // Output production data
        $outputProduction = [
            'biogas' => BatchOutput::where('output_type', 'biogas')
                ->where('is_expected', false)
                ->where('output_date', '>=', $currentWeek)
                ->sum('quantity') ?: 0,
            'digestate' => BatchOutput::where('output_type', 'digestate')
                ->where('is_expected', false)
                ->where('output_date', '>=', $currentWeek)
                ->sum('quantity') ?: 0,
            'larvae' => BatchOutput::where('output_type', 'larvae')
                ->where('is_expected', false)
                ->where('output_date', '>=', $currentWeek)
                ->sum('quantity') ?: 0,
            'pyrolysis_oil' => BatchOutput::where('output_type', 'pyrolysis_oil')
                ->where('is_expected', false)
                ->where('output_date', '>=', $currentWeek)
                ->sum('quantity') ?: 0,
            'activated_carbon' => BatchOutput::where('output_type', 'activated_carbon')
                ->where('is_expected', false)
                ->where('output_date', '>=', $currentWeek)
                ->sum('quantity') ?: 0
        ];
        
        return view('dashboard', compact(
            'weeklyStats',
            'recentWasteEntries',
            'activeBatches',
            'recentActivities',
            'lowStockItems',
            'monthlyEnergyConsumption',
            'monthlySales',
            'monthlyEnvironmentalImpact',
            'wasteDistribution',
            'weeklyTrends',
            'outputProduction',
            'currentWeekNumber'
        ));
    }
    
    private function calculateWeeklyStats($startDate, $endDate)
    {
        $wasteEntries = WasteEntry::whereBetween('entry_date', [$startDate, $endDate])->get();
        
        $stats = new \stdClass();
        $stats->total_waste_kg = $wasteEntries->sum('weight_kg');
        $stats->vegetable_waste_kg = $wasteEntries->where('waste_type', 'vegetable')->sum('weight_kg');
        $stats->fruit_waste_kg = $wasteEntries->where('waste_type', 'fruit')->sum('weight_kg');
        $stats->plastic_waste_kg = $wasteEntries->where('waste_type', 'plastic')->sum('weight_kg');
        
        // Calculate outputs from completed batches
        $completedBatches = ProcessBatch::where('status', 'completed')
            ->whereBetween('actual_completion_date', [$startDate, $endDate])
            ->with('batchOutputs')
            ->get();
            
        $stats->biogas_generated_m3 = $completedBatches->flatMap->batchOutputs
            ->where('output_type', 'biogas')
            ->where('is_expected', false)
            ->sum('quantity');
            
        $stats->digestate_produced_kg = $completedBatches->flatMap->batchOutputs
            ->where('output_type', 'digestate')
            ->where('is_expected', false)
            ->sum('quantity');
            
        $stats->larvae_produced_kg = $completedBatches->flatMap->batchOutputs
            ->where('output_type', 'larvae')
            ->where('is_expected', false)
            ->sum('quantity');
            
        $stats->pyrolysis_oil_liters = $completedBatches->flatMap->batchOutputs
            ->where('output_type', 'pyrolysis_oil')
            ->where('is_expected', false)
            ->sum('quantity');
            
        $stats->activated_carbon_kg = $completedBatches->flatMap->batchOutputs
            ->where('output_type', 'activated_carbon')
            ->where('is_expected', false)
            ->sum('quantity');
            
        return $stats;
    }
}
