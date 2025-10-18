<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales_records', function (Blueprint $table) {
            $table->id();
            $table->string('product_type');
            $table->decimal('quantity', 10, 2);
            $table->string('unit');
            $table->decimal('price_per_unit', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->date('sale_date');
            $table->string('customer_name')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('sale_date');
            $table->index('product_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_records');
    }
};
