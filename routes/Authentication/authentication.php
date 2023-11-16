<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\RegisterController;


Route::get('/register', [RegisterController::class, 'main'])->name('Register');
