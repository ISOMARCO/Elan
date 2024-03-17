<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Ads\CategoryController;

Route::get('/category', [CategoryController::class, 'main'])->name("Backend.Ads_Category");
