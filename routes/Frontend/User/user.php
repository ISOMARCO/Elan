<?php

use App\Http\Controllers\Frontend\User\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/user_setting', [SettingController::class, 'main'])->name('Frontend.UserSetting');
