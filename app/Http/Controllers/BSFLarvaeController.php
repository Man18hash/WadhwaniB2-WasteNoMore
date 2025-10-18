<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProcessBatch;
use App\Models\BatchOutput;
use Carbon\Carbon;

class BSFLarvaeController extends Controller
{
    public function index(Request $request)
    {
        $query = ProcessBatch::where('process_type', 'bsf_larvae');
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('start_date', '<=', $request->date_to);
        }
        
        $batches = $query->with('batchOutputs')->orderBy('start_date', 'desc')->paginate(15);
        
        return view('bsf-larvae.index', compact('batches'));
    }
    
    public function create()
    {
        return view('bsf-larvae.create');
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
            'process_type' => 'bsf_larvae',
            'input_weight_kg' => $request->input_weight_kg,
            'input_type' => $request->input_type,
            'start_date' => $request->start_date,
            'expected_completion_date' => $request->expected_completion_date,
            'status' => 'pending',
            'description' => $request->description
        ]);
        
        return redirect()->route('bsf-larvae.index')
            ->with('success', 'BSF larvae cycle created successfully!');
    }
    
    public function show(ProcessBatch $bsfLarvae)
    {
        $bsfLarvae->load('batchOutputs');
        return view('bsf-larvae.show', compact('bsfLarvae'));
    }
    
    public function edit(ProcessBatch $bsfLarvae)
    {
        return view('bsf-larvae.edit', compact('bsfLarvae'));
    }
    
    public function update(Request $request, ProcessBatch $bsfLarvae)
    {
        $request->validate([
            'batch_number' => 'required|string|max:255|unique:process_batches,batch_number,' . $bsfLarvae->id,
            'input_weight_kg' => 'required|numeric|min:0.01',
            'input_type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'expected_completion_date' => 'nullable|date|after:start_date',
            'actual_completion_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'description' => 'nullable|string|max:1000'
        ]);
        
        $bsfLarvae->update($request->all());
        
        return redirect()->route('bsf-larvae.index')
            ->with('success', 'BSF larvae cycle updated successfully!');
    }
    
    public function destroy(ProcessBatch $bsfLarvae)
    {
        $bsfLarvae->delete();
        
        return redirect()->route('bsf-larvae.index')
            ->with('success', 'BSF larvae cycle deleted successfully!');
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
        
        return redirect()->route('bsf-larvae.show', $batch)
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
        
        return redirect()->route('bsf-larvae.show', $batch)
            ->with('success', 'Output updated successfully!');
    }
    
    public function destroyOutput(ProcessBatch $batch, BatchOutput $output)
    {
        $output->delete();
        
        return redirect()->route('bsf-larvae.show', $batch)
            ->with('success', 'Output deleted successfully!');
    }
}
