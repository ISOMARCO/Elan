<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Users\UsersController;
use App\Http\Controllers\Backend\Users\TimelineController;

Route::get('/', [UsersController::class, 'main'])->name("Backend.Users");
Route::match(['post', 'get'], '/saveChangesAction', [UsersController::class, 'saveChangesAction'])->name('Backend.Users_SaveChangesAction');
Route::match(['post', 'get'], '/changeUserStatusAction', [UsersController::class, 'changeUserStatusAction'])->name('Backend.Users_ChangeUserStatusAction');
Route::get('/timeline', [TimelineController::class, 'main'])->name('Backend.Users_Timeline');
Route::get('/deactive', [UsersController::class, 'deactive'])->name('Backend.Users_Deactive');
Route::match(['post', 'get'], '/createAction', [UsersController::class, 'createAction'])->name('Backend.Users_Create');
