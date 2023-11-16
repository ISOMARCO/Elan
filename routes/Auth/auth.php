<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
Route::get('/register', [RegisterController::class, 'main'])->name('Register');
