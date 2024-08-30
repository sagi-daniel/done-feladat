<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\StudentController;

use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    // Class routes
    Route::get('classes', [ClassController::class, 'index'])->name('classes.index');
    Route::post('classes', [ClassController::class, 'store'])->name('classes.store');
    Route::get('classes/{id}', [ClassController::class, 'show'])->name('classes.show');
    Route::put('classes/{id}', [ClassController::class, 'update'])->name('classes.update');
    Route::delete('classes/{id}', [ClassController::class, 'destroy'])->name('classes.destroy');

    // Student routes
    Route::get('students', [StudentController::class, 'index'])->name('students.index');
    Route::post('students', [StudentController::class, 'store'])->name('students.store');
    Route::get('students/{id}', [StudentController::class, 'show'])->name('students.show');
    Route::put('students/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
});
