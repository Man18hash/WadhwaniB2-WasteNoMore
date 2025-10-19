<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Reset all tables in correct order (child tables first)
        DB::table('batch_outputs')->truncate();
        DB::table('process_batches')->truncate();
        DB::table('waste_entries')->truncate();
        DB::table('weekly_statistics')->truncate();
        DB::table('output_inventory')->truncate();
        DB::table('sales_records')->truncate();
        DB::table('energy_consumption')->truncate();
        DB::table('environmental_impact')->truncate();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is for presentation setup, no rollback needed
    }
};