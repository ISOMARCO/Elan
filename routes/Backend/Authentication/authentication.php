<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Authentication\LoginController;
Route::get('/login', [LoginController::class, 'main'])->name("Backend_Login");
Route::get('/logout', [LoginController::class, 'logout'])->name('Backend_Logout');
Route::match(['post', 'get'], '/login/loginAction', [LoginController::class, 'loginAction'])->name('Backend_LoginAction');
