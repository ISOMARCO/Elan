<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Ads\CategoryController;
use App\Http\Controllers\Backend\Ads\CategorySettingsController;

Route::get('/category', [CategoryController::class, 'main'])->name("Backend.Ads_Category");
Route::get('/categorySettings', [CategorySettingsController::class, 'main'])->name('Backend.Ads_CategorySettings');
