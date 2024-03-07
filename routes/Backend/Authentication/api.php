<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Authentication\LoginController;


Route::match(['post', 'get'], '/login/loginAction', [LoginController::class, 'loginAction'])->name('Api.Backend.LoginAction');
