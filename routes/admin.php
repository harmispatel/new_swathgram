<?php
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\admin\ManagerController;
use App\Http\Controllers\admin\PathologistController;
use App\Http\Controllers\admin\LabTechnicianController;
use App\Http\Controllers\admin\PackageController;
use App\Http\Controllers\admin\CampController;
use App\Http\Controllers\admin\PatientReportController;
use App\Http\Controllers\admin\PatientController;
use App\Http\Controllers\admin\RevenueController;
use App\Http\Controllers\admin\BillingController;
use App\Http\Controllers\admin\QcReportController;
use App\Http\Controllers\admin\TestsController;
use App\Http\Controllers\admin\SatelliteController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\admin\UserController;

    Route::middleware(['auth', 'isAdmin'])->prefix('admin')->group(function () {

    // Admin Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

      Route::get('/my-profile/{id}',[UserController::class,'myProfile'])->name('profile.view');
        Route::get('/edit-profile/{id}',[UserController::class,'editProfile'])->name('profile.edit');
        Route::post('/update-profile',[UserController::class,'updateProfile'])->name('profile.update');


    Route::controller(ManagerController::class)->group(function () {
        Route::get('managers', 'index')->name('admin.managers');
        Route::get('manager/create', 'create')->name('admin.manager.create');
        Route::post('manager/store', 'store')->name('admin.manager.store');
        Route::get('manager/edit/{id}', 'edit')->name('admin.manager.edit');
        Route::post('manager/update', 'update')->name('admin.manager.update');
        Route::post('manager/delete', 'delete')->name('admin.manager.delete');
    });

     Route::controller(PathologistController::class)->group(function () {
            Route::get('pathologists','index')->name('admin.pathologists');
            Route::get('pathologist/create','create')->name('admin.pathologist.create');
            Route::post('pathologist/store','store')->name('admin.pathologist.store');
            Route::get('pathologist/edit/{id}','edit')->name('admin.pathologist.edit');
            Route::post('pathologist/update','update')->name('admin.pathologist.update');
            Route::post('pathologist/delete','delete')->name('admin.pathologist.delete');
        });

          Route::controller(LabTechnicianController::class)->group(function () {
            Route::get('lab_technicians','index')->name('admin.lab_technician');
            Route::get('lab_technician/create','create')->name('admin.lab_technician.create');
            Route::post('lab_technician/store','store')->name('admin.lab_technician.store');
            Route::get('lab_technician/edit/{id}','edit')->name('admin.lab_technician.edit');
            Route::post('lab_technician/update','update')->name('admin.lab_technician.update');
            Route::post('lab_technician/delete','delete')->name('admin.lab_technician.delete');
        });
        
        
        Route::controller(PackageController::class)->group(function () {
            Route::get('packages','index')->name('admin.package');
            Route::get('package/create','create')->name('admin.package.create');
            Route::post('package/store','store')->name('admin.package.store');
            Route::get('package/edit/{id}','edit')->name('admin.package.edit');
            Route::post('package/update','update')->name('admin.package.update');
            Route::post('package/delete','delete')->name('admin.package.delete');
            Route::post('package/get-tests-by-profile', 'getTestsByProfile')->name('admin.tests.profiles');
            Route::post('package/get-test-details','getTestDetails')->name('admin.test.details');
        });


         Route::controller(CampController::class)->group(function () {
            Route::get('camps','index')->name('admin.camp');
            Route::get('camp/create','create')->name('admin.camp.create');
            Route::post('camp/store','store')->name('admin.camp.store');
            Route::get('camp/edit/{id}','edit')->name('admin.camp.edit');
            Route::post('camp/update','update')->name('admin.camp.update');
            Route::post('camp/delete','delete')->name('admin.camp.delete');
            Route::post('camp/get-devices', 'getDevices')->name('admin.organization.devices');
        });

        Route::controller(PatientController::class)->group(function () {
            Route::get('patients','index')->name('admin.patient');
            Route::post('patient/delete','delete')->name('admin.patient.delete');
        });

         Route::controller(PatientReportController::class)->group(function () {
            Route::get('patients/report','index')->name('admin.patient.report');
        });

         Route::controller(RevenueController::class)->group(function () {
            Route::get('revenus','index')->name('admin.revenue');
        });

         Route::controller(BillingController::class)->group(function () {
            Route::get('billing','index')->name('admin.billing');
        });

        Route::controller(QcReportController::class)->group(function () {
            Route::get('qc-report','index')->name('admin.qc_report');
            Route::post('qc-report/delete','delete')->name('admin.qc_report.delete');
        });


          Route::controller(TestsController::class)->group(function () {
            Route::get('tests','index')->name('admin.test');
            Route::get('test/create','create')->name('admin.test.create');
            Route::post('test/store','store')->name('admin.test.store');
            Route::get('test/edit/{id}','edit')->name('admin.test.edit');
            Route::post('test/update','update')->name('admin.test.update');
            Route::post('test/delete','delete')->name('admin.test.delete');
        });

         Route::controller(SatelliteController::class)->group(function () {
            Route::get('satellite-data','index')->name('admin.satellite_data');
            Route::get('satellite-data/show/{id}','show')->name('admin.satellite_data.show');
            Route::get('satellite-map-data','TestMapShow')->name('admin.satellite_data.map');
            // Route::get('lab_technician/create','create')->name('admin.lab_technician.create');
            // Route::post('lab_technician/store','store')->name('admin.lab_technician.store');
            // Route::get('lab_technician/edit/{id}','edit')->name('admin.lab_technician.edit');
            // Route::post('lab_technician/update','update')->name('admin.lab_technician.update');
            Route::post('satellite-data/delete','delete')->name('admin.satellite_data.delete');
        });
});