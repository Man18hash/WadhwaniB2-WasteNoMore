<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesRecord extends Model
{
    use HasFactory;

    protected $table = 'sales_records';

    protected $fillable = [
        'product_type',
        'quantity',
        'unit',
        'price_per_unit',
        'total_amount',
        'sale_date',
        'customer_name',
        'notes'
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'price_per_unit' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'sale_date' => 'date'
    ];
}
