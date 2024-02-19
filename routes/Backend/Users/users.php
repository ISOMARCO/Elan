<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Users\UsersController;
use App\Http\Controllers\Backend\Users\TimelineController;

Route::get('/admin/users', [UsersController::class, 'main'])->name("Backend_Users");
Route::match(['post', 'get'], 'admin/users/saveChangesAction', [UsersController::class, 'saveChangesAction'])->name('Backend_SaveChangesAction');
Route::match(['post', 'get'], '/admin/users/changeUserStatusAction', [UsersController::class, 'changeUserStatusAction'])->name('Backend_ChangeUserStatusAction');
Route::get('/admin/users/timeline', [TimelineController::class, 'main'])->name('Backend_Users_Timeline');
Route::get('/admin/users/deactive', [UsersController::class, 'deactive'])->name('Backend_Deactive_Users');
