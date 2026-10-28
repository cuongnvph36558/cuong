<?php

use App\Http\Controllers\Admin\HomeContentController as AdminHomeContentController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::post('leads', [LeadController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('leads.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('leads', [AdminLeadController::class, 'index'])->name('leads.index');
    Route::get('leads/export', [AdminLeadController::class, 'export'])->name('leads.export');
    Route::delete('leads/{lead}', [AdminLeadController::class, 'destroy'])->name('leads.destroy');

    Route::get('home-content', [AdminHomeContentController::class, 'edit'])->name('home-content.edit');
    Route::put('home-content', [AdminHomeContentController::class, 'update'])->name('home-content.update');
    Route::post('home-content/reset', [AdminHomeContentController::class, 'reset'])->name('home-content.reset');
    Route::post('home-content/upload', [AdminHomeContentController::class, 'uploadImage'])->name('home-content.upload');
});

require __DIR__.'/settings.php';
