<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Users\UsersController;
use App\Http\Controllers\Backend\Users\TimelineController;

Route::get('/users', [UsersController::class, 'main'])->name("Backend_Users");
Route::match(['post', 'get'], '/users/saveChangesAction', [UsersController::class, 'saveChangesAction'])->name('Backend_SaveChangesAction');
Route::match(['post', 'get'], '/users/changeUserStatusAction', [UsersController::class, 'changeUserStatusAction'])->name('Backend_ChangeUserStatusAction');
Route::get('/users/timeline', [TimelineController::class, 'main'])->name('Backend_Users_Timeline');
Route::get('/users/deactive', [UsersController::class, 'deactive'])->name('Backend_Deactive_Users');
