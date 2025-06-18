<?php
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsPathologist;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\pathologist\LabTechnicianController;
use App\Http\Controllers\pathologist\CampController;
use App\Http\Controllers\pathologist\PatientController;
use App\Http\Controllers\pathologist\PatientReportController;
use App\Http\Controllers\pathologist\QcReportController;
use App\Http\Controllers\pathologist\TestsController;
use App\Http\Controllers\pathologist\SatelliteController;
use App\Http\Controllers\pathologist\UserController;


    Route::middleware(['auth', 'pathologist'])->prefix('pathologist')->group(function () {
    
         Route::get('dashboard', [DashboardController::class, 'index'])->name('pathologist.dashboard');

        Route::get('/my-profile/{id}',[UserController::class,'myProfile'])->name('pathologist.profile.view');
        Route::get('/edit-profile/{id}',[UserController::class,'editProfile'])->name('pathologist.profile.edit');
        Route::post('/update-profile',[UserController::class,'updateProfile'])->name('pathologist.profile.update');

          Route::controller(LabTechnicianController::class)->group(function () {
            Route::get('lab_technicians','index')->name('pathologist.lab_technician');
            Route::get('lab_technician/edit/{id}','edit')->name('pathologist.lab_technician.edit');
            Route::post('lab_technician/update','update')->name('pathologist.lab_technician.update');
            Route::post('lab_technician/delete','delete')->name('pathologist.lab_technician.delete');
        });

         Route::controller(CampController::class)->group(function () {
            Route::get('camps','index')->name('pathologist.camp');
            Route::get('camp/edit/{id}','edit')->name('pathologist.camp.edit');
            Route::post('camp/update','update')->name('pathologist.camp.update');
            Route::post('camp/delete','delete')->name('pathologist.camp.delete');
            Route::post('camp/get-devices', 'getDevices')->name('pathologist.organization.devices');
        });


         Route::controller(PatientController::class)->group(function () {
            Route::get('patients','index')->name('pathologist.patient');
            Route::post('patient/delete','delete')->name('pathologist.patient.delete');
        });

         Route::controller(PatientReportController::class)->group(function () {
            Route::get('patients/report','index')->name('pathologist.patient.report');
        });

        Route::controller(QcReportController::class)->group(function () {
            Route::get('qc-report','index')->name('pathologist.qc_report');
            Route::post('qc-report/delete','delete')->name('pathologist.qc_report.delete');
        });

          Route::controller(TestsController::class)->group(function () {
            Route::get('tests','index')->name('pathologist.test');
            Route::get('test/edit/{id}','edit')->name('pathologist.test.edit');
            Route::post('test/update','update')->name('pathologist.test.update');
            Route::post('test/delete','delete')->name('pathologist.test.delete');
        });


         Route::controller(SatelliteController::class)->group(function () {
            Route::get('satellite-data','index')->name('pathologist.satellite_data');
            Route::get('satellite-data/show/{id}','show')->name('pathologist.satellite_data.show');
            Route::get('satellite-map-data','TestMapShow')->name('pathologist.satellite_data.map');
            // Route::get('lab_technician/create','create')->name('pathologist.lab_technician.create');
            // Route::post('lab_technician/store','store')->name('pathologist.lab_technician.store');
            // Route::get('lab_technician/edit/{id}','edit')->name('pathologist.lab_technician.edit');
            // Route::post('lab_technician/update','update')->name('pathologist.lab_technician.update');
            Route::post('satellite-data/delete','delete')->name('pathologist.satellite_data.delete');
        });
    });


    