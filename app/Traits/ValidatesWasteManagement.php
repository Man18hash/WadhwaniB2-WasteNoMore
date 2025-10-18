<?php

namespace App\Traits;

use App\Services\ValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait ValidatesWasteManagement
{
    protected function validateWasteEntry(Request $request)
    {
        return Validator::make($request->all(), [
            'entry_date' => 'required|date|before_or_equal:today',
            'waste_type' => 'required|in:vegetable,fruit,plastic',
            'weight_kg' => 'required|numeric|min:0.01|max:10000',
            'processing_technology' => 'required|in:anaerobic,bsf,activated,paper,pyrolysis',
            'notes' => 'nullable|string|max:1000'
        ]);
    }

    protected function validateProcessBatch(Request $request, $excludeId = null)
    {
        $rules = [
            'input_weight_kg' => 'required|numeric|min:0.01|max:50000',
            'input_type' => 'required|string|max:255',
            'start_date' => 'required|date|before_or_equal:today',
            'expected_completion_date' => 'nullable|date|after:start_date',
            'description' => 'nullable|string|max:1000'
        ];

        if ($excludeId) {
            $rules['batch_number'] = 'required|string|max:255|unique:process_batches,batch_number,' . $excludeId;
        } else {
            $rules['batch_number'] = 'required|string|max:255|unique:process_batches,batch_number';
        }

        return Validator::make($request->all(), $rules);
    }

    protected function validateBatchOutput(Request $request)
    {
        return Validator::make($request->all(), [
            'output_type' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0.01|max:10000',
            'unit' => 'required|string|max:50',
            'is_expected' => 'boolean',
            'output_date' => 'nullable|date|before_or_equal:today',
            'quality_grade' => 'nullable|numeric|min:0|max:100',
            'remarks' => 'nullable|string|max:1000'
        ]);
    }

    protected function validateSalesRecord(Request $request)
    {
        return Validator::make($request->all(), [
            'product_type' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0.01|max:10000',
            'unit' => 'required|string|max:50',
            'price_per_unit' => 'required|numeric|min:0.01|max:100000',
            'sale_date' => 'required|date|before_or_equal:today',
            'customer_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000'
        ]);
    }

    protected function validateEnergyConsumption(Request $request)
    {
        return Validator::make($request->all(), [
            'consumption_date' => 'required|date|before_or_equal:today',
            'energy_source' => 'required|in:biogas,grid_electricity,pyrolysis_oil',
            'quantity_consumed' => 'required|numeric|min:0.01|max:100000',
            'unit' => 'required|string|max:50',
            'used_for' => 'required|string|max:255',
            'cost_saved' => 'nullable|numeric|min:0|max:1000000'
        ]);
    }

    protected function validateEnvironmentalImpact(Request $request)
    {
        return Validator::make($request->all(), [
            'report_date' => 'required|date|before_or_equal:today',
            'waste_diverted_from_landfill_kg' => 'nullable|numeric|min:0|max:1000000',
            'co2_emissions_reduced_kg' => 'nullable|numeric|min:0|max:1000000',
            'renewable_energy_generated_kwh' => 'nullable|numeric|min:0|max:1000000',
            'chemical_fertilizer_replaced_kg' => 'nullable|numeric|min:0|max:1000000',
            'plastic_diverted_from_ocean_kg' => 'nullable|numeric|min:0|max:1000000',
            'notes' => 'nullable|string|max:1000'
        ]);
    }

    protected function validateInventoryAdjustment(Request $request)
    {
        return Validator::make($request->all(), [
            'product_type' => 'required|string|max:255|exists:output_inventory,product_type',
            'adjustment_type' => 'required|in:add,subtract',
            'quantity' => 'required|numeric|min:0.01|max:10000',
            'reason' => 'required|string|max:255'
        ]);
    }

    protected function validateWithBusinessLogic(Request $request, $validationType, $additionalData = [])
    {
        $validator = $this->{"validate{$validationType}"}($request);

        if ($validator->fails()) {
            return $validator;
        }

        // Additional business logic validation
        switch ($validationType) {
            case 'WasteEntry':
                $dateValidation = ValidationService::validateWasteEntryDate($request->entry_date);
                if (!$dateValidation['valid']) {
                    $validator->errors()->add('entry_date', $dateValidation['message']);
                }
                break;

            case 'ProcessBatch':
                $batchValidation = ValidationService::validateBatchNumber(
                    $request->batch_number, 
                    $additionalData['process_type'] ?? 'unknown',
                    $additionalData['exclude_id'] ?? null
                );
                if (!$batchValidation['valid']) {
                    $validator->errors()->add('batch_number', $batchValidation['message']);
                }

                $dateValidation = ValidationService::validateBatchDateRange(
                    $request->start_date,
                    $request->expected_completion_date,
                    $request->actual_completion_date ?? null
                );
                if (!$dateValidation['valid']) {
                    $validator->errors()->add('start_date', $dateValidation['message']);
                }
                break;

            case 'BatchOutput':
                if ($request->quality_grade) {
                    $qualityValidation = ValidationService::validateOutputQuality(
                        $request->output_type,
                        $request->quality_grade
                    );
                    if (!$qualityValidation['valid']) {
                        $validator->errors()->add('quality_grade', $qualityValidation['message']);
                    }
                }
                break;

            case 'SalesRecord':
                $stockValidation = ValidationService::validateSalesQuantity(
                    $request->product_type,
                    $request->quantity
                );
                if (!$stockValidation['valid']) {
                    $validator->errors()->add('quantity', $stockValidation['message']);
                }
                break;

            case 'InventoryAdjustment':
                $adjustmentValidation = ValidationService::validateInventoryAdjustment(
                    $request->product_type,
                    $request->adjustment_type,
                    $request->quantity
                );
                if (!$adjustmentValidation['valid']) {
                    $validator->errors()->add('quantity', $adjustmentValidation['message']);
                }
                break;
        }

        return $validator;
    }

    protected function getValidationMessages()
    {
        return [
            'entry_date.required' => 'Entry date is required.',
            'entry_date.date' => 'Entry date must be a valid date.',
            'entry_date.before_or_equal' => 'Entry date cannot be in the future.',
            'waste_type.required' => 'Waste type is required.',
            'waste_type.in' => 'Waste type must be vegetable, fruit, or plastic.',
            'weight_kg.required' => 'Weight is required.',
            'weight_kg.numeric' => 'Weight must be a number.',
            'weight_kg.min' => 'Weight must be at least 0.01 kg.',
            'weight_kg.max' => 'Weight cannot exceed 10,000 kg.',
            'processing_technology.required' => 'Processing technology is required.',
            'processing_technology.in' => 'Processing technology must be anaerobic, bsf, activated, paper, or pyrolysis.',
            'notes.max' => 'Notes cannot exceed 1000 characters.',
            'batch_number.required' => 'Batch number is required.',
            'batch_number.unique' => 'This batch number already exists.',
            'batch_number.max' => 'Batch number cannot exceed 255 characters.',
            'input_weight_kg.required' => 'Input weight is required.',
            'input_weight_kg.numeric' => 'Input weight must be a number.',
            'input_weight_kg.min' => 'Input weight must be at least 0.01 kg.',
            'input_weight_kg.max' => 'Input weight cannot exceed 50,000 kg.',
            'input_type.required' => 'Input type is required.',
            'input_type.max' => 'Input type cannot exceed 255 characters.',
            'start_date.required' => 'Start date is required.',
            'start_date.date' => 'Start date must be a valid date.',
            'start_date.before_or_equal' => 'Start date cannot be in the future.',
            'expected_completion_date.date' => 'Expected completion date must be a valid date.',
            'expected_completion_date.after' => 'Expected completion date must be after start date.',
            'description.max' => 'Description cannot exceed 1000 characters.',
            'output_type.required' => 'Output type is required.',
            'output_type.max' => 'Output type cannot exceed 255 characters.',
            'quantity.required' => 'Quantity is required.',
            'quantity.numeric' => 'Quantity must be a number.',
            'quantity.min' => 'Quantity must be at least 0.01.',
            'quantity.max' => 'Quantity cannot exceed 10,000.',
            'unit.required' => 'Unit is required.',
            'unit.max' => 'Unit cannot exceed 50 characters.',
            'is_expected.boolean' => 'Expected flag must be true or false.',
            'output_date.date' => 'Output date must be a valid date.',
            'output_date.before_or_equal' => 'Output date cannot be in the future.',
            'quality_grade.numeric' => 'Quality grade must be a number.',
            'quality_grade.min' => 'Quality grade must be at least 0.',
            'quality_grade.max' => 'Quality grade cannot exceed 100.',
            'remarks.max' => 'Remarks cannot exceed 1000 characters.',
            'product_type.required' => 'Product type is required.',
            'product_type.max' => 'Product type cannot exceed 255 characters.',
            'price_per_unit.required' => 'Price per unit is required.',
            'price_per_unit.numeric' => 'Price per unit must be a number.',
            'price_per_unit.min' => 'Price per unit must be at least 0.01.',
            'price_per_unit.max' => 'Price per unit cannot exceed 100,000.',
            'sale_date.required' => 'Sale date is required.',
            'sale_date.date' => 'Sale date must be a valid date.',
            'sale_date.before_or_equal' => 'Sale date cannot be in the future.',
            'customer_name.max' => 'Customer name cannot exceed 255 characters.',
            'consumption_date.required' => 'Consumption date is required.',
            'consumption_date.date' => 'Consumption date must be a valid date.',
            'consumption_date.before_or_equal' => 'Consumption date cannot be in the future.',
            'energy_source.required' => 'Energy source is required.',
            'energy_source.in' => 'Energy source must be biogas, grid_electricity, or pyrolysis_oil.',
            'quantity_consumed.required' => 'Quantity consumed is required.',
            'quantity_consumed.numeric' => 'Quantity consumed must be a number.',
            'quantity_consumed.min' => 'Quantity consumed must be at least 0.01.',
            'quantity_consumed.max' => 'Quantity consumed cannot exceed 100,000.',
            'used_for.required' => 'Used for field is required.',
            'used_for.max' => 'Used for field cannot exceed 255 characters.',
            'cost_saved.numeric' => 'Cost saved must be a number.',
            'cost_saved.min' => 'Cost saved must be at least 0.',
            'cost_saved.max' => 'Cost saved cannot exceed 1,000,000.',
            'report_date.required' => 'Report date is required.',
            'report_date.date' => 'Report date must be a valid date.',
            'report_date.before_or_equal' => 'Report date cannot be in the future.',
            'adjustment_type.required' => 'Adjustment type is required.',
            'adjustment_type.in' => 'Adjustment type must be add or subtract.',
            'reason.required' => 'Reason is required.',
            'reason.max' => 'Reason cannot exceed 255 characters.'
        ];
    }
}
