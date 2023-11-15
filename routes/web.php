<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [HomeController::class, 'main'])->name('Home');
Route::get('/home', [HomeController::class, 'main'])->name('Home');
Route::get('/login', [LoginController::class, 'main'])->name('Login');
Route::post('/login/loginAction', [LoginController::class, 'loginAction']);
Route::get('/register', [RegisterController::class, 'main'])->name('Register');
