<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Authentication\LoginController;
Route::get('/admin/login', [LoginController::class, 'main'])->name("Login");
Route::get('/admin/logout', [LoginController::class, 'logout'])->name('Logout');
Route::match(['post', 'get'], 'admin/login/loginAction', [LoginController::class, 'loginAction']);
