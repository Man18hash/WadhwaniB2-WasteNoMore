<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_number',
        'process_type',
        'input_weight_kg',
        'input_type',
        'start_date',
        'expected_completion_date',
        'actual_completion_date',
        'status',
        'description'
    ];

    protected $casts = [
        'start_date' => 'date',
        'expected_completion_date' => 'date',
        'actual_completion_date' => 'date',
        'input_weight_kg' => 'decimal:2'
    ];

    public function batchOutputs()
    {
        return $this->hasMany(BatchOutput::class, 'batch_id');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800'
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }
}
