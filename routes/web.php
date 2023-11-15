<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\RouteGroup;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Ads\Ads1Controller;
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
Route::group(['middleware'=>'IsLogin'], function(){
    //Route::get('/login',[UsersController::class,'index'])->name('login');
    //Route::post('/login/submit',[UsersController::class,'login_submit'])->name('login-submit');
    Route::get('/login', [LoginController::class, 'main'])->name("Login");
});
Route::get('/', [HomeController::class, 'main'])->name('Home');
Route::get('/home', [HomeController::class, 'main'])->name('Home');
//Route::get('/login', [LoginController::class, 'main'])->name('Login');
//Route::get('/register', [LoginController::class, 'main'])->name('Login');
