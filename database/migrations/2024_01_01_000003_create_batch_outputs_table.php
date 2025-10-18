<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batch_outputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained('process_batches')->onDelete('cascade');
            $table->string('output_type'); // biogas, digestate, larvae, pyrolysis_oil, etc.
            $table->decimal('quantity', 10, 2);
            $table->string('unit'); // m3, kg, liters
            $table->boolean('is_expected')->default(false); // true for expected, false for actual
            $table->date('output_date')->nullable();
            $table->decimal('quality_grade', 5, 2)->nullable(); // 0-100 quality rating
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            $table->index('batch_id');
            $table->index('output_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batch_outputs');
    }
};
