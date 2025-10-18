<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnergyConsumption;

class EnergyController extends Controller
{
    public function index(Request $request)
    {
        $query = EnergyConsumption::query();
        
        if ($request->filled('energy_source')) {
            $query->where('energy_source', $request->energy_source);
        }
        
        if ($request->filled('date_from')) {
            $query->where('consumption_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('consumption_date', '<=', $request->date_to);
        }
        
        $energyRecords = $query->orderBy('consumption_date', 'desc')->paginate(15);
        
        // Calculate summary statistics
        $totalEnergyGenerated = EnergyConsumption::whereIn('energy_source', ['biogas', 'solar', 'wind', 'pyrolysis_gas'])
            ->sum('quantity_consumed');
            
        $totalBiogasGenerated = EnergyConsumption::where('energy_source', 'biogas')
            ->sum('quantity_consumed');
            
        $totalCostSaved = EnergyConsumption::sum('cost_saved');
        
        $efficiencyRate = $totalEnergyGenerated > 0 ? 
            (($totalEnergyGenerated / ($totalEnergyGenerated + EnergyConsumption::where('energy_source', 'grid')->sum('quantity_consumed'))) * 100) : 0;
        
        return view('energy.index', compact('energyRecords', 'totalEnergyGenerated', 'totalBiogasGenerated', 'totalCostSaved', 'efficiencyRate'));
    }
    
    public function create()
    {
        return view('energy.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'consumption_date' => 'required|date',
            'energy_source' => 'required|in:biogas,solar,wind,grid,pyrolysis_gas,diesel,wood',
            'quantity_consumed' => 'required|numeric|min:0.01',
            'unit' => 'required|in:kwh,m3,liters,kg,gallons',
            'used_for' => 'required|in:anaerobic_digestion,bsf_larvae,activated_carbon,paper_production,pyrolysis,facility_operations,lighting,heating,cooling,other',
            'cost_saved' => 'nullable|numeric|min:0'
        ]);
        
        EnergyConsumption::create($request->all());
        
        return redirect()->route('energy.index')
            ->with('success', 'Energy consumption record created successfully!');
    }
    
    public function show(EnergyConsumption $energy)
    {
        return view('energy.show', compact('energy'));
    }
    
    public function edit(EnergyConsumption $energy)
    {
        return view('energy.edit', compact('energy'));
    }
    
    public function update(Request $request, EnergyConsumption $energy)
    {
        $request->validate([
            'consumption_date' => 'required|date',
            'energy_source' => 'required|in:biogas,solar,wind,grid,pyrolysis_gas,diesel,wood',
            'quantity_consumed' => 'required|numeric|min:0.01',
            'unit' => 'required|in:kwh,m3,liters,kg,gallons',
            'used_for' => 'required|in:anaerobic_digestion,bsf_larvae,activated_carbon,paper_production,pyrolysis,facility_operations,lighting,heating,cooling,other',
            'cost_saved' => 'nullable|numeric|min:0'
        ]);
        
        $energy->update($request->all());
        
        return redirect()->route('energy.index')
            ->with('success', 'Energy consumption record updated successfully!');
    }
    
    public function destroy(EnergyConsumption $energy)
    {
        $energy->delete();
        
        return redirect()->route('energy.index')
            ->with('success', 'Energy consumption record deleted successfully!');
    }
    
    public function monthlyReport()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        $monthlyData = EnergyConsumption::whereMonth('consumption_date', $currentMonth)
            ->whereYear('consumption_date', $currentYear)
            ->get();
        
        return view('energy.monthly-report', compact('monthlyData'));
    }
}
