<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Money_Manager\CategoryController;
use App\Http\Controllers\Backend\Ads\GoodsController;

Route::get('/', [CategoryController::class, 'main'])->name('Backend.Money_Manager_Category');
Route::get('/goods', [GoodsController::class, 'main'])->name('Backend.Money_Manager_Goods');
