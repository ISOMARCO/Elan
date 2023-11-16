<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\RegisterController;
use App\Http\Controllers\Authentication\LoginController;

Route::get('/register', [RegisterController::class, 'main'])->name('Register');
Route::match(['post', 'get'], '/login/loginAction', [LoginController::class, 'loginAction']);
Route::get('/login', [LoginController::class, 'main'])->name('Login');
