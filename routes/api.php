<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\api\CustomController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


        Route::post('/login',[LoginController::class,'login'])->name('login');
        Route::post('/forgotPassword',[LoginController::class,'forgotPassword'])->name('forgots');
        Route::get('/reset-password/{token}/{email}', [LoginController::class, 'showResetPasswordForm'])->name('password.get');
        Route::post('/reset-password', [LoginController::class, 'ResetPasswordForm'])->name('password.post');

        // Route::middleware(['auth:api'])->group(function () {
       Route::middleware('auth:sanctum')->group(function () {
                Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
                Route::get('/userProfile', [LoginController::class, 'get'])->name('get');
                Route::post('/userProfileUpdate', [LoginController::class, 'profileupdate'])->name('profile.update');
        });


     Route::get('/commanData',[CustomController::class,'CommanData']);
     Route::get('/getTestsByProfile',[CustomController::class,'getTestsByProfile'])->name('getTestsByProfile');
     Route::post('/patientRegister',[CustomController::class,'PatientCreate'])->middleware('auth:sanctum');

    Route::get('/patientList',[CustomController::class,'patientlist'])->middleware('auth:sanctum');
    Route::post('/changePassword', [LoginController::class, 'changePassword'])->middleware('auth:sanctum');
    Route::get('/campaList',[CustomController::class,'camplist']);
    Route::get('/packageList',[CustomController::class,'packagelist']);
    Route::post('/search',[CustomController::class,'searchpatient']);
    Route::get('/qcData',[CustomController::class,'qcdata']);
    
    Route::get('/packageData',[CustomController::class,'package']);
    Route::get('/amount',[CustomController::class,'amount']);







