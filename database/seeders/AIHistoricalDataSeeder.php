<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProcessBatch;
use App\Models\BatchOutput;
use Carbon\Carbon;

class AIHistoricalDataSeeder extends Seeder
{
    public function run()
    {
        // Create historical anaerobic digestion batches for fruit/vegetable waste
        $adBatches = [
            [
                'batch_number' => 'AD-HIST-001',
                'process_type' => 'anaerobic_digestion',
                'input_type' => 'fruit',
                'input_weight_kg' => 1200,
                'start_date' => Carbon::now()->subDays(25),
                'expected_completion_date' => Carbon::now()->subDays(7),
                'actual_completion_date' => Carbon::now()->subDays(6),
                'status' => 'completed',
                'description' => 'High-quality fruit waste processing'
            ],
            [
                'batch_number' => 'AD-HIST-002',
                'process_type' => 'anaerobic_digestion',
                'input_type' => 'vegetable',
                'input_weight_kg' => 1500,
                'start_date' => Carbon::now()->subDays(30),
                'expected_completion_date' => Carbon::now()->subDays(12),
                'actual_completion_date' => Carbon::now()->subDays(11),
                'status' => 'completed',
                'description' => 'Excellent vegetable waste conversion'
            ],
            [
                'batch_number' => 'AD-HIST-003',
                'process_type' => 'anaerobic_digestion',
                'input_type' => 'fruit',
                'input_weight_kg' => 800,
                'start_date' => Carbon::now()->subDays(20),
                'expected_completion_date' => Carbon::now()->subDays(2),
                'actual_completion_date' => Carbon::now()->subDays(1),
                'status' => 'completed',
                'description' => 'Standard fruit processing batch'
            ],
            [
                'batch_number' => 'AD-HIST-004',
                'process_type' => 'anaerobic_digestion',
                'input_type' => 'vegetable',
                'input_weight_kg' => 2000,
                'start_date' => Carbon::now()->subDays(35),
                'expected_completion_date' => Carbon::now()->subDays(17),
                'actual_completion_date' => Carbon::now()->subDays(16),
                'status' => 'completed',
                'description' => 'Large batch vegetable processing'
            ],
            [
                'batch_number' => 'AD-HIST-005',
                'process_type' => 'anaerobic_digestion',
                'input_type' => 'fruit',
                'input_weight_kg' => 1000,
                'start_date' => Carbon::now()->subDays(22),
                'expected_completion_date' => Carbon::now()->subDays(4),
                'actual_completion_date' => Carbon::now()->subDays(3),
                'status' => 'completed',
                'description' => 'Consistent fruit waste processing'
            ]
        ];

        foreach ($adBatches as $batchData) {
            $batch = ProcessBatch::create($batchData);
            
            // Create batch outputs for each batch
            $outputs = $this->generateBatchOutputs($batch->process_type, $batch->input_type, $batch->input_weight_kg);
            
            foreach ($outputs as $outputData) {
                BatchOutput::create(array_merge($outputData, ['batch_id' => $batch->id]));
            }
        }

        // Create historical pyrolysis batches for plastic waste
        $pyrolysisBatches = [
            [
                'batch_number' => 'PYR-HIST-001',
                'process_type' => 'pyrolysis',
                'input_type' => 'plastic',
                'input_weight_kg' => 500,
                'start_date' => Carbon::now()->subDays(5),
                'expected_completion_date' => Carbon::now()->subDays(2),
                'actual_completion_date' => Carbon::now()->subDays(2),
                'status' => 'completed',
                'description' => 'Plastic pyrolysis batch'
            ],
            [
                'batch_number' => 'PYR-HIST-002',
                'process_type' => 'pyrolysis',
                'input_type' => 'plastic',
                'input_weight_kg' => 800,
                'start_date' => Carbon::now()->subDays(8),
                'expected_completion_date' => Carbon::now()->subDays(5),
                'actual_completion_date' => Carbon::now()->subDays(5),
                'status' => 'completed',
                'description' => 'High-efficiency plastic processing'
            ],
            [
                'batch_number' => 'PYR-HIST-003',
                'process_type' => 'pyrolysis',
                'input_type' => 'plastic',
                'input_weight_kg' => 600,
                'start_date' => Carbon::now()->subDays(6),
                'expected_completion_date' => Carbon::now()->subDays(3),
                'actual_completion_date' => Carbon::now()->subDays(3),
                'status' => 'completed',
                'description' => 'Standard plastic pyrolysis'
            ]
        ];

        foreach ($pyrolysisBatches as $batchData) {
            $batch = ProcessBatch::create($batchData);
            
            // Create batch outputs for each batch
            $outputs = $this->generateBatchOutputs($batch->process_type, $batch->input_type, $batch->input_weight_kg);
            
            foreach ($outputs as $outputData) {
                BatchOutput::create(array_merge($outputData, ['batch_id' => $batch->id]));
            }
        }

        // Create historical BSF larvae batches for agricultural waste
        $bsfBatches = [
            [
                'batch_number' => 'BSF-HIST-001',
                'process_type' => 'bsf_larvae',
                'input_type' => 'agricultural',
                'input_weight_kg' => 1000,
                'start_date' => Carbon::now()->subDays(15),
                'expected_completion_date' => Carbon::now()->subDays(3),
                'actual_completion_date' => Carbon::now()->subDays(3),
                'status' => 'completed',
                'description' => 'Agricultural waste BSF processing'
            ],
            [
                'batch_number' => 'BSF-HIST-002',
                'process_type' => 'bsf_larvae',
                'input_type' => 'agricultural',
                'input_weight_kg' => 1200,
                'start_date' => Carbon::now()->subDays(18),
                'expected_completion_date' => Carbon::now()->subDays(6),
                'actual_completion_date' => Carbon::now()->subDays(6),
                'status' => 'completed',
                'description' => 'High-yield BSF larvae production'
            ],
            [
                'batch_number' => 'BSF-HIST-003',
                'process_type' => 'bsf_larvae',
                'input_type' => 'agricultural',
                'input_weight_kg' => 800,
                'start_date' => Carbon::now()->subDays(12),
                'expected_completion_date' => Carbon::now()->subDays(0),
                'actual_completion_date' => Carbon::now()->subDays(0),
                'status' => 'completed',
                'description' => 'Standard agricultural processing'
            ]
        ];

        foreach ($bsfBatches as $batchData) {
            $batch = ProcessBatch::create($batchData);
            
            // Create batch outputs for each batch
            $outputs = $this->generateBatchOutputs($batch->process_type, $batch->input_type, $batch->input_weight_kg);
            
            foreach ($outputs as $outputData) {
                BatchOutput::create(array_merge($outputData, ['batch_id' => $batch->id]));
            }
        }
    }

    private function generateBatchOutputs($processType, $wasteType, $inputWeight)
    {
        switch ($processType) {
            case 'anaerobic_digestion':
                return [
                    [
                        'output_type' => 'biogas',
                        'quantity' => round($inputWeight * 0.12, 2), // 12% conversion
                        'unit' => 'm³',
                        'quality_grade' => 8.5,
                        'is_expected' => false,
                        'remarks' => 'High-quality biogas production'
                    ],
                    [
                        'output_type' => 'digestate',
                        'quantity' => round($inputWeight * 0.70, 2), // 70% conversion
                        'unit' => 'kg',
                        'quality_grade' => 7.8,
                        'is_expected' => false,
                        'remarks' => 'Nutrient-rich digestate'
                    ]
                ];
                
            case 'pyrolysis':
                return [
                    [
                        'output_type' => 'pyrolysis_oil',
                        'quantity' => round($inputWeight * 0.30, 2), // 30% conversion
                        'unit' => 'L',
                        'quality_grade' => 8.0,
                        'is_expected' => false,
                        'remarks' => 'High-grade pyrolysis oil'
                    ],
                    [
                        'output_type' => 'syngas',
                        'quantity' => round($inputWeight * 0.40, 2), // 40% conversion
                        'unit' => 'm³',
                        'quality_grade' => 7.5,
                        'is_expected' => false,
                        'remarks' => 'Clean syngas production'
                    ]
                ];
                
            case 'bsf_larvae':
                return [
                    [
                        'output_type' => 'larvae',
                        'quantity' => round($inputWeight * 0.15, 2), // 15% conversion
                        'unit' => 'kg',
                        'quality_grade' => 9.0,
                        'is_expected' => false,
                        'remarks' => 'Premium BSF larvae'
                    ],
                    [
                        'output_type' => 'frass',
                        'quantity' => round($inputWeight * 0.30, 2), // 30% conversion
                        'unit' => 'kg',
                        'quality_grade' => 8.2,
                        'is_expected' => false,
                        'remarks' => 'High-quality frass fertilizer'
                    ]
                ];
                
            default:
                return [];
        }
    }
}
