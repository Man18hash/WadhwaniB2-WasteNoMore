<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesRecord;
use App\Http\Requests\StoreSalesRecordRequest;
use App\Http\Requests\UpdateSalesRecordRequest;
use Carbon\Carbon;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $query = SalesRecord::query();
        
        if ($request->filled('product_type')) {
            $query->where('product_type', $request->product_type);
        }
        
        if ($request->filled('date_from')) {
            $query->where('sale_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('sale_date', '<=', $request->date_to);
        }
        
        $sales = $query->orderBy('sale_date', 'desc')->paginate(15);
        
        return view('sales.index', compact('sales'));
    }
    
    public function create()
    {
        return view('sales.create');
    }
    
    public function store(StoreSalesRecordRequest $request)
    {
        $totalAmount = $request->quantity * $request->price_per_unit;
        
        SalesRecord::create([
            ...$request->validated(),
            'total_amount' => $totalAmount
        ]);
        
        // Update inventory
        $inventory = \App\Models\OutputInventory::where('product_type', $request->product_type)->first();
        if ($inventory) {
            $inventory->current_stock -= $request->quantity;
            $inventory->total_sold += $request->quantity;
            $inventory->last_updated_date = now();
            $inventory->save();
        }
        
        return redirect()->route('sales.index')
            ->with('success', 'Sales record created successfully!');
    }
    
    public function show(SalesRecord $sale)
    {
        return view('sales.show', compact('sale'));
    }
    
    public function edit(SalesRecord $sale)
    {
        return view('sales.edit', compact('sale'));
    }
    
    public function update(UpdateSalesRecordRequest $request, SalesRecord $sale)
    {
        $totalAmount = $request->quantity * $request->price_per_unit;
        
        $sale->update([
            ...$request->validated(),
            'total_amount' => $totalAmount
        ]);
        
        return redirect()->route('sales.index')
            ->with('success', 'Sales record updated successfully!');
    }
    
    public function destroy(SalesRecord $sale)
    {
        $sale->delete();
        
        return redirect()->route('sales.index')
            ->with('success', 'Sales record deleted successfully!');
    }
    
    public function exportExcel(Request $request)
    {
        $query = SalesRecord::query();
        
        if ($request->filled('product_type')) {
            $query->where('product_type', $request->product_type);
        }
        
        if ($request->filled('date_from')) {
            $query->where('sale_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('sale_date', '<=', $request->date_to);
        }
        
        $sales = $query->orderBy('sale_date', 'desc')->get();
        
        $filename = 'sales_records_' . Carbon::now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($sales) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['Sale Date', 'Product Type', 'Quantity', 'Unit', 'Price per Unit', 'Total Amount', 'Customer Name', 'Notes']);
            
            foreach ($sales as $sale) {
                fputcsv($file, [
                    $sale->sale_date->format('Y-m-d'),
                    ucfirst(str_replace('_', ' ', $sale->product_type)),
                    $sale->quantity,
                    $sale->unit,
                    $sale->price_per_unit,
                    $sale->total_amount,
                    $sale->customer_name ?? '-',
                    $sale->notes ?? '-'
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
