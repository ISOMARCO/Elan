<?php

use App\Http\Controllers\Frontend\Authentication\LoginController;
use App\Http\Controllers\Frontend\Authentication\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [RegisterController::class, 'main'])->name('Register');
Route::match(['post', 'get'], '/login/loginAction', [LoginController::class, 'loginAction'])->name("Frontend.LoginAction");
Route::get('/login', [LoginController::class, 'main'])->name('Login');
Route::match(['post', 'get'], '/register/registerAction', [RegisterController::class, 'registerAction'])->name('Frontend.RegisterAction');
Route::get('/logout', [LoginController::class, 'logout'])->name('Logout');
