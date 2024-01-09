<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Media\TelegramWebhookController;
use App\Http\Middleware\VerifyCsrfToken;
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
Route::match(['post', 'get'],'/telegram_webhook', [TelegramWebhookController::class, 'main'])->withoutMiddleware([VerifyCsrfToken::class]);
