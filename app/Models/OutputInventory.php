<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutputInventory extends Model
{
    use HasFactory;

    protected $table = 'output_inventory';

    protected $fillable = [
        'product_type',
        'current_stock',
        'unit',
        'total_produced',
        'total_sold',
        'total_used',
        'last_updated_date'
    ];

    protected $casts = [
        'current_stock' => 'decimal:2',
        'total_produced' => 'decimal:2',
        'total_sold' => 'decimal:2',
        'total_used' => 'decimal:2',
        'last_updated_date' => 'date'
    ];

    public function getStockStatusAttribute()
    {
        if ($this->current_stock <= 0) {
            return 'out_of_stock';
        } elseif ($this->current_stock < 100) {
            return 'low_stock';
        }
        return 'in_stock';
    }

    public function getStockBadgeAttribute()
    {
        $badges = [
            'out_of_stock' => 'bg-red-100 text-red-800',
            'low_stock' => 'bg-yellow-100 text-yellow-800',
            'in_stock' => 'bg-green-100 text-green-800'
        ];

        return $badges[$this->stock_status] ?? 'bg-gray-100 text-gray-800';
    }
}
