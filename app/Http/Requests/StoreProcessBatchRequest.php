<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProcessBatchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'batch_number' => 'required|string|max:255|unique:process_batches,batch_number',
            'input_weight_kg' => 'required|numeric|min:0.01|max:50000',
            'input_type' => 'required|string|max:255',
            'start_date' => 'required|date|before_or_equal:today',
            'expected_completion_date' => 'nullable|date|after:start_date',
            'description' => 'nullable|string|max:1000'
        ];
    }

    public function messages()
    {
        return [
            'batch_number.required' => 'Batch number is required.',
            'batch_number.unique' => 'This batch number already exists.',
            'batch_number.max' => 'Batch number cannot exceed 255 characters.',
            'input_weight_kg.required' => 'Input weight is required.',
            'input_weight_kg.numeric' => 'Input weight must be a number.',
            'input_weight_kg.min' => 'Input weight must be at least 0.01 kg.',
            'input_weight_kg.max' => 'Input weight cannot exceed 50,000 kg.',
            'input_type.required' => 'Input type is required.',
            'input_type.max' => 'Input type cannot exceed 255 characters.',
            'start_date.required' => 'Start date is required.',
            'start_date.date' => 'Start date must be a valid date.',
            'start_date.before_or_equal' => 'Start date cannot be in the future.',
            'expected_completion_date.date' => 'Expected completion date must be a valid date.',
            'expected_completion_date.after' => 'Expected completion date must be after start date.',
            'description.max' => 'Description cannot exceed 1000 characters.'
        ];
    }
}
