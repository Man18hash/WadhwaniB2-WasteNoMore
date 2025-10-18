<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProcessBatch;
use App\Models\BatchOutput;
use App\Http\Requests\StoreProcessBatchRequest;
use App\Http\Requests\UpdateProcessBatchRequest;
use App\Http\Requests\StoreBatchOutputRequest;
use App\Http\Requests\UpdateBatchOutputRequest;
use Carbon\Carbon;

class AnaerobicDigestionController extends Controller
{
    public function index(Request $request)
    {
        $query = ProcessBatch::where('process_type', 'anaerobic_digestion');
        
        // Apply filters
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
        
        return view('anaerobic-digestion.index', compact('batches'));
    }
    
    public function create()
    {
        return view('anaerobic-digestion.create');
    }
    
    public function store(StoreProcessBatchRequest $request)
    {
        ProcessBatch::create([
            ...$request->validated(),
            'process_type' => 'anaerobic_digestion',
            'status' => 'pending'
        ]);
        
        return redirect()->route('anaerobic-digestion.index')
            ->with('success', 'Anaerobic digestion batch created successfully!');
    }
    
    public function show(ProcessBatch $anaerobicDigestion)
    {
        $anaerobicDigestion->load('batchOutputs');
        return view('anaerobic-digestion.show', compact('anaerobicDigestion'));
    }
    
    public function edit(ProcessBatch $anaerobicDigestion)
    {
        return view('anaerobic-digestion.edit', compact('anaerobicDigestion'));
    }
    
    public function update(UpdateProcessBatchRequest $request, ProcessBatch $anaerobicDigestion)
    {
        $anaerobicDigestion->update($request->validated());
        
        return redirect()->route('anaerobic-digestion.index')
            ->with('success', 'Anaerobic digestion batch updated successfully!');
    }
    
    public function destroy(ProcessBatch $anaerobicDigestion)
    {
        $anaerobicDigestion->delete();
        
        return redirect()->route('anaerobic-digestion.index')
            ->with('success', 'Anaerobic digestion batch deleted successfully!');
    }
    
    public function storeOutput(StoreBatchOutputRequest $request, ProcessBatch $batch)
    {
        BatchOutput::create([
            ...$request->validated(),
            'batch_id' => $batch->id
        ]);
        
        return redirect()->route('anaerobic-digestion.show', $batch)
            ->with('success', 'Output recorded successfully!');
    }
    
    public function updateOutput(UpdateBatchOutputRequest $request, ProcessBatch $batch, BatchOutput $output)
    {
        $output->update($request->validated());
        
        return redirect()->route('anaerobic-digestion.show', $batch)
            ->with('success', 'Output updated successfully!');
    }
    
    public function destroyOutput(ProcessBatch $batch, BatchOutput $output)
    {
        $output->delete();
        
        return redirect()->route('anaerobic-digestion.show', $batch)
            ->with('success', 'Output deleted successfully!');
    }
}
