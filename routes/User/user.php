<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\SettingController;

Route::get('/user_setting', [SettingController::class, 'main'])->name('user_setting');
