<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Users\UsersController;

Route::get('/admin/users', [UsersController::class, 'main'])->name("Backend_Users");
Route::get('/admin/edit_user/{id}', [UsersController::class, 'user_edit'])->name('Backend_User_Edit');
