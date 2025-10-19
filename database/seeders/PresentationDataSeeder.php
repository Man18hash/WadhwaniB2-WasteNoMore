<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WasteEntry;
use App\Models\ProcessBatch;
use App\Models\BatchOutput;
use App\Models\WeeklyStatistic;
use App\Models\OutputInventory;
use App\Models\SalesRecord;
use App\Models\EnergyConsumption;
use App\Models\EnvironmentalImpact;
use Carbon\Carbon;

class PresentationDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Set presentation date to Wednesday, October 22, 2025
        $presentationDate = Carbon::create(2025, 10, 22, 9, 0, 0);
        
        $this->createWasteEntries($presentationDate);
        $this->createProcessBatches($presentationDate);
        $this->createBatchOutputs();
        $this->createWeeklyStatistics($presentationDate);
        $this->createOutputInventory();
        $this->createSalesRecords($presentationDate);
        $this->createEnergyConsumption($presentationDate);
        $this->createEnvironmentalImpact($presentationDate);
    }

    private function createWasteEntries($presentationDate): void
    {
        // Realistic waste composition: 10 tons per week
        // 70% vegetable/fruit (7 tons), 15% paper (1.5 tons), 15% plastic (1.5 tons)
        
        $wasteTypes = [
            'vegetable' => ['weight' => 7000, 'count' => 35], // 7 tons = 7000 kg, 35 entries
            'fruit' => ['weight' => 7000, 'count' => 35],     // 7 tons = 7000 kg, 35 entries  
            'paper' => ['weight' => 1500, 'count' => 15],     // 1.5 tons = 1500 kg, 15 entries
            'plastic' => ['weight' => 1500, 'count' => 15]    // 1.5 tons = 1500 kg, 15 entries
        ];

        $processingMap = [
            'vegetable' => ['anaerobic', 'bsf'],
            'fruit' => ['anaerobic', 'bsf'],
            'paper' => ['paper'],
            'plastic' => ['pyrolysis']
        ];

        $notesMap = [
            'vegetable' => [
                'Fresh vegetable scraps from kitchen prep',
                'Organic vegetable waste from market',
                'Vegetable peels and trimmings',
                'Expired vegetable produce',
                'Mixed vegetable waste from processing'
            ],
            'fruit' => [
                'Mixed fruit peels and cores',
                'Overripe fruit from market',
                'Fruit processing waste',
                'Expired fruit items',
                'Fruit scraps from juice production'
            ],
            'paper' => [
                'Paper and cardboard packaging',
                'Office paper waste',
                'Cardboard boxes and packaging',
                'Mixed paper materials',
                'Paper waste from processing'
            ],
            'plastic' => [
                'Plastic packaging materials',
                'Plastic containers and bags',
                'Plastic waste from packaging',
                'Mixed plastic materials',
                'Plastic waste from processing'
            ]
        ];

        // Generate entries for the past 4 weeks leading to presentation
        for ($week = 4; $week >= 1; $week--) {
            $weekStart = $presentationDate->copy()->subWeeks($week)->startOfWeek();
            
            foreach ($wasteTypes as $type => $data) {
                $entriesPerWeek = $data['count'];
                $weightPerEntry = $data['weight'] / $entriesPerWeek;
                
                for ($i = 0; $i < $entriesPerWeek; $i++) {
                    $entryDate = $weekStart->copy()->addDays(rand(0, 6))->addHours(rand(8, 18));
                    $processingTech = $processingMap[$type][array_rand($processingMap[$type])];
                    $notes = $notesMap[$type][array_rand($notesMap[$type])];
                    
                    WasteEntry::create([
                        'waste_type' => $type,
                        'weight_kg' => round($weightPerEntry + rand(-50, 50), 2),
                        'processing_technology' => $processingTech,
                        'entry_date' => $entryDate,
                        'notes' => $notes,
                    ]);
                }
            }
        }
    }

    private function createProcessBatches($presentationDate): void
    {
        // Create batches showing different states for presentation
        
        // OVERDUE BATCHES (should have started but didn't)
        ProcessBatch::create([
            'batch_number' => 'AD-OVERDUE-001',
            'process_type' => 'anaerobic_digestion',
            'input_type' => 'Vegetable waste',
            'input_weight_kg' => 500,
            'start_date' => $presentationDate->copy()->subDays(2), // Should have started 2 days ago
            'expected_completion_date' => $presentationDate->copy()->addDays(5),
            'status' => 'pending',
            'description' => 'Overdue anaerobic digestion batch - needs immediate attention'
        ]);

        ProcessBatch::create([
            'batch_number' => 'BSF-OVERDUE-002',
            'process_type' => 'bsf_larvae',
            'input_type' => 'Fruit waste',
            'input_weight_kg' => 300,
            'start_date' => $presentationDate->copy()->subDays(1), // Should have started yesterday
            'expected_completion_date' => $presentationDate->copy()->addDays(13),
            'status' => 'pending',
            'description' => 'Overdue BSF larvae batch - critical for production'
        ]);

        // SCHEDULED FOR TODAY (presentation day)
        ProcessBatch::create([
            'batch_number' => 'AC-SCHED-003',
            'process_type' => 'activated_carbon',
            'input_type' => 'Fruit seeds',
            'input_weight_kg' => 200,
            'start_date' => $presentationDate->copy()->addHours(2), // Starting in 2 hours
            'expected_completion_date' => $presentationDate->copy()->addDays(3),
            'status' => 'pending',
            'description' => 'Scheduled activated carbon production - optimal conditions'
        ]);

        ProcessBatch::create([
            'batch_number' => 'PP-SCHED-004',
            'process_type' => 'paper_packaging',
            'input_type' => 'Paper waste',
            'input_weight_kg' => 400,
            'start_date' => $presentationDate->copy()->addHours(4), // Starting in 4 hours
            'expected_completion_date' => $presentationDate->copy()->addDays(2),
            'status' => 'pending',
            'description' => 'Scheduled paper packaging production'
        ]);

        // ONGOING PROCESSES (currently running)
        ProcessBatch::create([
            'batch_number' => 'AD-ONGOING-005',
            'process_type' => 'anaerobic_digestion',
            'input_type' => 'Mixed organic waste',
            'input_weight_kg' => 800,
            'start_date' => $presentationDate->copy()->subDays(3),
            'expected_completion_date' => $presentationDate->copy()->addDays(4),
            'status' => 'processing',
            'description' => 'Ongoing anaerobic digestion - day 3 of 7'
        ]);

        ProcessBatch::create([
            'batch_number' => 'BSF-ONGOING-006',
            'process_type' => 'bsf_larvae',
            'input_type' => 'Vegetable waste',
            'input_weight_kg' => 600,
            'start_date' => $presentationDate->copy()->subDays(7),
            'expected_completion_date' => $presentationDate->copy()->addDays(7),
            'status' => 'processing',
            'description' => 'Ongoing BSF larvae cultivation - day 7 of 14'
        ]);

        ProcessBatch::create([
            'batch_number' => 'PY-ONGOING-007',
            'process_type' => 'pyrolysis',
            'input_type' => 'Plastic waste',
            'input_weight_kg' => 300,
            'start_date' => $presentationDate->copy()->subHours(12),
            'expected_completion_date' => $presentationDate->copy()->addHours(12),
            'status' => 'processing',
            'description' => 'Ongoing pyrolysis process - 12 hours remaining'
        ]);

        // RECENTLY COMPLETED (for output tracking)
        ProcessBatch::create([
            'batch_number' => 'AD-COMPLETE-008',
            'process_type' => 'anaerobic_digestion',
            'input_type' => 'Vegetable waste',
            'input_weight_kg' => 500,
            'start_date' => $presentationDate->copy()->subDays(8),
            'expected_completion_date' => $presentationDate->copy()->subDays(1),
            'actual_completion_date' => $presentationDate->copy()->subDays(1),
            'status' => 'completed',
            'description' => 'Recently completed anaerobic digestion batch'
        ]);

        ProcessBatch::create([
            'batch_number' => 'AC-COMPLETE-009',
            'process_type' => 'activated_carbon',
            'input_type' => 'Fruit seeds',
            'input_weight_kg' => 150,
            'start_date' => $presentationDate->copy()->subDays(4),
            'expected_completion_date' => $presentationDate->copy()->subDays(1),
            'actual_completion_date' => $presentationDate->copy()->subDays(1),
            'status' => 'completed',
            'description' => 'Recently completed activated carbon production'
        ]);
    }

    private function createBatchOutputs(): void
    {
        $batches = ProcessBatch::all();
        
        foreach ($batches as $batch) {
            switch ($batch->process_type) {
                case 'anaerobic_digestion':
                    // Expected outputs
                    BatchOutput::create([
                        'batch_id' => $batch->id,
                        'output_type' => 'biogas',
                        'quantity' => $batch->input_weight_kg * 0.3, // 30% conversion
                        'unit' => 'm³',
                        'is_expected' => true,
                        'output_date' => $batch->expected_completion_date,
                        'quality_grade' => 95,
                        'remarks' => 'Expected high-quality biogas production'
                    ]);
                    
                    BatchOutput::create([
                        'batch_id' => $batch->id,
                        'output_type' => 'digestate',
                        'quantity' => $batch->input_weight_kg * 0.4, // 40% conversion
                        'unit' => 'kg',
                        'is_expected' => true,
                        'output_date' => $batch->expected_completion_date,
                        'quality_grade' => 90,
                        'remarks' => 'Expected nutrient-rich digestate for agriculture'
                    ]);
                    
                    // Actual outputs for completed batches
                    if ($batch->status === 'completed') {
                        BatchOutput::create([
                            'batch_id' => $batch->id,
                            'output_type' => 'biogas',
                            'quantity' => $batch->input_weight_kg * 0.28, // Actual 28% conversion
                            'unit' => 'm³',
                            'is_expected' => false,
                            'output_date' => $batch->actual_completion_date,
                            'quality_grade' => 92,
                            'remarks' => 'Actual biogas production - slightly below target'
                        ]);
                        
                        BatchOutput::create([
                            'batch_id' => $batch->id,
                            'output_type' => 'digestate',
                            'quantity' => $batch->input_weight_kg * 0.38, // Actual 38% conversion
                            'unit' => 'kg',
                            'is_expected' => false,
                            'output_date' => $batch->actual_completion_date,
                            'quality_grade' => 88,
                            'remarks' => 'Actual digestate production - good quality'
                        ]);
                    }
                    break;
                    
                case 'bsf_larvae':
                    // Expected output
                    BatchOutput::create([
                        'batch_id' => $batch->id,
                        'output_type' => 'larvae',
                        'quantity' => $batch->input_weight_kg * 0.2, // 20% conversion
                        'unit' => 'kg',
                        'is_expected' => true,
                        'output_date' => $batch->expected_completion_date,
                        'quality_grade' => 95,
                        'remarks' => 'Expected high-protein larvae for animal feed'
                    ]);
                    
                    // Actual output for completed batches
                    if ($batch->status === 'completed') {
                        BatchOutput::create([
                            'batch_id' => $batch->id,
                            'output_type' => 'larvae',
                            'quantity' => $batch->input_weight_kg * 0.18, // Actual 18% conversion
                            'unit' => 'kg',
                            'is_expected' => false,
                            'output_date' => $batch->actual_completion_date,
                            'quality_grade' => 93,
                            'remarks' => 'Actual larvae production - high quality'
                        ]);
                    }
                    break;
                    
                case 'activated_carbon':
                    // Expected output
                    BatchOutput::create([
                        'batch_id' => $batch->id,
                        'output_type' => 'activated_carbon',
                        'quantity' => $batch->input_weight_kg * 0.3, // 30% conversion
                        'unit' => 'kg',
                        'is_expected' => true,
                        'output_date' => $batch->expected_completion_date,
                        'quality_grade' => 98,
                        'remarks' => 'Expected high-quality activated carbon'
                    ]);
                    
                    // Actual output for completed batches
                    if ($batch->status === 'completed') {
                        BatchOutput::create([
                            'batch_id' => $batch->id,
                            'output_type' => 'activated_carbon',
                            'quantity' => $batch->input_weight_kg * 0.28, // Actual 28% conversion
                            'unit' => 'kg',
                            'is_expected' => false,
                            'output_date' => $batch->actual_completion_date,
                            'quality_grade' => 96,
                            'remarks' => 'Actual activated carbon production - excellent quality'
                        ]);
                    }
                    break;
                    
                case 'paper_packaging':
                    // Expected output
                    BatchOutput::create([
                        'batch_id' => $batch->id,
                        'output_type' => 'paper_products',
                        'quantity' => $batch->input_weight_kg * 0.8, // 80% conversion
                        'unit' => 'kg',
                        'is_expected' => true,
                        'output_date' => $batch->expected_completion_date,
                        'quality_grade' => 90,
                        'remarks' => 'Expected eco-friendly packaging materials'
                    ]);
                    
                    // Actual output for completed batches
                    if ($batch->status === 'completed') {
                        BatchOutput::create([
                            'batch_id' => $batch->id,
                            'output_type' => 'paper_products',
                            'quantity' => $batch->input_weight_kg * 0.75, // Actual 75% conversion
                            'unit' => 'kg',
                            'is_expected' => false,
                            'output_date' => $batch->actual_completion_date,
                            'quality_grade' => 87,
                            'remarks' => 'Actual paper products production - good quality'
                        ]);
                    }
                    break;
                    
                case 'pyrolysis':
                    // Expected outputs
                    BatchOutput::create([
                        'batch_id' => $batch->id,
                        'output_type' => 'pyrolysis_oil',
                        'quantity' => $batch->input_weight_kg * 0.6, // 60% conversion
                        'unit' => 'liters',
                        'is_expected' => true,
                        'output_date' => $batch->expected_completion_date,
                        'quality_grade' => 92,
                        'remarks' => 'Expected high-quality pyrolysis oil'
                    ]);
                    
                    BatchOutput::create([
                        'batch_id' => $batch->id,
                        'output_type' => 'biochar',
                        'quantity' => $batch->input_weight_kg * 0.2, // 20% conversion
                        'unit' => 'kg',
                        'is_expected' => true,
                        'output_date' => $batch->expected_completion_date,
                        'quality_grade' => 94,
                        'remarks' => 'Expected carbon-rich biochar for soil improvement'
                    ]);
                    
                    // Actual outputs for completed batches
                    if ($batch->status === 'completed') {
                        BatchOutput::create([
                            'batch_id' => $batch->id,
                            'output_type' => 'pyrolysis_oil',
                            'quantity' => $batch->input_weight_kg * 0.55, // Actual 55% conversion
                            'unit' => 'liters',
                            'is_expected' => false,
                            'output_date' => $batch->actual_completion_date,
                            'quality_grade' => 89,
                            'remarks' => 'Actual pyrolysis oil production - good quality'
                        ]);
                        
                        BatchOutput::create([
                            'batch_id' => $batch->id,
                            'output_type' => 'biochar',
                            'quantity' => $batch->input_weight_kg * 0.18, // Actual 18% conversion
                            'unit' => 'kg',
                            'is_expected' => false,
                            'output_date' => $batch->actual_completion_date,
                            'quality_grade' => 91,
                            'remarks' => 'Actual biochar production - excellent quality'
                        ]);
                    }
                    break;
            }
        }
    }

    private function createWeeklyStatistics($presentationDate): void
    {
        // Create 4 weeks of statistics leading to presentation
        for ($week = 4; $week >= 1; $week--) {
            $weekStart = $presentationDate->copy()->subWeeks($week)->startOfWeek();
            $weekEnd = $weekStart->copy()->endOfWeek();
            $year = $weekStart->year;
            $weekNumber = $weekStart->weekOfYear;
            
            WeeklyStatistic::create([
                'year' => $year,
                'week_number' => $weekNumber,
                'week_start_date' => $weekStart,
                'week_end_date' => $weekEnd,
                'total_waste_kg' => 10000, // 10 tons per week
                'vegetable_waste_kg' => 3500, // 35% of 10 tons
                'fruit_waste_kg' => 3500,     // 35% of 10 tons
                'plastic_waste_kg' => 1500,   // 15% of 10 tons
                'biogas_generated_m3' => 2850, // 30% of processed waste
                'digestate_produced_kg' => 3800, // 40% of processed waste
                'larvae_produced_kg' => 1900, // 20% of processed waste
                'pyrolysis_oil_liters' => 855, // 60% of plastic waste
                'activated_carbon_kg' => 1425, // 15% of processed waste
            ]);
        }
    }

    private function createOutputInventory(): void
    {
        $inventory = [
            [
                'product_type' => 'biogas',
                'current_stock' => 1200,
                'unit' => 'm³',
                'total_produced' => 15000,
                'total_sold' => 13800,
                'total_used' => 0,
                'last_updated_date' => Carbon::now()
            ],
            [
                'product_type' => 'digestate',
                'current_stock' => 800,
                'unit' => 'kg',
                'total_produced' => 12000,
                'total_sold' => 11200,
                'total_used' => 0,
                'last_updated_date' => Carbon::now()
            ],
            [
                'product_type' => 'larvae',
                'current_stock' => 150,
                'unit' => 'kg',
                'total_produced' => 8000,
                'total_sold' => 7850,
                'total_used' => 0,
                'last_updated_date' => Carbon::now()
            ],
            [
                'product_type' => 'activated_carbon',
                'current_stock' => 200,
                'unit' => 'kg',
                'total_produced' => 6000,
                'total_sold' => 5800,
                'total_used' => 0,
                'last_updated_date' => Carbon::now()
            ],
            [
                'product_type' => 'paper_products',
                'current_stock' => 50, // Low stock for demo
                'unit' => 'kg',
                'total_produced' => 45000,
                'total_sold' => 44950,
                'total_used' => 0,
                'last_updated_date' => Carbon::now()
            ],
            [
                'product_type' => 'pyrolysis_oil',
                'current_stock' => 300,
                'unit' => 'liters',
                'total_produced' => 5000,
                'total_sold' => 4700,
                'total_used' => 0,
                'last_updated_date' => Carbon::now()
            ],
            [
                'product_type' => 'biochar',
                'current_stock' => 100,
                'unit' => 'kg',
                'total_produced' => 2000,
                'total_sold' => 1900,
                'total_used' => 0,
                'last_updated_date' => Carbon::now()
            ]
        ];

        foreach ($inventory as $item) {
            OutputInventory::create($item);
        }
    }

    private function createSalesRecords($presentationDate): void
    {
        $products = [
            ['type' => 'biogas', 'price' => 15, 'unit' => 'm³'],
            ['type' => 'digestate', 'price' => 8, 'unit' => 'kg'],
            ['type' => 'larvae', 'price' => 25, 'unit' => 'kg'],
            ['type' => 'activated_carbon', 'price' => 50, 'unit' => 'kg'],
            ['type' => 'paper_products', 'price' => 12, 'unit' => 'kg'],
            ['type' => 'pyrolysis_oil', 'price' => 30, 'unit' => 'liters'],
            ['type' => 'biochar', 'price' => 20, 'unit' => 'kg']
        ];

        // Create sales records for the past month
        for ($day = 30; $day >= 0; $day--) {
            $saleDate = $presentationDate->copy()->subDays($day);
            
            // 2-5 sales per day
            $salesPerDay = rand(2, 5);
            
            for ($i = 0; $i < $salesPerDay; $i++) {
                $product = $products[array_rand($products)];
                $quantity = rand(10, 100);
                $totalAmount = $quantity * $product['price'];
                
                SalesRecord::create([
                    'product_type' => $product['type'],
                    'quantity' => $quantity,
                    'unit' => $product['unit'],
                    'price_per_unit' => $product['price'],
                    'total_amount' => $totalAmount,
                    'sale_date' => $saleDate->copy()->addHours(rand(8, 18)),
                    'customer_name' => 'Customer ' . rand(1, 50),
                    'notes' => 'Regular customer purchase'
                ]);
            }
        }
    }

    private function createEnergyConsumption($presentationDate): void
    {
        // Create energy consumption records for the past month
        $energySources = [
            ['source' => 'biogas', 'unit' => 'm³', 'used_for' => 'processing'],
            ['source' => 'grid_electricity', 'unit' => 'kwh', 'used_for' => 'lighting'],
            ['source' => 'grid_electricity', 'unit' => 'kwh', 'used_for' => 'cold_storage'],
            ['source' => 'pyrolysis_oil', 'unit' => 'liters', 'used_for' => 'processing']
        ];
        
        for ($day = 30; $day >= 0; $day--) {
            $date = $presentationDate->copy()->subDays($day);
            
            // Create 2-4 energy consumption records per day
            $recordsPerDay = rand(2, 4);
            
            for ($i = 0; $i < $recordsPerDay; $i++) {
                $energySource = $energySources[array_rand($energySources)];
                $quantity = rand(50, 200);
                $costSaved = $energySource['source'] === 'biogas' ? rand(100, 300) : null;
                
                EnergyConsumption::create([
                    'consumption_date' => $date,
                    'energy_source' => $energySource['source'],
                    'quantity_consumed' => $quantity,
                    'unit' => $energySource['unit'],
                    'used_for' => $energySource['used_for'],
                    'cost_saved' => $costSaved
                ]);
            }
        }
    }

    private function createEnvironmentalImpact($presentationDate): void
    {
        // Create environmental impact records for the past month
        for ($day = 30; $day >= 0; $day--) {
            $date = $presentationDate->copy()->subDays($day);
            
            EnvironmentalImpact::create([
                'report_date' => $date,
                'waste_diverted_from_landfill_kg' => rand(800, 1200),
                'co2_emissions_reduced_kg' => rand(150, 250),
                'renewable_energy_generated_kwh' => rand(200, 400),
                'chemical_fertilizer_replaced_kg' => rand(50, 100),
                'plastic_diverted_from_ocean_kg' => rand(100, 200),
                'notes' => 'Daily environmental impact measurement'
            ]);
        }
    }
}
