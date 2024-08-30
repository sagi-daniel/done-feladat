<?php

use App\Http\Controllers\ClassController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::get('classes', [ClassController::class, 'index'])->name('classes.index');
    Route::post('classes', [ClassController::class, 'store'])->name('classes.store');
    Route::get('classes/{id}', [ClassController::class, 'show'])->name('classes.show');
    Route::put('classes/{id}', [ClassController::class, 'update'])->name('classes.update');
    Route::delete('classes/{id}', [ClassController::class, 'destroy'])->name('classes.destroy');
});
