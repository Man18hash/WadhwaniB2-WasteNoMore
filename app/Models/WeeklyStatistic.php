<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyStatistic extends Model
{
    use HasFactory;

    protected $table = 'weekly_statistics';

    protected $fillable = [
        'year',
        'week_number',
        'week_start_date',
        'week_end_date',
        'total_waste_kg',
        'vegetable_waste_kg',
        'fruit_waste_kg',
        'plastic_waste_kg',
        'biogas_generated_m3',
        'digestate_produced_kg',
        'larvae_produced_kg',
        'pyrolysis_oil_liters',
        'activated_carbon_kg'
    ];

    protected $casts = [
        'week_start_date' => 'date',
        'week_end_date' => 'date',
        'total_waste_kg' => 'decimal:2',
        'vegetable_waste_kg' => 'decimal:2',
        'fruit_waste_kg' => 'decimal:2',
        'plastic_waste_kg' => 'decimal:2',
        'biogas_generated_m3' => 'decimal:2',
        'digestate_produced_kg' => 'decimal:2',
        'larvae_produced_kg' => 'decimal:2',
        'pyrolysis_oil_liters' => 'decimal:2',
        'activated_carbon_kg' => 'decimal:2'
    ];
}
