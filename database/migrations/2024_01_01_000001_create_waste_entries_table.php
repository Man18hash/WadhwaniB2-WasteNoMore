<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waste_entries', function (Blueprint $table) {
            $table->id();
            $table->date('entry_date');
            $table->enum('waste_type', ['vegetable', 'fruit', 'plastic']);
            $table->decimal('weight_kg', 10, 2);
            $table->enum('processing_technology', [
                'anaerobic',
                'bsf',
                'activated',
                'paper',
                'pyrolysis'
            ]);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('entry_date');
            $table->index('waste_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waste_entries');
    }
};
