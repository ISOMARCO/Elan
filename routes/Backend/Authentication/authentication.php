<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Authentication\LoginController;
Route::get('/admin/login/aa', [LoginController::class, 'main'])->name("Login");
