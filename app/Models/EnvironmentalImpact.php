<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvironmentalImpact extends Model
{
    use HasFactory;

    protected $table = 'environmental_impact';

    protected $fillable = [
        'report_date',
        'waste_diverted_from_landfill_kg',
        'co2_emissions_reduced_kg',
        'renewable_energy_generated_kwh',
        'chemical_fertilizer_replaced_kg',
        'plastic_diverted_from_ocean_kg',
        'notes'
    ];

    protected $casts = [
        'report_date' => 'date',
        'waste_diverted_from_landfill_kg' => 'decimal:2',
        'co2_emissions_reduced_kg' => 'decimal:2',
        'renewable_energy_generated_kwh' => 'decimal:2',
        'chemical_fertilizer_replaced_kg' => 'decimal:2',
        'plastic_diverted_from_ocean_kg' => 'decimal:2'
    ];
}
