<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Authentication\LoginController;


Route::match(['post'], '/login/loginAction', [LoginController::class, 'loginAction'])->name('Backend.Api.LoginAction');
