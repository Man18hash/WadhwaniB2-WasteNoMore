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
        
        // Get the most recent weekly stats (or calculate from data)
        $weeklyStats = WeeklyStatistic::latest('week_number')->first();
        
        // If no weekly stats exist, calculate from raw data
        if (!$weeklyStats) {
            $weeklyStats = $this->calculateWeeklyStats($currentWeek, $currentWeek->copy()->endOfWeek());
        }
        
        // Recent waste entries (last 7 days or most recent if no current week data)
        $recentWasteEntries = WasteEntry::where('entry_date', '>=', $currentWeek)
            ->orderBy('entry_date', 'desc')
            ->limit(5)
            ->get();
            
        // If no current week data, get most recent entries
        if ($recentWasteEntries->isEmpty()) {
            $recentWasteEntries = WasteEntry::orderBy('entry_date', 'desc')
                ->limit(5)
                ->get();
        }
            
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
            
        // Environmental impact this month or most recent
        $monthlyEnvironmentalImpact = EnvironmentalImpact::whereMonth('report_date', Carbon::now()->month)
            ->whereYear('report_date', Carbon::now()->year)
            ->first();
            
        // If no current month data, get most recent
        if (!$monthlyEnvironmentalImpact) {
            $monthlyEnvironmentalImpact = EnvironmentalImpact::latest('report_date')->first();
        }
            
        // Chart data for waste distribution (this week or recent data)
        $wasteDistribution = [
            'vegetable' => WasteEntry::where('waste_type', 'vegetable')
                ->where('entry_date', '>=', $currentWeek)
                ->sum('weight_kg') ?: 0,
            'fruit' => WasteEntry::where('waste_type', 'fruit')
                ->where('entry_date', '>=', $currentWeek)
                ->sum('weight_kg') ?: 0,
            'plastic' => WasteEntry::where('waste_type', 'plastic')
                ->where('entry_date', '>=', $currentWeek)
                ->sum('weight_kg') ?: 0,
            'paper' => WasteEntry::where('waste_type', 'paper')
                ->where('entry_date', '>=', $currentWeek)
                ->sum('weight_kg') ?: 0
        ];
        
        // If no current week data, use recent data
        if (array_sum($wasteDistribution) == 0) {
            $wasteDistribution = [
                'vegetable' => WasteEntry::where('waste_type', 'vegetable')
                    ->where('entry_date', '>=', Carbon::now()->subDays(7))
                    ->sum('weight_kg') ?: 0,
                'fruit' => WasteEntry::where('waste_type', 'fruit')
                    ->where('entry_date', '>=', Carbon::now()->subDays(7))
                    ->sum('weight_kg') ?: 0,
                'plastic' => WasteEntry::where('waste_type', 'plastic')
                    ->where('entry_date', '>=', Carbon::now()->subDays(7))
                    ->sum('weight_kg') ?: 0,
                'paper' => WasteEntry::where('waste_type', 'paper')
                    ->where('entry_date', '>=', Carbon::now()->subDays(7))
                    ->sum('weight_kg') ?: 0
            ];
        }
        
        // Weekly trends data (last 4 weeks)
        $weeklyTrends = WeeklyStatistic::orderBy('week_number', 'desc')
            ->limit(4)
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
            
        // Output production data (this week or recent data)
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
        
        // If no current week data, use recent data
        if (array_sum($outputProduction) == 0) {
            $outputProduction = [
                'biogas' => BatchOutput::where('output_type', 'biogas')
                    ->where('is_expected', false)
                    ->where('output_date', '>=', Carbon::now()->subDays(7))
                    ->sum('quantity') ?: 0,
                'digestate' => BatchOutput::where('output_type', 'digestate')
                    ->where('is_expected', false)
                    ->where('output_date', '>=', Carbon::now()->subDays(7))
                    ->sum('quantity') ?: 0,
                'larvae' => BatchOutput::where('output_type', 'larvae')
                    ->where('is_expected', false)
                    ->where('output_date', '>=', Carbon::now()->subDays(7))
                    ->sum('quantity') ?: 0,
                'pyrolysis_oil' => BatchOutput::where('output_type', 'pyrolysis_oil')
                    ->where('is_expected', false)
                    ->where('output_date', '>=', Carbon::now()->subDays(7))
                    ->sum('quantity') ?: 0,
                'activated_carbon' => BatchOutput::where('output_type', 'activated_carbon')
                    ->where('is_expected', false)
                    ->where('output_date', '>=', Carbon::now()->subDays(7))
                    ->sum('quantity') ?: 0
            ];
        }
        
        // Calculate key metrics for dashboard cards
        $totalWasteThisWeek = array_sum($wasteDistribution);
        $biogasGenerated = $outputProduction['biogas'];
        $revenueThisMonth = $monthlySales->sum('total_amount');
        $co2Reduced = $monthlyEnvironmentalImpact ? $monthlyEnvironmentalImpact->co2_emissions_reduced_kg : 0;
        
        // Active batches count by process type
        $activeBatchesCount = [
            'anaerobic' => ProcessBatch::where('process_type', 'anaerobic_digestion')
                ->whereIn('status', ['pending', 'processing'])->count(),
            'bsf_larvae' => ProcessBatch::where('process_type', 'bsf_larvae')
                ->whereIn('status', ['pending', 'processing'])->count(),
            'activated_carbon' => ProcessBatch::where('process_type', 'activated_carbon')
                ->whereIn('status', ['pending', 'processing'])->count(),
            'paper_packaging' => ProcessBatch::where('process_type', 'paper_packaging')
                ->whereIn('status', ['pending', 'processing'])->count(),
            'pyrolysis' => ProcessBatch::where('process_type', 'pyrolysis')
                ->whereIn('status', ['pending', 'processing'])->count(),
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
            'currentWeekNumber',
            'totalWasteThisWeek',
            'biogasGenerated',
            'revenueThisMonth',
            'co2Reduced',
            'activeBatchesCount'
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
        $stats->paper_waste_kg = $wasteEntries->where('waste_type', 'paper')->sum('weight_kg');
        
        // Calculate outputs from completed batches
        $completedBatches = ProcessBatch::where('status', 'completed')
            ->whereBetween('actual_completion_date', [$startDate, $endDate])
            ->get();
            
        // Get batch IDs for querying outputs
        $batchIds = $completedBatches->pluck('id');
        
        $stats->biogas_generated_m3 = BatchOutput::whereIn('batch_id', $batchIds)
            ->where('output_type', 'biogas')
            ->where('is_expected', false)
            ->sum('quantity') ?: 0;
            
        $stats->digestate_produced_kg = BatchOutput::whereIn('batch_id', $batchIds)
            ->where('output_type', 'digestate')
            ->where('is_expected', false)
            ->sum('quantity') ?: 0;
            
        $stats->larvae_produced_kg = BatchOutput::whereIn('batch_id', $batchIds)
            ->where('output_type', 'larvae')
            ->where('is_expected', false)
            ->sum('quantity') ?: 0;
            
        $stats->pyrolysis_oil_liters = BatchOutput::whereIn('batch_id', $batchIds)
            ->where('output_type', 'pyrolysis_oil')
            ->where('is_expected', false)
            ->sum('quantity') ?: 0;
            
        $stats->activated_carbon_kg = BatchOutput::whereIn('batch_id', $batchIds)
            ->where('output_type', 'activated_carbon')
            ->where('is_expected', false)
            ->sum('quantity') ?: 0;
            
        return $stats;
    }
}
