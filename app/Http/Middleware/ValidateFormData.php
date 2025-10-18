<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateFormData
{
    public function handle(Request $request, Closure $next)
    {
        // Additional validation for specific routes
        if ($request->is('waste-entries*') && $request->isMethod('POST')) {
            $this->validateWasteEntry($request);
        }

        if ($request->is('sales*') && $request->isMethod('POST')) {
            $this->validateSalesRecord($request);
        }

        if ($request->is('inventory/adjust') && $request->isMethod('POST')) {
            $this->validateInventoryAdjustment($request);
        }

        return $next($request);
    }

    private function validateWasteEntry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'entry_date' => 'required|date|before_or_equal:today',
            'waste_type' => 'required|in:vegetable,fruit,plastic',
            'weight_kg' => 'required|numeric|min:0.01|max:10000',
            'processing_technology' => 'required|in:anaerobic,bsf,activated,paper,pyrolysis',
            'notes' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    }

    private function validateSalesRecord(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_type' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0.01|max:10000',
            'unit' => 'required|string|max:50',
            'price_per_unit' => 'required|numeric|min:0.01|max:100000',
            'sale_date' => 'required|date|before_or_equal:today',
            'customer_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    }

    private function validateInventoryAdjustment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_type' => 'required|string|max:255|exists:output_inventory,product_type',
            'adjustment_type' => 'required|in:add,subtract',
            'quantity' => 'required|numeric|min:0.01|max:10000',
            'reason' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    }
}
