<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnvironmentalImpact;

class EnvironmentalImpactController extends Controller
{
    public function index(Request $request)
    {
        $query = EnvironmentalImpact::query();
        
        if ($request->filled('date_from')) {
            $query->where('report_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('report_date', '<=', $request->date_to);
        }
        
        $environmentalRecords = $query->orderBy('report_date', 'desc')->paginate(15);
        
        // Calculate summary statistics
        $totalWasteDiverted = EnvironmentalImpact::sum('waste_diverted_from_landfill_kg');
        $totalCO2Reduced = EnvironmentalImpact::sum('co2_emissions_reduced_kg');
        $totalRenewableEnergy = EnvironmentalImpact::sum('renewable_energy_generated_kwh');
        $totalFertilizerReplaced = EnvironmentalImpact::sum('chemical_fertilizer_replaced_kg');
        
        return view('environmental-impact.index', compact('environmentalRecords', 'totalWasteDiverted', 'totalCO2Reduced', 'totalRenewableEnergy', 'totalFertilizerReplaced'));
    }
    
    public function create()
    {
        return view('environmental-impact.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'report_date' => 'required|date',
            'waste_diverted_from_landfill_kg' => 'required|numeric|min:0',
            'co2_emissions_reduced_kg' => 'required|numeric|min:0',
            'renewable_energy_generated_kwh' => 'required|numeric|min:0',
            'chemical_fertilizer_replaced_kg' => 'required|numeric|min:0',
            'plastic_diverted_from_ocean_kg' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000'
        ]);
        
        EnvironmentalImpact::create($request->all());
        
        return redirect()->route('environmental-impact.index')
            ->with('success', 'Environmental impact record created successfully!');
    }
    
    public function show(EnvironmentalImpact $environmentalImpact)
    {
        return view('environmental-impact.show', compact('environmentalImpact'));
    }
    
    public function edit(EnvironmentalImpact $environmentalImpact)
    {
        return view('environmental-impact.edit', compact('environmentalImpact'));
    }
    
    public function update(Request $request, EnvironmentalImpact $environmentalImpact)
    {
        $request->validate([
            'report_date' => 'required|date',
            'waste_diverted_from_landfill_kg' => 'required|numeric|min:0',
            'co2_emissions_reduced_kg' => 'required|numeric|min:0',
            'renewable_energy_generated_kwh' => 'required|numeric|min:0',
            'chemical_fertilizer_replaced_kg' => 'required|numeric|min:0',
            'plastic_diverted_from_ocean_kg' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000'
        ]);
        
        $environmentalImpact->update($request->all());
        
        return redirect()->route('environmental-impact.index')
            ->with('success', 'Environmental impact record updated successfully!');
    }
    
    public function destroy(EnvironmentalImpact $environmentalImpact)
    {
        $environmentalImpact->delete();
        
        return redirect()->route('environmental-impact.index')
            ->with('success', 'Environmental impact record deleted successfully!');
    }
    
    public function generateReport()
    {
        // Generate comprehensive environmental impact report
        $totalWasteDiverted = EnvironmentalImpact::sum('waste_diverted_from_landfill_kg');
        $totalCO2Reduced = EnvironmentalImpact::sum('co2_emissions_reduced_kg');
        $totalRenewableEnergy = EnvironmentalImpact::sum('renewable_energy_generated_kwh');
        $totalFertilizerReplaced = EnvironmentalImpact::sum('chemical_fertilizer_replaced_kg');
        $totalPlasticDiverted = EnvironmentalImpact::sum('plastic_diverted_from_ocean_kg');
        
        return view('environmental-impact.report', compact(
            'totalWasteDiverted',
            'totalCO2Reduced',
            'totalRenewableEnergy',
            'totalFertilizerReplaced',
            'totalPlasticDiverted'
        ));
    }
}
