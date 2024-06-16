<?php

use App\Http\Controllers\RowsController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth.basic'])->group(function () {
    Route::get('/', [UploadController::class, 'index'])->name('upload.index');
    Route::post('upload', [UploadController::class, 'upload'])->name('upload.upload');

    Route::get('rows', [RowsController::class, 'index'])->name('rows.index');
});

