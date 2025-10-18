<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchOutput extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'output_type',
        'quantity',
        'unit',
        'is_expected',
        'output_date',
        'quality_grade',
        'remarks'
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'quality_grade' => 'decimal:2',
        'is_expected' => 'boolean',
        'output_date' => 'date'
    ];

    public function processBatch()
    {
        return $this->belongsTo(ProcessBatch::class, 'batch_id');
    }
}
