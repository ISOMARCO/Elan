<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Media\TelegramWebhookController;
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
Route::post('/login/loginAction', [LoginController::class, 'loginAction']);
Route::get('/login/loginAction', [LoginController::class, 'loginAction']);
Route::get('/login', [LoginController::class, 'main'])->name('Login');
Route::get('/register', [RegisterController::class, 'main'])->name('Register');
//Route::get('/telegram_webhook', [TelegramWebhookController::class, 'main']);
Route::post('/telegram_webhook', [TelegramWebhookController::class, 'main'])->withoutMiddleware(['VerifyCsrfToken']);
