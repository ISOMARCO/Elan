<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Authentication\LoginController;
Route::get('/admin/login', [LoginController::class, 'main'])->name("Login");
Route::match(['post', 'get'], 'admin/login/loginAction', [LoginController::class, 'loginAction']);
