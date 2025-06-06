<?php

use App\Http\Controllers\labTechnician\CampController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\labTechnician\PatientController;
use App\Http\Controllers\labTechnician\PatientReportController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'lab_technician'], function ()
{
    Route::middleware(['auth:lab_technician'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('lab_technician.dashboard');
    
        Route::controller(CampController::class)->group(function () {
            Route::get('camps','index')->name('lab_technician.camp');
            Route::get('camp/create','create')->name('lab_technician.camp.create');
            Route::post('camp/store','store')->name('lab_technician.camp.store');
            Route::get('camp/edit/{id}','edit')->name('lab_technician.camp.edit');
            Route::post('camp/update','update')->name('lab_technician.camp.update');
            Route::post('camp/delete','delete')->name('lab_technician.camp.delete');

            // Route::post('camp/lab-get-devices', 'getDevices')->name('lab.organization.devices');
        });

        Route::controller(PatientController::class)->group(function () {
            Route::get('patients','index')->name('lab_technician.patient');
            Route::get('patient/create','create')->name('lab_technician.patient.create');
            Route::post('patient/store','store')->name('lab_technician.patient.store');
            Route::post('patient/delete','delete')->name('lab_technician.patient.delete');
            
            Route::post('patient/get-tests-by-profile', 'getTestsByProfile')->name('lab_technician.tests.profiles');
        });

        Route::controller(PatientReportController::class)->group(function () {
            Route::get('patients/report','index')->name('lab_technician.patient.report');
            
        });
    });
});