<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Money_Manager\CategoryController;
Route::get('/category', [CategoryController::class, 'main'])->name('Backend_Money_Manager_Category');
