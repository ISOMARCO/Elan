<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Money_Manager\CategoryController;
Route::get('/', [CategoryController::class, 'main'])->name('Backend.Money_Manager_Category');
