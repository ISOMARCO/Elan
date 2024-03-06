<?php

use App\Http\Controllers\Frontend\Home\HomeController;
use App\Http\Controllers\Media\TelegramWebhookController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Backend\IsLogin as Backend_IsLogin;
use App\Http\Controllers\Backend\Home\HomeController as BackendHomeController;
use Illuminate\Support\Facades\Mail;
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
Route::get('/', [HomeController::class, 'main'])->name('Frontend.Home');
Route::redirect('/home', '/');
Route::match(['post', 'get'],'/telegram_webhook', [TelegramWebhookController::class, 'main'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::middleware([Backend_IsLogin::class])->get('/admin/', [BackendHomeController::class, 'main'])->name('Backend.Home');
Route::redirect('/admin/home', '/admin/');
Route::get('/pusher', function(){
    return view('pusher');
});
Route::get('/getPusherAppKey', function () {
    return response()->json([
        'pusher_app_key' => env('PUSHER_APP_KEY', '71182114e39989428ba8')
    ]);
});

Route::get('/sendEmail', function(){
    $userEmail = 'ismayilnagiyev100@gmail.com';
    $userName = 'Recipient Name';
    Mail::raw('Welcome to our website!', function($message) use ($userEmail, $userName) {
        $message->to($userEmail)->subject('Welcome '.$userName)->from('info@iso.com.az', 'Your Name');
    });
});
