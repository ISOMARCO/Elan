<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Authentication\LoginController;
Route::get('/login', [LoginController::class, 'main'])->name("Login");
