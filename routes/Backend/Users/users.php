<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Users\UsersController;

Route::get('/admin/users', [UsersController::class, 'main'])->name("Backend_Users");
Route::get('/admin/user_edit/', function() {
    return view('Backend.Users.user_edit');
});
