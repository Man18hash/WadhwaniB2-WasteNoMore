<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'entry_date',
        'waste_type',
        'weight_kg',
        'processing_technology',
        'notes'
    ];

    protected $casts = [
        'entry_date' => 'date',
        'weight_kg' => 'decimal:2'
    ];

    public function processBatches()
    {
        return $this->hasMany(ProcessBatch::class, 'input_type', 'waste_type');
    }
}
