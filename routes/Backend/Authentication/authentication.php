<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Authentication\LoginController;
Route::get('/admin/login', [LoginController::class, 'main'])->name("Backend_Login");
Route::get('/admin/logout', [LoginController::class, 'logout'])->name('Backend_Logout');
Route::match(['post', 'get'], 'admin/login/loginAction', [LoginController::class, 'loginAction'])->name('Backend_LoginAction');
