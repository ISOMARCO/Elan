<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Users\UsersController;
use App\Http\Controllers\Backend\Users\TimelineController;

Route::get('/admin/users', [UsersController::class, 'main'])->name("Backend_Users");
Route::match(['post', 'get'], 'admin/users/saveChangesAction', [UsersController::class, 'saveChangesAction']);
Route::match(['post', 'get'], '/admin/users/changeUserStatusAction', [UsersController::class, 'changeUserStatusAction']);
Route::get('/admin/users/timeline', [TimelineController::class, 'main'])->name('Backend_Users_Timeline');
