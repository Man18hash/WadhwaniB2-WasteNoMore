<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryAdjustmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_type' => 'required|string|max:255|exists:output_inventory,product_type',
            'adjustment_type' => 'required|in:add,subtract',
            'quantity' => 'required|numeric|min:0.01|max:10000',
            'reason' => 'required|string|max:255'
        ];
    }

    public function messages()
    {
        return [
            'product_type.required' => 'Product type is required.',
            'product_type.exists' => 'Selected product type does not exist in inventory.',
            'adjustment_type.required' => 'Adjustment type is required.',
            'adjustment_type.in' => 'Adjustment type must be add or subtract.',
            'quantity.required' => 'Quantity is required.',
            'quantity.numeric' => 'Quantity must be a number.',
            'quantity.min' => 'Quantity must be at least 0.01.',
            'quantity.max' => 'Quantity cannot exceed 10,000.',
            'reason.required' => 'Reason is required.',
            'reason.max' => 'Reason cannot exceed 255 characters.'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->adjustment_type === 'subtract') {
                $inventory = \App\Models\OutputInventory::where('product_type', $this->product_type)->first();
                if ($inventory && $inventory->current_stock < $this->quantity) {
                    $validator->errors()->add('quantity', 'Insufficient stock. Current stock: ' . $inventory->current_stock);
                }
            }
        });
    }
}
