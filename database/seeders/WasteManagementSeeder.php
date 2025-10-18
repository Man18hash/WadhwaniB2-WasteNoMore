<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WasteManagementSeeder extends Seeder
{
    public function run(): void
    {
        // Sample waste entries
        DB::table('waste_entries')->insert([
            [
                'entry_date' => Carbon::now()->subDays(5),
                'waste_type' => 'vegetable',
                'weight_kg' => 2500.00,
                'processing_technology' => 'anaerobic',
                'notes' => 'Fresh vegetable waste from market',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'entry_date' => Carbon::now()->subDays(4),
                'waste_type' => 'fruit',
                'weight_kg' => 1800.00,
                'processing_technology' => 'bsf',
                'notes' => 'Mixed fruit waste',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'entry_date' => Carbon::now()->subDays(3),
                'waste_type' => 'plastic',
                'weight_kg' => 500.00,
                'processing_technology' => 'pyrolysis',
                'notes' => 'Single-use plastic packaging',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Sample process batches
        DB::table('process_batches')->insert([
            [
                'batch_number' => 'AD-001',
                'process_type' => 'anaerobic_digestion',
                'input_weight_kg' => 2500.00,
                'input_type' => 'Vegetable waste',
                'start_date' => Carbon::now()->subDays(2),
                'expected_completion_date' => Carbon::now()->addDays(5),
                'actual_completion_date' => null,
                'status' => 'processing',
                'description' => 'Biogas production from vegetable waste',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'batch_number' => 'BSF-012',
                'process_type' => 'bsf_larvae',
                'input_weight_kg' => 1800.00,
                'input_type' => 'Fruit waste',
                'start_date' => Carbon::now()->subDays(3),
                'expected_completion_date' => Carbon::now()->subDays(1),
                'actual_completion_date' => Carbon::now()->subDays(1),
                'status' => 'completed',
                'description' => 'BSF larvae cultivation cycle',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Initialize inventory
        DB::table('output_inventory')->insert([
            ['product_type' => 'biogas', 'current_stock' => 425.00, 'unit' => 'm3', 'total_produced' => 2500.00, 'total_sold' => 0, 'total_used' => 2075.00, 'last_updated_date' => Carbon::now(), 'created_at' => now(), 'updated_at' => now()],
            ['product_type' => 'digestate', 'current_stock' => 6800.00, 'unit' => 'kg', 'total_produced' => 8500.00, 'total_sold' => 1700.00, 'total_used' => 0, 'last_updated_date' => Carbon::now(), 'created_at' => now(), 'updated_at' => now()],
            ['product_type' => 'larvae', 'current_stock' => 1440.00, 'unit' => 'kg', 'total_produced' => 2000.00, 'total_sold' => 560.00, 'total_used' => 0, 'last_updated_date' => Carbon::now(), 'created_at' => now(), 'updated_at' => now()],
            ['product_type' => 'pyrolysis_oil', 'current_stock' => 900.00, 'unit' => 'liters', 'total_produced' => 1200.00, 'total_sold' => 300.00, 'total_used' => 0, 'last_updated_date' => Carbon::now(), 'created_at' => now(), 'updated_at' => now()],
            ['product_type' => 'activated_carbon', 'current_stock' => 720.00, 'unit' => 'kg', 'total_produced' => 1000.00, 'total_sold' => 280.00, 'total_used' => 0, 'last_updated_date' => Carbon::now(), 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
