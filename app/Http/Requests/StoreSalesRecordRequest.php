<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalesRecordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_type' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0.01|max:10000',
            'unit' => 'required|string|max:50',
            'price_per_unit' => 'required|numeric|min:0.01|max:100000',
            'sale_date' => 'required|date|before_or_equal:today',
            'customer_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000'
        ];
    }

    public function messages()
    {
        return [
            'product_type.required' => 'Product type is required.',
            'product_type.max' => 'Product type cannot exceed 255 characters.',
            'quantity.required' => 'Quantity is required.',
            'quantity.numeric' => 'Quantity must be a number.',
            'quantity.min' => 'Quantity must be at least 0.01.',
            'quantity.max' => 'Quantity cannot exceed 10,000.',
            'unit.required' => 'Unit is required.',
            'unit.max' => 'Unit cannot exceed 50 characters.',
            'price_per_unit.required' => 'Price per unit is required.',
            'price_per_unit.numeric' => 'Price per unit must be a number.',
            'price_per_unit.min' => 'Price per unit must be at least 0.01.',
            'price_per_unit.max' => 'Price per unit cannot exceed 100,000.',
            'sale_date.required' => 'Sale date is required.',
            'sale_date.date' => 'Sale date must be a valid date.',
            'sale_date.before_or_equal' => 'Sale date cannot be in the future.',
            'customer_name.max' => 'Customer name cannot exceed 255 characters.',
            'notes.max' => 'Notes cannot exceed 1000 characters.'
        ];
    }
}
