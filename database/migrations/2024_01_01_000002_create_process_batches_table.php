<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('process_batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_number')->unique();
            $table->enum('process_type', [
                'anaerobic_digestion',
                'bsf_larvae',
                'activated_carbon',
                'paper_packaging',
                'pyrolysis'
            ]);
            $table->decimal('input_weight_kg', 10, 2);
            $table->string('input_type');
            $table->date('start_date');
            $table->date('expected_completion_date')->nullable();
            $table->date('actual_completion_date')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->index('batch_number');
            $table->index('status');
            $table->index('start_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('process_batches');
    }
};
