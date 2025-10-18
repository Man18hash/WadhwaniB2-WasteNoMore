<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBatchOutputRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'output_type' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0.01|max:10000',
            'unit' => 'required|string|max:50',
            'is_expected' => 'boolean',
            'output_date' => 'nullable|date|before_or_equal:today',
            'quality_grade' => 'nullable|numeric|min:0|max:100',
            'remarks' => 'nullable|string|max:1000'
        ];
    }

    public function messages()
    {
        return [
            'output_type.required' => 'Output type is required.',
            'output_type.max' => 'Output type cannot exceed 255 characters.',
            'quantity.required' => 'Quantity is required.',
            'quantity.numeric' => 'Quantity must be a number.',
            'quantity.min' => 'Quantity must be at least 0.01.',
            'quantity.max' => 'Quantity cannot exceed 10,000.',
            'unit.required' => 'Unit is required.',
            'unit.max' => 'Unit cannot exceed 50 characters.',
            'is_expected.boolean' => 'Expected flag must be true or false.',
            'output_date.date' => 'Output date must be a valid date.',
            'output_date.before_or_equal' => 'Output date cannot be in the future.',
            'quality_grade.numeric' => 'Quality grade must be a number.',
            'quality_grade.min' => 'Quality grade must be at least 0.',
            'quality_grade.max' => 'Quality grade cannot exceed 100.',
            'remarks.max' => 'Remarks cannot exceed 1000 characters.'
        ];
    }
}
