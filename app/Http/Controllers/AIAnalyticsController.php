<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WasteEntry;
use App\Models\ProcessBatch;
use App\Models\BatchOutput;
use Carbon\Carbon;

class AIAnalyticsController extends Controller
{
    public function index()
    {
        // Get recent waste entries for analysis
        $recentWasteEntries = WasteEntry::orderBy('entry_date', 'desc')->limit(10)->get();
        
        // Get active batches for scheduling
        $activeBatches = ProcessBatch::whereIn('status', ['pending', 'processing'])->get();
        
        // Get historical data for yield prediction
        $historicalBatches = ProcessBatch::where('status', 'completed')
            ->with('batchOutputs')
            ->orderBy('actual_completion_date', 'desc')
            ->limit(20)
            ->get();
        
        // Simulate AI predictions (in real implementation, these would come from ML models)
        $aiPredictions = $this->generateAIPredictions($recentWasteEntries, $activeBatches, $historicalBatches);
        
        return view('ai-analytics.index', compact(
            'recentWasteEntries',
            'activeBatches', 
            'historicalBatches',
            'aiPredictions'
        ));
    }
    
    public function batchScheduling()
    {
        // Get pending batches
        $pendingBatches = ProcessBatch::where('status', 'pending')->get();
        
        // Simulate AI scheduling recommendations
        $schedulingRecommendations = $this->generateSchedulingRecommendations($pendingBatches);
        
        return view('ai-analytics.batch-scheduling', compact(
            'pendingBatches',
            'schedulingRecommendations'
        ));
    }
    
    public function yieldPrediction(Request $request)
    {
        $wasteType = $request->get('waste_type', 'vegetable');
        $weight = $request->get('weight', 1000);
        
        // Get historical data for justification
        $historicalBatches = ProcessBatch::where('status', 'completed')
            ->where('process_type', $this->getProcessTypeFromWasteType($wasteType))
            ->where('input_type', $wasteType)
            ->with('batchOutputs')
            ->get();
        
        $historicalBatchesCount = $historicalBatches->count();
        
        // Calculate processing days based on historical data
        $processingDays = $this->calculateAverageProcessingDays($historicalBatches, $wasteType);
        
        // Calculate conversion rates from historical data
        $conversionRates = $this->calculateConversionRates($historicalBatches, $wasteType);
        
        // Simulate AI yield prediction
        $yieldPrediction = $this->generateYieldPrediction($wasteType, $weight);
        
        return view('ai-analytics.yield-prediction', compact(
            'wasteType',
            'weight',
            'yieldPrediction',
            'historicalBatchesCount',
            'processingDays',
            'conversionRates'
        ));
    }
    
    public function qualityAssessment()
    {
        // Simulate AI quality assessment
        $qualityAssessments = $this->generateQualityAssessments();
        
        return view('ai-analytics.quality-assessment', compact('qualityAssessments'));
    }
    
    private function generateAIPredictions($wasteEntries, $activeBatches, $historicalBatches)
    {
        return [
            'optimal_schedule' => [
                'next_batch_time' => Carbon::now()->addHours(2)->format('Y-m-d H:i'),
                'recommended_process' => 'anaerobic_digestion',
                'efficiency_score' => 87.5,
                'reason' => 'High organic content detected, optimal for biogas production'
            ],
            'yield_forecast' => [
                'biogas_predicted' => rand(150, 300),
                'digestate_predicted' => rand(400, 600),
                'confidence_level' => 92.3,
                'factors' => ['waste_composition', 'weather_conditions', 'historical_performance']
            ],
            'quality_score' => [
                'overall_quality' => 88.7,
                'contamination_level' => 'Low',
                'recommendations' => ['Proceed with processing', 'Monitor temperature closely']
            ]
        ];
    }
    
    private function generateSchedulingRecommendations($pendingBatches)
    {
        $recommendations = [];
        
        foreach ($pendingBatches as $batch) {
            // Ensure recommended time is always in the future (at least 1 hour from now)
            $recommendedTime = Carbon::now()->addHours(rand(1, 24));
            $inputStartDate = $batch->start_date ?? Carbon::now();
            $inputEndDate = $batch->expected_completion_date ?? $inputStartDate->copy()->addDays(7);
            
            // Use scheduled start date if batch has been scheduled, otherwise use AI recommended time
            $countdownTime = $batch->start_date ? Carbon::parse($batch->start_date) : $recommendedTime;
            $isScheduled = $batch->start_date ? true : false;
            
            $recommendations[] = [
                'batch_id' => $batch->id,
                'batch_number' => $batch->batch_number,
                'process_type' => $batch->process_type,
                'input_type' => $batch->input_type,
                'input_weight_kg' => $batch->input_weight_kg,
                'input_start_date' => $inputStartDate,
                'input_end_date' => $inputEndDate,
                'recommended_start_time' => $recommendedTime,
                'countdown_time' => $countdownTime,
                'time_until_recommended' => $countdownTime->diffForHumans(),
                'time_until_recommended_minutes' => Carbon::now()->diffInMinutes($countdownTime, false),
                'is_scheduled' => $isScheduled,
                'priority_score' => rand(70, 95),
                'reason' => 'Optimal conditions detected for ' . $batch->process_type,
                'expected_efficiency' => rand(80, 95) . '%',
                'weather_factor' => 'Favorable',
                'demand_factor' => 'High',
                'processing_duration_hours' => rand(24, 168), // 1-7 days
                'batch' => $batch // Include the full batch object for additional data
            ];
        }
        
        return $recommendations;
    }
    
    private function generateYieldPrediction($wasteType, $weight)
    {
        $baseYields = [
            'vegetable' => ['biogas' => 0.15, 'digestate' => 0.8],
            'fruit' => ['biogas' => 0.12, 'digestate' => 0.7],
            'plastic' => ['pyrolysis_oil' => 0.3, 'syngas' => 0.4]
        ];
        
        $yields = $baseYields[$wasteType] ?? $baseYields['vegetable'];
        
        // Generate trend data for different weights
        $trendData = [];
        $weightSteps = [500, 750, 1000, 1250, 1500, 1750, 2000];
        
        foreach ($weightSteps as $stepWeight) {
            $stepYields = [];
            foreach ($yields as $output => $yield) {
                $stepYields[$output] = round($yield * $stepWeight, 2);
            }
            $trendData[] = [
                'weight' => $stepWeight,
                'yields' => $stepYields
            ];
        }
        
        // Convert yields to associative array with proper keys
        $predictedOutputs = [];
        foreach ($yields as $output => $yield) {
            $predictedOutputs[$output] = round($yield * $weight, 2);
        }
        
        return [
            'waste_type' => $wasteType,
            'input_weight' => $weight,
            'predicted_outputs' => $predictedOutputs,
            'confidence_level' => rand(85, 95),
            'trend_data' => $trendData,
            'factors_considered' => [
                'Waste composition analysis',
                'Historical processing data',
                'Current weather conditions',
                'Equipment efficiency rating'
            ],
            'recommendations' => [
                'Optimal processing temperature: 35-40°C',
                'Processing time: 15-20 days',
                'Monitor pH levels regularly'
            ]
        ];
    }
    
    private function getProcessTypeFromWasteType($wasteType)
    {
        return match($wasteType) {
            'fruit', 'vegetable' => 'anaerobic_digestion',
            'plastic' => 'pyrolysis',
            'agricultural' => 'bsf_larvae',
            default => 'anaerobic_digestion'
        };
    }
    
    private function calculateAverageProcessingDays($historicalBatches, $wasteType)
    {
        if ($historicalBatches->isEmpty()) {
            return match($wasteType) {
                'fruit', 'vegetable' => 18,
                'plastic' => 3,
                'agricultural' => 12,
                default => 10
            };
        }
        
        $totalDays = 0;
        $count = 0;
        
        foreach ($historicalBatches as $batch) {
            if ($batch->start_date && $batch->actual_completion_date) {
                $days = Carbon::parse($batch->start_date)->diffInDays(Carbon::parse($batch->actual_completion_date));
                $totalDays += $days;
                $count++;
            }
        }
        
        return $count > 0 ? round($totalDays / $count) : 18;
    }
    
    private function calculateConversionRates($historicalBatches, $wasteType)
    {
        if ($historicalBatches->isEmpty()) {
            return match($wasteType) {
                'fruit' => '12% biogas, 70% digestate',
                'vegetable' => '15% biogas, 80% digestate',
                'plastic' => '30% pyrolysis oil, 40% syngas',
                'agricultural' => '15% larvae, 30% frass',
                default => '12% biogas, 70% digestate'
            };
        }
        
        $totalInput = 0;
        $totalOutputs = [];
        
        foreach ($historicalBatches as $batch) {
            $totalInput += $batch->input_weight_kg ?? 0;
            
            foreach ($batch->batchOutputs as $output) {
                if (!$output->is_expected) { // Only actual outputs
                    $outputType = $output->output_type;
                    $totalOutputs[$outputType] = ($totalOutputs[$outputType] ?? 0) + $output->quantity;
                }
            }
        }
        
        if ($totalInput == 0) {
            return '12% biogas, 70% digestate';
        }
        
        $rates = [];
        foreach ($totalOutputs as $type => $quantity) {
            $rate = round(($quantity / $totalInput) * 100, 1);
            $rates[] = "{$rate}% {$type}";
        }
        
        return implode(', ', $rates);
    }
    
    private function generateQualityAssessments()
    {
        return [
            [
                'waste_id' => 'W-001',
                'waste_type' => 'Vegetable',
                'quality_score' => 92.5,
                'contamination_level' => 'Low',
                'ai_analysis' => 'High quality organic waste, minimal contamination detected',
                'recommendations' => ['Proceed with anaerobic digestion', 'No pre-treatment required'],
                'image_analysis' => 'Green, fresh vegetables detected'
            ],
            [
                'waste_id' => 'W-002', 
                'waste_type' => 'Fruit',
                'quality_score' => 88.3,
                'contamination_level' => 'Medium',
                'ai_analysis' => 'Good quality fruit waste, some mold detected',
                'recommendations' => ['Proceed with BSF larvae cultivation', 'Remove visible mold'],
                'image_analysis' => 'Mixed fruit with some brown spots'
            ],
            [
                'waste_id' => 'W-003',
                'waste_type' => 'Plastic',
                'quality_score' => 85.7,
                'contamination_level' => 'Low',
                'ai_analysis' => 'Clean plastic waste, suitable for pyrolysis',
                'recommendations' => ['Proceed with pyrolysis', 'Sort by plastic type'],
                'image_analysis' => 'Clean plastic bottles and containers'
            ]
        ];
    }
    
    public function analyzeImage(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'images' => 'required|array|min:1|max:5',
                'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240', // 10MB max
                'waste_type' => 'required|string|in:organic,plastic,mixed,agricultural',
                'analysis_type' => 'required|string|in:quality,contamination,composition,full'
            ]);
            
            $images = $request->file('images');
            $wasteType = $request->input('waste_type');
            $analysisType = $request->input('analysis_type');
            
            // Simulate AI image analysis processing time
            $processingTime = rand(15, 35) / 10; // 1.5 to 3.5 seconds
            
            // Generate AI analysis results based on waste type and analysis type
            $analysisResults = $this->generateImageAnalysisResults($wasteType, $analysisType, count($images));
            
            return response()->json([
                'success' => true,
                'processing_time' => $processingTime,
                'images_analyzed' => count($images),
                'waste_type' => ucfirst($wasteType),
                'analysis_type' => ucfirst($analysisType),
                'quality_score' => $analysisResults['quality_score'],
                'quality_level' => $analysisResults['quality_level'],
                'contamination_level' => $analysisResults['contamination_level'],
                'contamination_percentage' => $analysisResults['contamination_percentage'],
                'analysis_summary' => $analysisResults['analysis_summary'],
                'detected_components' => $analysisResults['detected_components'],
                'recommendations' => $analysisResults['recommendations'],
                'recommended_technology' => $analysisResults['recommended_technology'],
                'expected_processing_time' => $analysisResults['expected_processing_time']
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Analysis failed: ' . $e->getMessage()
            ], 500);
        }
    }
    
    private function generateImageAnalysisResults($wasteType, $analysisType, $imageCount)
    {
        $baseQuality = match($wasteType) {
            'organic' => rand(85, 95),
            'plastic' => rand(80, 90),
            'mixed' => rand(75, 85),
            'agricultural' => rand(88, 95),
            default => rand(80, 90)
        };
        
        $qualityScore = $baseQuality + rand(-5, 5);
        $qualityScore = max(60, min(100, $qualityScore)); // Keep between 60-100
        
        $qualityLevel = match(true) {
            $qualityScore >= 90 => 'Excellent',
            $qualityScore >= 80 => 'Good',
            $qualityScore >= 70 => 'Fair',
            default => 'Poor'
        };
        
        $contaminationLevels = ['Low', 'Medium', 'High'];
        $contaminationLevel = $contaminationLevels[array_rand($contaminationLevels)];
        $contaminationPercentage = match($contaminationLevel) {
            'Low' => rand(5, 15),
            'Medium' => rand(20, 40),
            'High' => rand(50, 80)
        };
        
        $components = match($wasteType) {
            'organic' => ['Vegetable matter', 'Fruit peels', 'Organic residues', 'Natural fibers'],
            'plastic' => ['PET bottles', 'HDPE containers', 'Plastic bags', 'Packaging materials'],
            'mixed' => ['Organic matter', 'Plastic fragments', 'Paper products', 'Metal pieces'],
            'agricultural' => ['Crop residues', 'Plant matter', 'Soil particles', 'Organic waste']
        };
        
        $detectedComponents = array_slice($components, 0, rand(2, 4));
        
        $recommendations = match($wasteType) {
            'organic' => [
                'Proceed with anaerobic digestion process',
                'Monitor moisture content levels',
                'Ensure proper temperature control'
            ],
            'plastic' => [
                'Sort by plastic type before processing',
                'Proceed with pyrolysis operations',
                'Check for metal contaminants'
            ],
            'mixed' => [
                'Separate organic and inorganic components',
                'Pre-treat before processing',
                'Consider manual sorting'
            ],
            'agricultural' => [
                'Proceed with BSF larvae cultivation',
                'Monitor nutrient content',
                'Ensure proper aeration'
            ]
        };
        
        $technologies = match($wasteType) {
            'organic' => 'Anaerobic Digestion',
            'plastic' => 'Pyrolysis',
            'mixed' => 'Mixed Processing',
            'agricultural' => 'BSF Larvae Cultivation'
        };
        
        $processingTimes = match($wasteType) {
            'organic' => '15-20 days',
            'plastic' => '2-4 hours',
            'mixed' => '3-5 days',
            'agricultural' => '10-14 days'
        };
        
        $analysisSummary = "AI analysis of {$imageCount} image(s) shows " . strtolower($qualityLevel) . " quality {$wasteType} waste with " . strtolower($contaminationLevel) . " contamination levels. The material appears suitable for processing with recommended technology.";
        
        return [
            'quality_score' => $qualityScore,
            'quality_level' => $qualityLevel,
            'contamination_level' => $contaminationLevel,
            'contamination_percentage' => $contaminationPercentage,
            'analysis_summary' => $analysisSummary,
            'detected_components' => $detectedComponents,
            'recommendations' => $recommendations,
            'recommended_technology' => $technologies,
            'expected_processing_time' => $processingTimes
        ];
    }

    /**
     * Approve a batch for processing
     */
    public function approveBatch(Request $request, $batchId)
    {
        $batch = ProcessBatch::findOrFail($batchId);
        
        // Update batch status to processing
        $batch->update([
            'status' => 'processing',
            'start_date' => Carbon::now(),
            'description' => $batch->description . ' [AI Approved: ' . Carbon::now()->format('Y-m-d H:i') . ']'
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Batch approved and processing started successfully!',
            'batch_status' => $batch->status
        ]);
    }

    /**
     * Reject a batch
     */
    public function rejectBatch(Request $request, $batchId)
    {
        $batch = ProcessBatch::findOrFail($batchId);
        
        // Update batch status to cancelled
        $batch->update([
            'status' => 'cancelled',
            'description' => $batch->description . ' [AI Rejected: ' . Carbon::now()->format('Y-m-d H:i') . ']'
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Batch rejected successfully!',
            'batch_status' => $batch->status
        ]);
    }

    /**
     * Schedule a batch for later processing
     */
    public function scheduleBatchLater(Request $request, $batchId)
    {
        $request->validate([
            'scheduled_date' => 'required|date|after_or_equal:today'
        ], [
            'scheduled_date.required' => 'Scheduled date is required.',
            'scheduled_date.date' => 'Scheduled date must be a valid date.',
            'scheduled_date.after_or_equal' => 'Scheduled date must be today or in the future.'
        ]);
        
        $batch = ProcessBatch::findOrFail($batchId);
        
        // Calculate processing duration based on process type
        $processingDurationHours = $this->getProcessingDurationHours($batch->process_type);
        
        // Calculate expected completion date
        $newStartDate = Carbon::parse($request->scheduled_date);
        $expectedCompletionDate = $newStartDate->copy()->addHours($processingDurationHours);
        
        // Debug logging
        \Log::info('Scheduling batch', [
            'batch_id' => $batchId,
            'requested_date' => $request->scheduled_date,
            'parsed_date' => $newStartDate->toDateTimeString(),
            'completion_date' => $expectedCompletionDate->toDateTimeString(),
            'processing_hours' => $processingDurationHours
        ]);
        
        // Update batch with new scheduled date and calculated completion date
        $batch->update([
            'start_date' => $newStartDate,
            'expected_completion_date' => $expectedCompletionDate,
            'description' => $batch->description . ' [Rescheduled: Start ' . $newStartDate->format('Y-m-d H:i') . ', Expected Completion ' . $expectedCompletionDate->format('Y-m-d H:i') . ']'
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Batch scheduled for later processing!',
            'scheduled_date' => $newStartDate->format('Y-m-d H:i'),
            'expected_completion_date' => $expectedCompletionDate->format('Y-m-d H:i'),
            'processing_duration_hours' => $processingDurationHours
        ]);
    }
    
    private function getProcessingDurationHours($processType)
    {
        // Define processing durations for different process types (in hours)
        $durations = [
            'anaerobic_digestion' => 168, // 7 days
            'bsf_larvae' => 336, // 14 days
            'activated_carbon' => 72, // 3 days
            'paper_packaging' => 48, // 2 days
            'pyrolysis' => 24 // 1 day
        ];
        
        return $durations[$processType] ?? 72; // Default to 3 days if not found
    }
}