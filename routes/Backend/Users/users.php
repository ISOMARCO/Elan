<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Users\UsersController;

Route::get('/admin/users', [UsersController::class, 'main'])->name("Users");
