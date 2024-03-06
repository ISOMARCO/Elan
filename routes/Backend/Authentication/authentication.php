<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Authentication\LoginController;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Middleware\Backend\IsLogin;


Route::get('/login', [LoginController::class, 'main'])->name("Backend.Login");
Route::get('/logout', [LoginController::class, 'logout'])->name('Backend.Logout');
Route::match(['post', 'get'], '/login/loginAction', [LoginController::class, 'loginAction'])->name('Backend.LoginAction');
Route::match(['post', 'get'], '/api/login/loginAction', [LoginController::class, 'loginAction'])->name('Api.Backend.LoginAction')->withoutMiddleware([VerifyCsrfToken::class, IsLogin::class]);
