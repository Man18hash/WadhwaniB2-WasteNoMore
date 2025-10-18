<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WeeklyStatistic;
use Carbon\Carbon;

class WeeklyStatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentYear = Carbon::now()->year;
        $currentWeek = Carbon::now()->week;
        
        // Create weekly statistics for the last 4 weeks
        for ($i = 3; $i >= 0; $i--) {
            $weekNumber = $currentWeek - $i;
            $weekStartDate = Carbon::now()->subWeeks($i)->startOfWeek();
            $weekEndDate = Carbon::now()->subWeeks($i)->endOfWeek();
            
            WeeklyStatistic::create([
                'year' => $currentYear,
                'week_number' => $weekNumber,
                'week_start_date' => $weekStartDate,
                'week_end_date' => $weekEndDate,
                'total_waste_kg' => rand(200, 600),
                'vegetable_waste_kg' => rand(100, 300),
                'fruit_waste_kg' => rand(80, 250),
                'plastic_waste_kg' => rand(50, 150),
                'biogas_generated_m3' => rand(50, 200),
                'digestate_produced_kg' => rand(200, 500),
                'larvae_produced_kg' => rand(30, 100),
                'pyrolysis_oil_liters' => rand(20, 80),
                'activated_carbon_kg' => rand(10, 50),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}