<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEnergyConsumptionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'consumption_date' => 'required|date|before_or_equal:today',
            'energy_source' => 'required|in:biogas,grid_electricity,pyrolysis_oil',
            'quantity_consumed' => 'required|numeric|min:0.01|max:100000',
            'unit' => 'required|string|max:50',
            'used_for' => 'required|string|max:255',
            'cost_saved' => 'nullable|numeric|min:0|max:1000000'
        ];
    }

    public function messages()
    {
        return [
            'consumption_date.required' => 'Consumption date is required.',
            'consumption_date.date' => 'Consumption date must be a valid date.',
            'consumption_date.before_or_equal' => 'Consumption date cannot be in the future.',
            'energy_source.required' => 'Energy source is required.',
            'energy_source.in' => 'Energy source must be biogas, grid_electricity, or pyrolysis_oil.',
            'quantity_consumed.required' => 'Quantity consumed is required.',
            'quantity_consumed.numeric' => 'Quantity consumed must be a number.',
            'quantity_consumed.min' => 'Quantity consumed must be at least 0.01.',
            'quantity_consumed.max' => 'Quantity consumed cannot exceed 100,000.',
            'unit.required' => 'Unit is required.',
            'unit.max' => 'Unit cannot exceed 50 characters.',
            'used_for.required' => 'Used for field is required.',
            'used_for.max' => 'Used for field cannot exceed 255 characters.',
            'cost_saved.numeric' => 'Cost saved must be a number.',
            'cost_saved.min' => 'Cost saved must be at least 0.',
            'cost_saved.max' => 'Cost saved cannot exceed 1,000,000.'
        ];
    }
}
