<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BatchOutput;
use App\Models\ProcessBatch;
use Carbon\Carbon;

class BatchOutputSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing process batches
        $batches = ProcessBatch::all();
        
        if ($batches->isEmpty()) {
            return;
        }
        
        $currentWeek = Carbon::now()->startOfWeek();
        
        // Create sample batch outputs for this week
        foreach ($batches as $batch) {
            // Create actual outputs (not expected)
            BatchOutput::create([
                'batch_id' => $batch->id,
                'output_type' => 'biogas',
                'quantity' => rand(50, 200),
                'unit' => 'm3',
                'is_expected' => false,
                'output_date' => $currentWeek->copy()->addDays(rand(1, 6)),
                'quality_grade' => rand(80, 100),
                'remarks' => 'High quality biogas production',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            
            if ($batch->process_type === 'anaerobic_digestion') {
                BatchOutput::create([
                    'batch_id' => $batch->id,
                    'output_type' => 'digestate',
                    'quantity' => rand(200, 500),
                    'unit' => 'kg',
                    'is_expected' => false,
                    'output_date' => $currentWeek->copy()->addDays(rand(1, 6)),
                    'quality_grade' => rand(70, 90),
                    'remarks' => 'Rich digestate for fertilizer',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
            
            if ($batch->process_type === 'bsf_larvae') {
                BatchOutput::create([
                    'batch_id' => $batch->id,
                    'output_type' => 'larvae',
                    'quantity' => rand(30, 100),
                    'unit' => 'kg',
                    'is_expected' => false,
                    'output_date' => $currentWeek->copy()->addDays(rand(1, 6)),
                    'quality_grade' => rand(80, 100),
                    'remarks' => 'High protein larvae',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
            
            if ($batch->process_type === 'pyrolysis') {
                BatchOutput::create([
                    'batch_id' => $batch->id,
                    'output_type' => 'pyrolysis_oil',
                    'quantity' => rand(20, 80),
                    'unit' => 'liters',
                    'is_expected' => false,
                    'output_date' => $currentWeek->copy()->addDays(rand(1, 6)),
                    'quality_grade' => rand(70, 90),
                    'remarks' => 'Pyrolysis oil for fuel',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
            
            if ($batch->process_type === 'activated_carbon') {
                BatchOutput::create([
                    'batch_id' => $batch->id,
                    'output_type' => 'activated_carbon',
                    'quantity' => rand(10, 50),
                    'unit' => 'kg',
                    'is_expected' => false,
                    'output_date' => $currentWeek->copy()->addDays(rand(1, 6)),
                    'quality_grade' => rand(80, 100),
                    'remarks' => 'High quality activated carbon',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}