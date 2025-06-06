<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\api\CustomController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


        Route::post('/login',[LoginController::class,'login'])->name('login');
        Route::post('/forgot-password',[LoginController::class,'forgotPassword'])->name('forgots');
        Route::get('/reset-password/{token}/{email}', [LoginController::class, 'showResetPasswordForm'])->name('password.get');
        Route::post('/reset-password', [LoginController::class, 'ResetPasswordForm'])->name('password.post');

        Route::middleware(['auth:api'])->group(function () {
                Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
                Route::get('/get', [LoginController::class, 'get'])->name('get');
                Route::post('/profile/update', [LoginController::class, 'profileupdate'])->name('profile.update');
        });


     Route::post('/CommanData',[CustomController::class,'CommanData']);
     Route::post('/getTestsByProfile',[CustomController::class,'getTestsByProfile'])->name('getTestsByProfile');
     Route::post('/PatientCreate',[CustomController::class,'PatientCreate'])->middleware('auth:sanctum');


    Route::post('/changePassword', [LoginController::class, 'changePassword'])->middleware('auth:sanctum');








