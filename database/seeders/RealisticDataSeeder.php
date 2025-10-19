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
use Illuminate\Support\Facades\DB;

class RealisticDataSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        WasteEntry::truncate();
        ProcessBatch::truncate();
        BatchOutput::truncate();
        WeeklyStatistic::truncate();
        OutputInventory::truncate();
        SalesRecord::truncate();
        EnergyConsumption::truncate();
        EnvironmentalImpact::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->createWasteEntries();
        $this->createProcessBatches();
        $this->createBatchOutputs();
        $this->createInventory();
        $this->createSalesRecords();
        $this->createEnergyConsumption();
        $this->createEnvironmentalImpact();
        $this->createWeeklyStatistics();
    }

    private function createWasteEntries(): void
    {
        // Define logical combinations of waste types and processing technologies
        $wasteProcessingMap = [
            'vegetable' => ['anaerobic', 'bsf'],
            'fruit' => ['anaerobic', 'bsf'],
            'plastic' => ['pyrolysis'],
            'paper' => ['paper']
        ];
        
        $wasteNotesMap = [
            'vegetable' => [
                'Fresh vegetable scraps from kitchen prep',
                'Organic vegetable waste from market',
                'Vegetable peels and trimmings',
                'Expired vegetable produce'
            ],
            'fruit' => [
                'Mixed fruit peels and cores',
                'Overripe fruit from market',
                'Fruit processing waste',
                'Expired fruit items'
            ],
            'plastic' => [
                'Plastic packaging materials',
                'Plastic containers and bags',
                'Plastic waste from packaging',
                'Mixed plastic materials'
            ],
            'paper' => [
                'Paper and cardboard packaging',
                'Office paper waste',
                'Cardboard boxes and packaging',
                'Mixed paper materials'
            ]
        ];
        
        $entryDates = [];
        
        // Generate dates for the past month including current week
        for ($i = 30; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $entryDates[] = $date;
        }
        
        // Add some entries for the current week
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $entryDates[] = $date;
        }

        foreach ($entryDates as $date) {
            // 2-5 entries per day
            $entriesPerDay = rand(2, 5);
            
            for ($i = 0; $i < $entriesPerDay; $i++) {
                $wasteType = array_rand($wasteProcessingMap);
                $processingTech = $wasteProcessingMap[$wasteType][array_rand($wasteProcessingMap[$wasteType])];
                $notes = $wasteNotesMap[$wasteType][array_rand($wasteNotesMap[$wasteType])];
                
                WasteEntry::create([
                    'waste_type' => $wasteType,
                    'weight_kg' => rand(50, 500),
                    'processing_technology' => $processingTech,
                    'entry_date' => $date->copy()->addHours(rand(8, 18)),
                    'notes' => $notes,
                ]);
            }
        }
    }

    private function createProcessBatches(): void
    {
        $wasteEntries = WasteEntry::all();
        $processTypes = ['anaerobic_digestion', 'bsf_larvae', 'activated_carbon', 'paper_packaging', 'pyrolysis'];
        $statuses = ['pending', 'processing', 'completed'];
        
        $batchNumber = 1;
        
        foreach ($wasteEntries->chunk(rand(3, 8)) as $chunk) {
            $processType = $processTypes[array_rand($processTypes)];
            $startDate = $chunk->first()->entry_date->addDays(rand(1, 3));
            $status = $statuses[array_rand($statuses)];
            
            $expectedCompletion = $startDate->copy()->addDays($this->getProcessDuration($processType));
            $actualCompletion = null;
            
            if ($status === 'completed') {
                $actualCompletion = $expectedCompletion->copy()->addHours(rand(-12, 24));
            }
            
            ProcessBatch::create([
                'batch_number' => $this->getBatchNumber($processType, $batchNumber++),
                'process_type' => $processType,
                'input_type' => $chunk->first()->waste_type,
                'input_weight_kg' => $chunk->sum('weight_kg'),
                'start_date' => $startDate,
                'expected_completion_date' => $expectedCompletion,
                'actual_completion_date' => $actualCompletion,
                'status' => $status,
                'description' => $this->getProcessDescription($processType),
            ]);
        }
    }

    private function createBatchOutputs(): void
    {
        $processBatches = ProcessBatch::all();
        
        foreach ($processBatches as $batch) {
            $outputs = $this->getExpectedOutputs($batch->process_type);
            
            foreach ($outputs as $outputType => $outputData) {
                // Expected output
                BatchOutput::create([
                    'batch_id' => $batch->id,
                    'output_type' => $outputType,
                    'quantity' => $outputData['expected'],
                    'unit' => $outputData['unit'],
                    'quality_grade' => rand(70, 95),
                    'output_date' => $batch->expected_completion_date,
                    'is_expected' => true,
                    'remarks' => 'Expected output based on input parameters',
                ]);
                
                // Actual output (if batch is completed)
                if ($batch->status === 'completed') {
                    $actualQuantity = $outputData['expected'] * (rand(85, 115) / 100); // ±15% variation
                    
                    BatchOutput::create([
                        'batch_id' => $batch->id,
                        'output_type' => $outputType,
                        'quantity' => $actualQuantity,
                        'unit' => $outputData['unit'],
                        'quality_grade' => rand(70, 95),
                        'output_date' => $batch->actual_completion_date,
                        'is_expected' => false,
                        'remarks' => 'Actual output after processing',
                    ]);
                }
            }
        }
    }

    private function createInventory(): void
    {
        $outputTypes = [
            'biogas' => ['unit' => 'm³'],
            'digestate' => ['unit' => 'kg'],
            'larvae' => ['unit' => 'kg'],
            'pyrolysis_oil' => ['unit' => 'liters'],
            'activated_carbon' => ['unit' => 'kg'],
            'paper_products' => ['unit' => 'kg'],
            'biochar' => ['unit' => 'kg'],
        ];
        
        foreach ($outputTypes as $outputType => $data) {
            $currentStock = rand(50, 500);
            OutputInventory::create([
                'product_type' => $outputType,
                'current_stock' => $currentStock,
                'unit' => $data['unit'],
                'total_produced' => rand(200, 800),
                'total_sold' => rand(100, 400),
                'total_used' => rand(50, 200),
                'last_updated_date' => Carbon::now()->subDays(rand(1, 7)),
            ]);
        }
    }

    private function createSalesRecords(): void
    {
        $outputTypes = ['biogas', 'digestate', 'larvae', 'pyrolysis_oil', 'activated_carbon', 'paper_products', 'biochar'];
        $customers = ['Farm Co.', 'Energy Solutions Ltd.', 'Restaurant Group', 'Manufacturing Inc.', 'Local Market'];
        
        for ($i = 0; $i < 25; $i++) {
            $outputType = $outputTypes[array_rand($outputTypes)];
            $saleDate = Carbon::now()->subDays(rand(0, 30)); // Include today
            $quantity = rand(10, 100);
            $unitPrice = $this->getOutputPrice($outputType);
            
            SalesRecord::create([
                'product_type' => $outputType,
                'quantity' => $quantity,
                'unit' => $this->getOutputUnit($outputType),
                'price_per_unit' => $unitPrice,
                'total_amount' => $quantity * $unitPrice,
                'customer_name' => $customers[array_rand($customers)],
                'sale_date' => $saleDate,
                'notes' => 'Regular customer order',
            ]);
        }
    }

    private function createEnergyConsumption(): void
    {
        $energySources = ['biogas', 'grid_electricity', 'pyrolysis_oil'];
        $usedFor = ['cold_storage', 'lighting', 'processing', 'heating', 'ventilation'];
        
        for ($i = 30; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $energySource = $energySources[array_rand($energySources)];
            $quantity = rand(50, 300);
            $unit = $this->getEnergyUnit($energySource);
            $costSaved = $energySource === 'biogas' ? rand(20, 100) : 0;
            
            EnergyConsumption::create([
                'consumption_date' => $date,
                'energy_source' => $energySource,
                'quantity_consumed' => $quantity,
                'unit' => $unit,
                'used_for' => $usedFor[array_rand($usedFor)],
                'cost_saved' => $costSaved,
            ]);
        }
    }

    private function createEnvironmentalImpact(): void
    {
        for ($i = 30; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            
            EnvironmentalImpact::create([
                'report_date' => $date,
                'waste_diverted_from_landfill_kg' => rand(200, 800),
                'co2_emissions_reduced_kg' => rand(100, 500),
                'renewable_energy_generated_kwh' => rand(150, 400),
                'chemical_fertilizer_replaced_kg' => rand(50, 200),
                'plastic_diverted_from_ocean_kg' => rand(30, 150),
                'notes' => 'Daily environmental impact assessment',
            ]);
        }
    }

    private function createWeeklyStatistics(): void
    {
        $currentYear = Carbon::now()->year;
        $currentWeek = Carbon::now()->week;
        
        for ($week = $currentWeek - 4; $week <= $currentWeek; $week++) {
            $weekStart = Carbon::now()->setISODate($currentYear, $week)->startOfWeek();
            $weekEnd = $weekStart->copy()->endOfWeek();
            
            WeeklyStatistic::create([
                'year' => $currentYear,
                'week_number' => $week,
                'week_start_date' => $weekStart,
                'week_end_date' => $weekEnd,
                'total_waste_kg' => rand(2000, 5000),
                'vegetable_waste_kg' => rand(800, 2000),
                'fruit_waste_kg' => rand(600, 1500),
                'plastic_waste_kg' => rand(400, 1000),
                'paper_waste_kg' => rand(200, 500),
                'biogas_generated_m3' => rand(500, 1200),
                'digestate_produced_kg' => rand(1500, 3000),
                'larvae_produced_kg' => rand(200, 600),
                'pyrolysis_oil_liters' => rand(100, 300),
                'activated_carbon_kg' => rand(50, 150),
            ]);
        }
    }

    // Helper methods
    private function getWasteDescription(): string
    {
        $descriptions = [
            'Fresh vegetable scraps from kitchen prep',
            'Mixed fruit peels and cores',
            'Plastic packaging materials',
            'Organic food waste',
            'Paper and cardboard packaging',
            'Leftover prepared foods',
            'Expired produce items',
        ];
        return $descriptions[array_rand($descriptions)];
    }

    private function getProcessDuration(string $processType): int
    {
        $durations = [
            'anaerobic_digestion' => rand(14, 21),
            'bsf_larvae' => rand(10, 14),
            'activated_carbon' => rand(7, 10),
            'paper_packaging' => rand(3, 7),
            'pyrolysis' => rand(5, 8),
        ];
        return $durations[$processType];
    }

    private function getBatchNumber(string $processType, int $number): string
    {
        $prefixes = [
            'anaerobic_digestion' => 'AD',
            'bsf_larvae' => 'BSF',
            'activated_carbon' => 'AC',
            'paper_packaging' => 'PP',
            'pyrolysis' => 'PY',
        ];
        return $prefixes[$processType] . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    private function getProcessDescription(string $processType): string
    {
        $descriptions = [
            'anaerobic_digestion' => 'Biogas production from organic waste',
            'bsf_larvae' => 'Black soldier fly larvae cultivation',
            'activated_carbon' => 'Activated carbon production from biomass',
            'paper_packaging' => 'Paper and packaging material production',
            'pyrolysis' => 'Pyrolysis oil production from plastic waste',
        ];
        return $descriptions[$processType];
    }

    private function getOperatorNotes(): string
    {
        $notes = [
            'Process running smoothly',
            'Minor temperature fluctuations observed',
            'Good efficiency achieved',
            'Quality parameters within range',
            'Equipment functioning optimally',
        ];
        return $notes[array_rand($notes)];
    }


    private function getExpectedOutputs(string $processType): array
    {
        $outputs = [
            'anaerobic_digestion' => [
                'biogas' => ['expected' => rand(50, 150), 'unit' => 'm³'],
                'digestate' => ['expected' => rand(200, 500), 'unit' => 'kg'],
            ],
            'bsf_larvae' => [
                'larvae' => ['expected' => rand(30, 80), 'unit' => 'kg'],
                'frass' => ['expected' => rand(150, 400), 'unit' => 'kg'],
            ],
            'activated_carbon' => [
                'activated_carbon' => ['expected' => rand(20, 60), 'unit' => 'kg'],
            ],
            'paper_packaging' => [
                'paper_products' => ['expected' => rand(80, 200), 'unit' => 'kg'],
            ],
            'pyrolysis' => [
                'pyrolysis_oil' => ['expected' => rand(40, 100), 'unit' => 'liters'],
                'biochar' => ['expected' => rand(30, 80), 'unit' => 'kg'],
            ],
        ];
        return $outputs[$processType];
    }

    private function getEnergyUnit(string $energySource): string
    {
        $units = [
            'biogas' => 'm³',
            'grid_electricity' => 'kwh',
            'pyrolysis_oil' => 'liters',
        ];
        return $units[$energySource] ?? 'kwh';
    }

    private function generatePhoneNumber(): string
    {
        return '+1-' . rand(200, 999) . '-' . rand(100, 999) . '-' . rand(1000, 9999);
    }

    private function getOutputUnit(string $outputType): string
    {
        $units = [
            'biogas' => 'm³',
            'digestate' => 'kg',
            'larvae' => 'kg',
            'pyrolysis_oil' => 'liters',
            'activated_carbon' => 'kg',
            'paper_products' => 'kg',
            'biochar' => 'kg',
        ];
        return $units[$outputType] ?? 'kg';
    }

    private function getOutputPrice(string $outputType): float
    {
        $prices = [
            'biogas' => 2.50,
            'digestate' => 0.80,
            'larvae' => 15.00,
            'pyrolysis_oil' => 8.50,
            'activated_carbon' => 25.00,
            'paper_products' => 3.20,
            'biochar' => 12.00,
        ];
        return $prices[$outputType] ?? 5.00;
    }
}
