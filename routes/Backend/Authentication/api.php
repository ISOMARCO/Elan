<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Authentication\LoginController;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Middleware\Backend\IsLogin;


Route::match(['post', 'get'], '/login/loginAction', [LoginController::class, 'loginAction'])->name('Api.Backend.LoginAction');
