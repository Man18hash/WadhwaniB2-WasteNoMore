<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWasteEntryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'entry_date' => 'required|date|before_or_equal:today',
            'waste_type' => 'required|in:vegetable,fruit,plastic,paper',
            'weight_kg' => 'required|numeric|min:0.01|max:10000',
            'processing_technology' => 'required|in:anaerobic,bsf,activated,paper,pyrolysis',
            'notes' => 'nullable|string|max:1000'
        ];
    }

    public function messages()
    {
        return [
            'entry_date.required' => 'Entry date is required.',
            'entry_date.date' => 'Entry date must be a valid date.',
            'entry_date.before_or_equal' => 'Entry date cannot be in the future.',
            'waste_type.required' => 'Waste type is required.',
            'waste_type.in' => 'Waste type must be vegetable, fruit, plastic, or paper.',
            'weight_kg.required' => 'Weight is required.',
            'weight_kg.numeric' => 'Weight must be a number.',
            'weight_kg.min' => 'Weight must be at least 0.01 kg.',
            'weight_kg.max' => 'Weight cannot exceed 10,000 kg.',
            'processing_technology.required' => 'Processing technology is required.',
            'processing_technology.in' => 'Processing technology must be anaerobic, bsf, activated, paper, or pyrolysis.',
            'notes.max' => 'Notes cannot exceed 1000 characters.'
        ];
    }
}
