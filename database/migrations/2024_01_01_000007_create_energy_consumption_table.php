<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('energy_consumption', function (Blueprint $table) {
            $table->id();
            $table->date('consumption_date');
            $table->enum('energy_source', ['biogas', 'grid_electricity', 'pyrolysis_oil']);
            $table->decimal('quantity_consumed', 10, 2);
            $table->string('unit'); // kwh, m3, liters
            $table->string('used_for'); // cold_storage, lighting, processing, etc.
            $table->decimal('cost_saved', 10, 2)->nullable();
            $table->timestamps();
            
            $table->index('consumption_date');
            $table->index('energy_source');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('energy_consumption');
    }
};
