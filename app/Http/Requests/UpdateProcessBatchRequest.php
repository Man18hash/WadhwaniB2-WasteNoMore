<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProcessBatchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $batchId = $this->route('anaerobicDigestion') ?? 
                   $this->route('bsfLarvae') ?? 
                   $this->route('activatedCarbon') ?? 
                   $this->route('paperPackaging') ?? 
                   $this->route('pyrolysis');

        return [
            'batch_number' => 'required|string|max:255|unique:process_batches,batch_number,' . $batchId,
            'input_weight_kg' => 'required|numeric|min:0.01|max:50000',
            'input_type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'expected_completion_date' => 'nullable|date|after:start_date',
            'actual_completion_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:pending,processing,completed,cancelled',
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
            'expected_completion_date.date' => 'Expected completion date must be a valid date.',
            'expected_completion_date.after' => 'Expected completion date must be after start date.',
            'actual_completion_date.date' => 'Actual completion date must be a valid date.',
            'actual_completion_date.after' => 'Actual completion date must be after start date.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be pending, processing, completed, or cancelled.',
            'description.max' => 'Description cannot exceed 1000 characters.'
        ];
    }
}
