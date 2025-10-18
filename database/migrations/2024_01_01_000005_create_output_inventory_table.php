<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('output_inventory', function (Blueprint $table) {
            $table->id();
            $table->string('product_type'); // biogas, digestate, larvae, etc.
            $table->decimal('current_stock', 10, 2)->default(0);
            $table->string('unit'); // m3, kg, liters
            $table->decimal('total_produced', 10, 2)->default(0);
            $table->decimal('total_sold', 10, 2)->default(0);
            $table->decimal('total_used', 10, 2)->default(0);
            $table->date('last_updated_date');
            $table->timestamps();
            
            $table->unique('product_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('output_inventory');
    }
};
