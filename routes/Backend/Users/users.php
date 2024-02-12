<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Users\UsersController;

Route::get('/admin/users', [UsersController::class, 'main'])->name("Backend_Users");
Route::match(['post', 'get'], 'admin/users/saveChangesAction', [UsersController::class, 'saveChangesAction'])->name('Backend_SaveChangesAction');
