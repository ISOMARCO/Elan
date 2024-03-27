<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Money_Manager\CategoryController;
use App\Http\Controllers\Backend\Money_Manager\GoodsController;

Route::get('/', [CategoryController::class, 'main'])->name('Backend.Money_Manager_Category');
Route::get('/goods', [GoodsController::class, 'main'])->name('Backend.Money_Manager_Goods');
Route::post('/goods/createAction', [GoodsController::class, 'createAction'])->name('Backend.Money_Manager_CreateAction');
