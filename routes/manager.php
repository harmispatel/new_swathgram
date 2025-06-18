<?php
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Ismanager;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use App\Http\Controllers\manager\PathologistController;
use App\Http\Controllers\manager\LabTechnicianController;
use App\Http\Controllers\manager\PackageController;
use App\Http\Controllers\manager\CampController;
use App\Http\Controllers\manager\PatientController;
use App\Http\Controllers\manager\PatientReportController;
use App\Http\Controllers\manager\RevenueController;
use App\Http\Controllers\manager\BillingController;
use App\Http\Controllers\manager\QcReportController;
use App\Http\Controllers\manager\TestsController;
use App\Http\Controllers\manager\SatelliteController;
use App\Http\Controllers\manager\UserController;



    Route::middleware(['auth', 'manager'])->prefix('manager')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('manager.dashboard');

        Route::get('/my-profile/{id}',[UserController::class,'myProfile'])->name('manager.profile.view');
        Route::get('/edit-profile/{id}',[UserController::class,'editProfile'])->name('manager.profile.edit');
        Route::post('/update-profile',[UserController::class,'updateProfile'])->name('manager.profile.update');


         Route::controller(PathologistController::class)->group(function () {
            Route::get('pathologists','index')->name('manager.pathologists');
            Route::get('pathologist/create','create')->name('manager.pathologist.create');
            Route::post('pathologist/store','store')->name('manager.pathologist.store');
            Route::get('pathologist/edit/{id}','edit')->name('manager.pathologist.edit');
            Route::post('pathologist/update','update')->name('manager.pathologist.update');
            Route::post('pathologist/delete','delete')->name('manager.pathologist.delete');
        });

          Route::controller(LabTechnicianController::class)->group(function () {
            Route::get('lab_technicians','index')->name('manager.lab_technician');
             Route::get('lab_technician/create','create')->name('manager.lab_technician.create');
            Route::post('lab_technician/store','store')->name('manager.lab_technician.store');
            Route::get('lab_technician/edit/{id}','edit')->name('manager.lab_technician.edit');
            Route::post('lab_technician/update','update')->name('manager.lab_technician.update');
            Route::post('lab_technician/delete','delete')->name('manager.lab_technician.delete');
        });


        Route::controller(PackageController::class)->group(function () {
            Route::get('packages','index')->name('manager.package');
            Route::get('package/create','create')->name('manager.package.create');
            Route::post('package/store','store')->name('manager.package.store');
            Route::get('package/edit/{id}','edit')->name('manager.package.edit');
            Route::post('package/update','update')->name('manager.package.update');
            Route::post('package/delete','delete')->name('manager.package.delete');
            Route::post('package/get-tests-by-profile', 'getTestsByProfile')->name('manager.tests.profiles');
            Route::post('package/get-test-details','getTestDetails')->name('manager.test.details');
        });

         Route::controller(CampController::class)->group(function () {
            Route::get('camps','index')->name('manager.camp');
             Route::get('camp/create','create')->name('manager.camp.create');
            Route::post('camp/store','store')->name('manager.camp.store');
            Route::get('camp/edit/{id}','edit')->name('manager.camp.edit');
            Route::post('camp/update','update')->name('manager.camp.update');
            Route::post('camp/delete','delete')->name('manager.camp.delete');
            Route::post('camp/get-devices', 'getDevices')->name('manager.organization.devices');
        });

        
         Route::controller(PatientController::class)->group(function () {
            Route::get('patients','index')->name('manager.patient');
            Route::post('patient/delete','delete')->name('manager.patient.delete');
        });

         Route::controller(PatientReportController::class)->group(function () {
            Route::get('patients/report','index')->name('manager.patient.report');
        });

         Route::controller(RevenueController::class)->group(function () {
            Route::get('revenus','index')->name('manager.revenue');
        });

          Route::controller(BillingController::class)->group(function () {
            Route::get('billing','index')->name('manager.billing');
        });

        Route::controller(QcReportController::class)->group(function () {
            Route::get('qc-report','index')->name('manager.qc_report');
            Route::post('qc-report/delete','delete')->name('manager.qc_report.delete');
        });

          Route::controller(TestsController::class)->group(function () {
            Route::get('tests','index')->name('manager.test');
            Route::get('test/edit/{id}','edit')->name('manager.test.edit');
            Route::post('test/update','update')->name('manager.test.update');
            Route::post('test/delete','delete')->name('manager.test.delete');
        });


         Route::controller(SatelliteController::class)->group(function () {
            Route::get('satellite-data','index')->name('manager.satellite_data');
            Route::get('satellite-data/show/{id}','show')->name('manager.satellite_data.show');
            Route::get('satellite-map-data','TestMapShow')->name('manager.satellite_data.map');
            // Route::get('lab_technician/create','create')->name('manager.lab_technician.create');
            // Route::post('lab_technician/store','store')->name('manager.lab_technician.store');
            // Route::get('lab_technician/edit/{id}','edit')->name('manager.lab_technician.edit');
            // Route::post('lab_technician/update','update')->name('manager.lab_technician.update');
            Route::post('satellite-data/delete','delete')->name('manager.satellite_data.delete');
        });

    });


    