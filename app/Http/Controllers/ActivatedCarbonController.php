<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProcessBatch;
use App\Models\BatchOutput;

class ActivatedCarbonController extends Controller
{
    public function index(Request $request)
    {
        $query = ProcessBatch::where('process_type', 'activated_carbon');
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $batches = $query->with('batchOutputs')->orderBy('start_date', 'desc')->paginate(15);
        
        return view('activated-carbon.index', compact('batches'));
    }
    
    public function create()
    {
        return view('activated-carbon.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'batch_number' => 'required|string|max:255|unique:process_batches',
            'input_weight_kg' => 'required|numeric|min:0.01',
            'input_type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'expected_completion_date' => 'nullable|date|after:start_date',
            'description' => 'nullable|string|max:1000'
        ]);
        
        ProcessBatch::create([
            'batch_number' => $request->batch_number,
            'process_type' => 'activated_carbon',
            'input_weight_kg' => $request->input_weight_kg,
            'input_type' => $request->input_type,
            'start_date' => $request->start_date,
            'expected_completion_date' => $request->expected_completion_date,
            'status' => 'pending',
            'description' => $request->description
        ]);
        
        return redirect()->route('activated-carbon.index')
            ->with('success', 'Activated carbon batch created successfully!');
    }
    
    public function show(ProcessBatch $activatedCarbon)
    {
        $activatedCarbon->load('batchOutputs');
        return view('activated-carbon.show', compact('activatedCarbon'));
    }
    
    public function edit(ProcessBatch $activatedCarbon)
    {
        return view('activated-carbon.edit', compact('activatedCarbon'));
    }
    
    public function update(Request $request, ProcessBatch $activatedCarbon)
    {
        $request->validate([
            'batch_number' => 'required|string|max:255|unique:process_batches,batch_number,' . $activatedCarbon->id,
            'input_weight_kg' => 'required|numeric|min:0.01',
            'input_type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'expected_completion_date' => 'nullable|date|after:start_date',
            'actual_completion_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'description' => 'nullable|string|max:1000'
        ]);
        
        $activatedCarbon->update($request->all());
        
        return redirect()->route('activated-carbon.index')
            ->with('success', 'Activated carbon batch updated successfully!');
    }
    
    public function destroy(ProcessBatch $activatedCarbon)
    {
        $activatedCarbon->delete();
        
        return redirect()->route('activated-carbon.index')
            ->with('success', 'Activated carbon batch deleted successfully!');
    }
    
    public function storeOutput(Request $request, ProcessBatch $batch)
    {
        $request->validate([
            'output_type' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0.01',
            'unit' => 'required|string|max:50',
            'is_expected' => 'boolean',
            'output_date' => 'nullable|date',
            'quality_grade' => 'nullable|numeric|min:0|max:100',
            'remarks' => 'nullable|string|max:1000'
        ]);
        
        BatchOutput::create([
            'batch_id' => $batch->id,
            'output_type' => $request->output_type,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'is_expected' => $request->boolean('is_expected'),
            'output_date' => $request->output_date,
            'quality_grade' => $request->quality_grade,
            'remarks' => $request->remarks
        ]);
        
        return redirect()->route('activated-carbon.show', $batch)
            ->with('success', 'Output recorded successfully!');
    }
    
    public function updateOutput(Request $request, ProcessBatch $batch, BatchOutput $output)
    {
        $request->validate([
            'output_type' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0.01',
            'unit' => 'required|string|max:50',
            'is_expected' => 'boolean',
            'output_date' => 'nullable|date',
            'quality_grade' => 'nullable|numeric|min:0|max:100',
            'remarks' => 'nullable|string|max:1000'
        ]);
        
        $output->update($request->all());
        
        return redirect()->route('activated-carbon.show', $batch)
            ->with('success', 'Output updated successfully!');
    }
    
    public function destroyOutput(ProcessBatch $batch, BatchOutput $output)
    {
        $output->delete();
        
        return redirect()->route('activated-carbon.show', $batch)
            ->with('success', 'Output deleted successfully!');
    }
}
