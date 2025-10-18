<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WasteEntryController;
use App\Http\Controllers\AnaerobicDigestionController;
use App\Http\Controllers\BSFLarvaeController;
use App\Http\Controllers\ActivatedCarbonController;
use App\Http\Controllers\PaperPackagingController;
use App\Http\Controllers\PyrolysisController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\EnergyController;
use App\Http\Controllers\EnvironmentalImpactController;
use App\Http\Controllers\AIAnalyticsController;

// Redirect root to dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Waste Entries
Route::resource('waste-entries', WasteEntryController::class);
Route::get('/waste-entries/export/excel', [WasteEntryController::class, 'exportExcel'])->name('waste-entries.export.excel');

// Anaerobic Digestion
Route::resource('anaerobic-digestion', AnaerobicDigestionController::class);
Route::post('/anaerobic-digestion/{batch}/outputs', [AnaerobicDigestionController::class, 'storeOutput'])->name('anaerobic-digestion.outputs.store');
Route::put('/anaerobic-digestion/{batch}/outputs/{output}', [AnaerobicDigestionController::class, 'updateOutput'])->name('anaerobic-digestion.outputs.update');
Route::delete('/anaerobic-digestion/{batch}/outputs/{output}', [AnaerobicDigestionController::class, 'destroyOutput'])->name('anaerobic-digestion.outputs.destroy');

// BSF Larvae
Route::resource('bsf-larvae', BSFLarvaeController::class);
Route::post('/bsf-larvae/{batch}/outputs', [BSFLarvaeController::class, 'storeOutput'])->name('bsf-larvae.outputs.store');
Route::put('/bsf-larvae/{batch}/outputs/{output}', [BSFLarvaeController::class, 'updateOutput'])->name('bsf-larvae.outputs.update');
Route::delete('/bsf-larvae/{batch}/outputs/{output}', [BSFLarvaeController::class, 'destroyOutput'])->name('bsf-larvae.outputs.destroy');

// Activated Carbon
Route::resource('activated-carbon', ActivatedCarbonController::class);
Route::post('/activated-carbon/{batch}/outputs', [ActivatedCarbonController::class, 'storeOutput'])->name('activated-carbon.outputs.store');
Route::put('/activated-carbon/{batch}/outputs/{output}', [ActivatedCarbonController::class, 'updateOutput'])->name('activated-carbon.outputs.update');
Route::delete('/activated-carbon/{batch}/outputs/{output}', [ActivatedCarbonController::class, 'destroyOutput'])->name('activated-carbon.outputs.destroy');

// Paper Packaging
Route::resource('paper-packaging', PaperPackagingController::class);
Route::post('/paper-packaging/{batch}/outputs', [PaperPackagingController::class, 'storeOutput'])->name('paper-packaging.outputs.store');
Route::put('/paper-packaging/{batch}/outputs/{output}', [PaperPackagingController::class, 'updateOutput'])->name('paper-packaging.outputs.update');
Route::delete('/paper-packaging/{batch}/outputs/{output}', [PaperPackagingController::class, 'destroyOutput'])->name('paper-packaging.outputs.destroy');

// Pyrolysis
Route::resource('pyrolysis', PyrolysisController::class);
Route::post('/pyrolysis/{batch}/outputs', [PyrolysisController::class, 'storeOutput'])->name('pyrolysis.outputs.store');
Route::put('/pyrolysis/{batch}/outputs/{output}', [PyrolysisController::class, 'updateOutput'])->name('pyrolysis.outputs.update');
Route::delete('/pyrolysis/{batch}/outputs/{output}', [PyrolysisController::class, 'destroyOutput'])->name('pyrolysis.outputs.destroy');

// Inventory
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::post('/inventory/adjust', [InventoryController::class, 'adjust'])->name('inventory.adjust');
Route::get('/inventory/history', [InventoryController::class, 'history'])->name('inventory.history');

// Sales
Route::resource('sales', SalesController::class);
Route::get('/sales/export/excel', [SalesController::class, 'exportExcel'])->name('sales.export.excel');

// Energy
Route::resource('energy', EnergyController::class);
Route::get('/energy/monthly-report', [EnergyController::class, 'monthlyReport'])->name('energy.monthly-report');

// Environmental Impact
Route::resource('environmental-impact', EnvironmentalImpactController::class);
Route::get('/environmental-impact/generate-report', [EnvironmentalImpactController::class, 'generateReport'])->name('environmental-impact.generate-report');

// AI Analytics
Route::get('/ai-analytics', [AIAnalyticsController::class, 'index'])->name('ai-analytics.index');
Route::get('/ai-analytics/batch-scheduling', [AIAnalyticsController::class, 'batchScheduling'])->name('ai-analytics.batch-scheduling');
Route::get('/ai-analytics/yield-prediction', [AIAnalyticsController::class, 'yieldPrediction'])->name('ai-analytics.yield-prediction');
Route::get('/ai-analytics/quality-assessment', [AIAnalyticsController::class, 'qualityAssessment'])->name('ai-analytics.quality-assessment');
Route::post('/ai-analytics/quality-assessment/analyze', [AIAnalyticsController::class, 'analyzeImage'])->name('ai-analytics.analyze-image');
