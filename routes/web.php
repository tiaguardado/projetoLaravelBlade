<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showRequestForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

Route::get('/', function () {
    return view('welcome');
})->name('dashboard');

Route::get('/todo', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

// Grupo de rotas restritas
Route::group(['middleware' => 'auth'], function () {


    Route::get('/index-user', [UserController::class, 'index'])->name('user.index')->middleware('can:ViewAny,App\Models\User');
    Route::get('/show-user/{user}', [UserController::class, 'show'])->name('user.show')->middleware('can:View,user');
    Route::get('/create-user', [UserController::class, 'create'])->name('user.create')->middleware('can:Create,App\Models\User');
    Route::post('/store-user', [UserController::class, 'store'])->name('user.store')->middleware('can:Create,App\Models\User');
    Route::get('/edit-user/{user}', [UserController::class, 'edit'])->name('user.edit')->middleware('can:Update,user');
    Route::put('/update-user/{user}', [UserController::class, 'update'])->name('user.update')->middleware('can:Update,user');
    Route::delete('/destroy-user/{user}', [UserController::class, 'destroy'])->name('user.destroy')->middleware('can:Delete,user');

    Route::get('/generate-pdf-user/{user}', [UserController::class, 'generatePdf'])->name('user.generate-pdf')->middleware('can:View,user');
    Route::get('/generate-pdf-user', [UserController::class, 'generatePdfUsers'])->name('user.generate-pdf-users')->middleware('can:ViewAny,App\Models\User');
});


