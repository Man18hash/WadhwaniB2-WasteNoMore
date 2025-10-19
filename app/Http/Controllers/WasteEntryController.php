<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WasteEntry;
use App\Http\Requests\StoreWasteEntryRequest;
use App\Http\Requests\UpdateWasteEntryRequest;
use Carbon\Carbon;

class WasteEntryController extends Controller
{
    public function index(Request $request)
    {
        $query = WasteEntry::query();
        
        // Apply filters
        if ($request->filled('waste_type')) {
            $query->where('waste_type', $request->waste_type);
        }
        
        if ($request->filled('processing_technology')) {
            $query->where('processing_technology', $request->processing_technology);
        }
        
        if ($request->filled('date_from')) {
            $query->where('entry_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('entry_date', '<=', $request->date_to);
        }
        
        $wasteEntries = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('waste-entries.index', compact('wasteEntries'));
    }
    
    public function create()
    {
        return view('waste-entries.create');
    }
    
    public function store(StoreWasteEntryRequest $request)
    {
        $validatedData = $request->validated();
        
        // Clean up notes field - remove empty strings and set to null
        if (isset($validatedData['notes']) && trim($validatedData['notes']) === '') {
            $validatedData['notes'] = null;
        }
        
        $wasteEntry = WasteEntry::create($validatedData);
        
        return redirect()->route('waste-entries.index')
            ->with('success', 'Waste entry created successfully!');
    }
    
    public function show(WasteEntry $wasteEntry)
    {
        return view('waste-entries.show', compact('wasteEntry'));
    }
    
    public function edit(WasteEntry $wasteEntry)
    {
        return view('waste-entries.edit', compact('wasteEntry'));
    }
    
    public function update(UpdateWasteEntryRequest $request, WasteEntry $wasteEntry)
    {
        $validatedData = $request->validated();
        
        // Clean up notes field - remove empty strings and set to null
        if (isset($validatedData['notes']) && trim($validatedData['notes']) === '') {
            $validatedData['notes'] = null;
        }
        
        $wasteEntry->update($validatedData);
        
        return redirect()->route('waste-entries.index')
            ->with('success', 'Waste entry updated successfully!');
    }
    
    public function destroy(WasteEntry $wasteEntry)
    {
        $wasteEntry->delete();
        
        return redirect()->route('waste-entries.index')
            ->with('success', 'Waste entry deleted successfully!');
    }
    
    public function exportExcel(Request $request)
    {
        $query = WasteEntry::query();
        
        // Apply same filters as index
        if ($request->filled('waste_type')) {
            $query->where('waste_type', $request->waste_type);
        }
        
        if ($request->filled('processing_technology')) {
            $query->where('processing_technology', $request->processing_technology);
        }
        
        if ($request->filled('date_from')) {
            $query->where('entry_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('entry_date', '<=', $request->date_to);
        }
        
        $wasteEntries = $query->orderBy('entry_date', 'desc')->get();
        
        // Simple CSV export (you can enhance this with a proper Excel library)
        $filename = 'waste_entries_' . Carbon::now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($wasteEntries) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, ['Entry Date', 'Waste Type', 'Weight (kg)', 'Processing Technology', 'Notes', 'Created At']);
            
            // CSV data
            foreach ($wasteEntries as $entry) {
                fputcsv($file, [
                    $entry->entry_date->format('Y-m-d'),
                    ucfirst($entry->waste_type),
                    $entry->weight_kg,
                    ucfirst($entry->processing_technology),
                    $entry->notes,
                    $entry->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
