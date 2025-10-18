<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidationRules
{
    public static function wasteType()
    {
        return 'required|in:vegetable,fruit,plastic';
    }

    public static function processingTechnology()
    {
        return 'required|in:anaerobic,bsf,activated,paper,pyrolysis';
    }

    public static function weight($min = 0.01, $max = 10000)
    {
        return "required|numeric|min:{$min}|max:{$max}";
    }

    public static function date($beforeOrEqual = true)
    {
        $rule = 'required|date';
        if ($beforeOrEqual) {
            $rule .= '|before_or_equal:today';
        }
        return $rule;
    }

    public static function batchNumber($unique = true, $except = null)
    {
        $rule = 'required|string|max:255';
        if ($unique) {
            $rule .= '|unique:process_batches,batch_number';
            if ($except) {
                $rule .= ',' . $except;
            }
        }
        return $rule;
    }

    public static function status()
    {
        return 'required|in:pending,processing,completed,cancelled';
    }

    public static function energySource()
    {
        return 'required|in:biogas,grid_electricity,pyrolysis_oil';
    }

    public static function quantity($min = 0.01, $max = 10000)
    {
        return "required|numeric|min:{$min}|max:{$max}";
    }

    public static function price($min = 0.01, $max = 100000)
    {
        return "required|numeric|min:{$min}|max:{$max}";
    }

    public static function qualityGrade()
    {
        return 'nullable|numeric|min:0|max:100';
    }

    public static function notes($max = 1000)
    {
        return "nullable|string|max:{$max}";
    }

    public static function productType()
    {
        return 'required|string|max:255';
    }

    public static function unit()
    {
        return 'required|string|max:50';
    }

    public static function customerName()
    {
        return 'nullable|string|max:255';
    }

    public static function reason()
    {
        return 'required|string|max:255';
    }

    public static function adjustmentType()
    {
        return 'required|in:add,subtract';
    }
}
