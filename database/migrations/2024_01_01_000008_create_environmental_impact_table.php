<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('environmental_impact', function (Blueprint $table) {
            $table->id();
            $table->date('report_date');
            $table->decimal('waste_diverted_from_landfill_kg', 10, 2)->default(0);
            $table->decimal('co2_emissions_reduced_kg', 10, 2)->default(0);
            $table->decimal('renewable_energy_generated_kwh', 10, 2)->default(0);
            $table->decimal('chemical_fertilizer_replaced_kg', 10, 2)->default(0);
            $table->decimal('plastic_diverted_from_ocean_kg', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('report_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('environmental_impact');
    }
};
