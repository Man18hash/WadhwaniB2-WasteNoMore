<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEnvironmentalImpactRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'report_date' => 'required|date|before_or_equal:today',
            'waste_diverted_from_landfill_kg' => 'nullable|numeric|min:0|max:1000000',
            'co2_emissions_reduced_kg' => 'nullable|numeric|min:0|max:1000000',
            'renewable_energy_generated_kwh' => 'nullable|numeric|min:0|max:1000000',
            'chemical_fertilizer_replaced_kg' => 'nullable|numeric|min:0|max:1000000',
            'plastic_diverted_from_ocean_kg' => 'nullable|numeric|min:0|max:1000000',
            'notes' => 'nullable|string|max:1000'
        ];
    }

    public function messages()
    {
        return [
            'report_date.required' => 'Report date is required.',
            'report_date.date' => 'Report date must be a valid date.',
            'report_date.before_or_equal' => 'Report date cannot be in the future.',
            'waste_diverted_from_landfill_kg.numeric' => 'Waste diverted must be a number.',
            'waste_diverted_from_landfill_kg.min' => 'Waste diverted must be at least 0.',
            'waste_diverted_from_landfill_kg.max' => 'Waste diverted cannot exceed 1,000,000 kg.',
            'co2_emissions_reduced_kg.numeric' => 'CO2 emissions reduced must be a number.',
            'co2_emissions_reduced_kg.min' => 'CO2 emissions reduced must be at least 0.',
            'co2_emissions_reduced_kg.max' => 'CO2 emissions reduced cannot exceed 1,000,000 kg.',
            'renewable_energy_generated_kwh.numeric' => 'Renewable energy generated must be a number.',
            'renewable_energy_generated_kwh.min' => 'Renewable energy generated must be at least 0.',
            'renewable_energy_generated_kwh.max' => 'Renewable energy generated cannot exceed 1,000,000 kWh.',
            'chemical_fertilizer_replaced_kg.numeric' => 'Chemical fertilizer replaced must be a number.',
            'chemical_fertilizer_replaced_kg.min' => 'Chemical fertilizer replaced must be at least 0.',
            'chemical_fertilizer_replaced_kg.max' => 'Chemical fertilizer replaced cannot exceed 1,000,000 kg.',
            'plastic_diverted_from_ocean_kg.numeric' => 'Plastic diverted from ocean must be a number.',
            'plastic_diverted_from_ocean_kg.min' => 'Plastic diverted from ocean must be at least 0.',
            'plastic_diverted_from_ocean_kg.max' => 'Plastic diverted from ocean cannot exceed 1,000,000 kg.',
            'notes.max' => 'Notes cannot exceed 1000 characters.'
        ];
    }
}
