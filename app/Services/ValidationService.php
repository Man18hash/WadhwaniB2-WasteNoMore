<?php

namespace App\Services;

use App\Models\OutputInventory;
use App\Models\ProcessBatch;
use Carbon\Carbon;

class ValidationService
{
    public static function validateInventoryAdjustment($productType, $adjustmentType, $quantity)
    {
        $inventory = OutputInventory::where('product_type', $productType)->first();
        
        if (!$inventory) {
            return ['valid' => false, 'message' => 'Product not found in inventory.'];
        }

        if ($adjustmentType === 'subtract' && $inventory->current_stock < $quantity) {
            return [
                'valid' => false, 
                'message' => "Insufficient stock. Current stock: {$inventory->current_stock} {$inventory->unit}"
            ];
        }

        return ['valid' => true];
    }

    public static function validateBatchCompletion($batchId)
    {
        $batch = ProcessBatch::find($batchId);
        
        if (!$batch) {
            return ['valid' => false, 'message' => 'Batch not found.'];
        }

        if ($batch->status === 'completed') {
            return ['valid' => false, 'message' => 'Batch is already completed.'];
        }

        if ($batch->status === 'cancelled') {
            return ['valid' => false, 'message' => 'Cannot complete a cancelled batch.'];
        }

        return ['valid' => true];
    }

    public static function validateSalesQuantity($productType, $quantity)
    {
        $inventory = OutputInventory::where('product_type', $productType)->first();
        
        if (!$inventory) {
            return ['valid' => false, 'message' => 'Product not found in inventory.'];
        }

        if ($inventory->current_stock < $quantity) {
            return [
                'valid' => false, 
                'message' => "Insufficient stock for sale. Available: {$inventory->current_stock} {$inventory->unit}"
            ];
        }

        return ['valid' => true];
    }

    public static function validateBatchDateRange($startDate, $expectedCompletionDate = null, $actualCompletionDate = null)
    {
        if ($startDate < Carbon::today()) {
            return ['valid' => false, 'message' => 'Start date cannot be in the past.'];
        }

        if ($expectedCompletionDate && $expectedCompletionDate <= $startDate) {
            return ['valid' => false, 'message' => 'Expected completion date must be after start date.'];
        }

        if ($actualCompletionDate && $actualCompletionDate <= $startDate) {
            return ['valid' => false, 'message' => 'Actual completion date must be after start date.'];
        }

        if ($actualCompletionDate && $expectedCompletionDate && $actualCompletionDate > $expectedCompletionDate->addDays(7)) {
            return ['valid' => false, 'message' => 'Actual completion date is more than 7 days after expected completion.'];
        }

        return ['valid' => true];
    }

    public static function validateWasteEntryDate($entryDate)
    {
        if ($entryDate > Carbon::today()) {
            return ['valid' => false, 'message' => 'Entry date cannot be in the future.'];
        }

        if ($entryDate < Carbon::today()->subDays(30)) {
            return ['valid' => false, 'message' => 'Entry date cannot be more than 30 days in the past.'];
        }

        return ['valid' => true];
    }

    public static function validateOutputQuality($outputType, $qualityGrade)
    {
        $qualityRanges = [
            'biogas' => [60, 100],
            'digestate' => [70, 100],
            'larvae' => [80, 100],
            'pyrolysis_oil' => [75, 100],
            'activated_carbon' => [85, 100]
        ];

        if (!isset($qualityRanges[$outputType])) {
            return ['valid' => true]; // No specific quality requirements
        }

        [$min, $max] = $qualityRanges[$outputType];

        if ($qualityGrade < $min) {
            return [
                'valid' => false, 
                'message' => "Quality grade for {$outputType} must be at least {$min}%"
            ];
        }

        if ($qualityGrade > $max) {
            return [
                'valid' => false, 
                'message' => "Quality grade for {$outputType} cannot exceed {$max}%"
            ];
        }

        return ['valid' => true];
    }

    public static function validateBatchNumber($batchNumber, $processType, $excludeId = null)
    {
        $query = ProcessBatch::where('batch_number', $batchNumber);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        if ($query->exists()) {
            return ['valid' => false, 'message' => 'Batch number already exists.'];
        }

        // Validate batch number format based on process type
        $patterns = [
            'anaerobic_digestion' => '/^AD-\d{3}$/',
            'bsf_larvae' => '/^BSF-\d{3}$/',
            'activated_carbon' => '/^AC-\d{3}$/',
            'paper_packaging' => '/^PP-\d{3}$/',
            'pyrolysis' => '/^PY-\d{3}$/'
        ];

        if (isset($patterns[$processType])) {
            if (!preg_match($patterns[$processType], $batchNumber)) {
                return [
                    'valid' => false, 
                    'message' => "Invalid batch number format for {$processType}. Expected format: " . $patterns[$processType]
                ];
            }
        }

        return ['valid' => true];
    }
}
