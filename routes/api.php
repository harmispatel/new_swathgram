<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\LoginController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login',[LoginController::class,'login'])->name('login');
Route::post('/forgot-password',[LoginController::class,'forgotPassword'])->name('forgots');
Route::get('/reset-password/{token}', [LoginController::class, 'showResetPasswordForm'])->name('password.get');
Route::post('/reset-password', [LoginController::class, 'ResetPasswordForm'])->name('password.post');






