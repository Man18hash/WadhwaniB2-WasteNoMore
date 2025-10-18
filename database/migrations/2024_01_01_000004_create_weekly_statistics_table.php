<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weekly_statistics', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->integer('week_number');
            $table->date('week_start_date');
            $table->date('week_end_date');
            $table->decimal('total_waste_kg', 10, 2)->default(0);
            $table->decimal('vegetable_waste_kg', 10, 2)->default(0);
            $table->decimal('fruit_waste_kg', 10, 2)->default(0);
            $table->decimal('plastic_waste_kg', 10, 2)->default(0);
            $table->decimal('biogas_generated_m3', 10, 2)->default(0);
            $table->decimal('digestate_produced_kg', 10, 2)->default(0);
            $table->decimal('larvae_produced_kg', 10, 2)->default(0);
            $table->decimal('pyrolysis_oil_liters', 10, 2)->default(0);
            $table->decimal('activated_carbon_kg', 10, 2)->default(0);
            $table->timestamps();
            
            $table->unique(['year', 'week_number']);
            $table->index('week_start_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weekly_statistics');
    }
};
