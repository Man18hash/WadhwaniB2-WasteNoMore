<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OutputInventory;
use App\Models\SalesRecord;
use App\Http\Requests\InventoryAdjustmentRequest;
use Carbon\Carbon;

class InventoryController extends Controller
{
    public function index()
    {
        $inventory = OutputInventory::orderBy('product_type')->get();
        
        // Calculate low stock items
        $lowStockItems = $inventory->where('current_stock', '<', 100);
        
        return view('inventory.index', compact('inventory', 'lowStockItems'));
    }
    
    public function adjust(InventoryAdjustmentRequest $request)
    {
        $inventory = OutputInventory::where('product_type', $request->product_type)->first();
        
        if ($request->adjustment_type === 'add') {
            $inventory->current_stock += $request->quantity;
            $inventory->total_produced += $request->quantity;
        } else {
            $inventory->current_stock -= $request->quantity;
            $inventory->total_used += $request->quantity;
        }
        
        $inventory->last_updated_date = now();
        $inventory->save();
        
        return redirect()->route('inventory.index')
            ->with('success', 'Inventory adjusted successfully!');
    }
    
    public function history()
    {
        // This would typically show inventory movement history
        // For now, we'll show recent sales and production data
        $recentSales = SalesRecord::orderBy('sale_date', 'desc')->limit(20)->get();
        
        return view('inventory.history', compact('recentSales'));
    }
}
