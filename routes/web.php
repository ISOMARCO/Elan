<?php

use App\Http\Controllers\Frontend\Home\HomeController;
use App\Http\Controllers\Media\TelegramWebhookController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Backend\IsLogin as Backend_IsLogin;
use App\Http\Controllers\Backend\Home\HomeController as BackendHomeController;
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
Route::middleware([Backend_IsLogin::class])->get('/admin/home', [BackendHomeController::class, 'main'])->name('Admin_Home');
Route::middleware([Backend_IsLogin::class])->get('/admin/', [BackendHomeController::class, 'main'])->name('Admin_Home');
