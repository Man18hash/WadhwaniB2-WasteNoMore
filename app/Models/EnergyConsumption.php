<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnergyConsumption extends Model
{
    use HasFactory;

    protected $table = 'energy_consumption';

    protected $fillable = [
        'consumption_date',
        'energy_source',
        'quantity_consumed',
        'unit',
        'used_for',
        'cost_saved'
    ];

    protected $casts = [
        'consumption_date' => 'date',
        'quantity_consumed' => 'decimal:2',
        'cost_saved' => 'decimal:2'
    ];
}
