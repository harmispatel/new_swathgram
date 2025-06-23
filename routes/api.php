<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\api\CustomController;
use Illuminate\Support\Facades\Artisan;


Route::get('config-clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    dd("Cache is cleared");
});

Route::post('/login',[LoginController::class,'login'])->name('login');
Route::post('/forgotPassword',[LoginController::class,'forgotPassword'])->name('forgots');
Route::get('/reset-password/{token}/{email}', [LoginController::class, 'showResetPasswordForm'])->name('password.get');
Route::post('/reset-password', [LoginController::class, 'ResetPasswordForm'])->name('password.post');

// Route::middleware(['auth:api'])->group(function () {
Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', [LoginController::class, 'logout']);
        Route::get('/userProfile', [LoginController::class, 'get']);
        Route::post('/userProfileUpdate', [LoginController::class, 'profileupdate']);
        
        Route::post('/patientRegister',[CustomController::class,'patientRegister']);
        Route::post('/patientUpdate',[CustomController::class,'patientUpdate']);
        Route::get('/patientList',[CustomController::class,'patientlist']);
        Route::post('/getTestResult',[CustomController::class,'getTestResult']);
        Route::post('/deleteTestResult',[CustomController::class,'deleteTestResults']);
        Route::post('/changePassword', [LoginController::class, 'changePassword']);
        Route::get('/campaList',[CustomController::class,'camplist']);
        Route::get('/report',[CustomController::class,'report']);
        Route::post('/patientByReport',[CustomController::class,'patientByReport']);
        Route::get('/qcData',[CustomController::class,'qcdata']);

        Route::post('/updatePatient',[CustomController::class,'updatepatient']);
        Route::delete('/deletePatient', [CustomController::class, 'deletePatient']);

});

Route::post('problem-report', [CustomController::class, 'problemReport'])->middleware('auth:sanctum');
Route::get('/commanData',[CustomController::class,'CommanData']);
Route::get('/getTestsByProfile',[CustomController::class,'getTestsByProfile']);
Route::get('/packageList',[CustomController::class,'packagelist']);
Route::post('/search',[CustomController::class,'searchpatient']);

Route::get('/packageData',[CustomController::class,'package']);

Route::get('/support-departments',[CustomController::class,'Supportdepartments']);
Route::post('/support-subdepartments',[CustomController::class,'SupportSubdepartments']);

Route::post('/updatetTestResult',[CustomController::class,'updatetestresult']); 

