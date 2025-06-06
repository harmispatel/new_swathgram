<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\CampController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DeviceCategoryController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\PatientReportController;
use App\Http\Controllers\LabTechnicianController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PathologistController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\SubProfileController;
use App\Http\Controllers\TestsController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsSuperAdmin;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\QcReportController;
use App\Http\Controllers\SatelliteController;

Route::get('config-clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    dd("Cache is cleared");
});



Route::get('/login',[AuthController::class,'showLogin'])->name('login');
Route::post('/login', [AuthController::class,'login'])->name('doLogin');
Route::get('/logout', [AuthController::class,'logout'])->name('logout');

Route::get('forget-password', [AuthController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [AuthController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [AuthController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::group(['prefix' => 'superadmin'], function ()
{
    Route::group(['middleware' => ['auth:web', 'is_super_admin']], function ()
    {
        Route::get('dashboard', [DashboardController::class,'index'])->name('super_admin.dashboard');
    
        Route::controller(OrganizationController::class)->group(function () {
            Route::get('organization','index')->name('organization');
            Route::get('organization/create','create')->name('organization.create');
            Route::post('organization/store','store')->name('organization.store');
            Route::get('organization/edit/{id}','edit')->name('organization.edit');
            Route::post('organization/update','update')->name('organization.update');
            Route::post('organization/delete','delete')->name('organization.delete');
        });

        Route::controller(ManagerController::class)->group(function () {
            Route::get('managers','index')->name('managers');
            Route::get('manager/create','create')->name('manager.create');
            Route::post('manager/store','store')->name('manager.store');
            Route::get('manager/edit/{id}','edit')->name('manager.edit');
            Route::post('manager/update','update')->name('manager.update');
            Route::post('manager/delete','delete')->name('manager.delete');
        });

        Route::controller(PathologistController::class)->group(function () {
            Route::get('pathologists','index')->name('pathologists');
            Route::get('pathologist/create','create')->name('pathologist.create');
            Route::post('pathologist/store','store')->name('pathologist.store');
            Route::get('pathologist/edit/{id}','edit')->name('pathologist.edit');
            Route::post('pathologist/update','update')->name('pathologist.update');
            Route::post('pathologist/delete','delete')->name('pathologist.delete');
        });

        Route::controller(LabTechnicianController::class)->group(function () {
            Route::get('lab_technicians','index')->name('lab_technician');
            Route::get('lab_technician/create','create')->name('lab_technician.create');
            Route::post('lab_technician/store','store')->name('lab_technician.store');
            Route::get('lab_technician/edit/{id}','edit')->name('lab_technician.edit');
            Route::post('lab_technician/update','update')->name('lab_technician.update');
            Route::post('lab_technician/delete','delete')->name('lab_technician.delete');
        });

        Route::controller(PackageController::class)->group(function () {
            Route::get('packages','index')->name('package');
            Route::get('package/create','create')->name('package.create');
            Route::post('package/store','store')->name('package.store');
            Route::get('package/edit/{id}','edit')->name('package.edit');
            Route::post('package/update','update')->name('package.update');
            Route::post('package/delete','delete')->name('package.delete');
            Route::post('package/get-tests-by-profile', 'getTestsByProfile')->name('tests.profiles');
            Route::post('package/get-test-details','getTestDetails')->name('test.details');
        });

        Route::controller(DeviceController::class)->group(function () {
            Route::get('devices','index')->name('device');
            Route::get('device/create','create')->name('device.create');
            Route::post('device/store','store')->name('device.store');
            Route::get('device/edit/{id}','edit')->name('device.edit');
            Route::post('device/update','update')->name('device.update');
            Route::post('device/delete','delete')->name('device.delete');
        });

        Route::controller(DeviceCategoryController::class)->group(function () {
            Route::get('devices/category','index')->name('device.category');
            Route::get('device/category/create','create')->name('device.category.create');
            Route::post('device/category/store','store')->name('device.category.store');
            Route::get('device/category/edit/{id}','edit')->name('device.category.edit');
            Route::post('device/category/update','update')->name('device.category.update');
            Route::post('device/category/delete','delete')->name('device.category.delete');
        });

        Route::controller(CampController::class)->group(function () {
            Route::get('camps','index')->name('camp');
            Route::get('camp/create','create')->name('camp.create');
            Route::post('camp/store','store')->name('camp.store');
            Route::get('camp/edit/{id}','edit')->name('camp.edit');
            Route::post('camp/update','update')->name('camp.update');
            Route::post('camp/delete','delete')->name('camp.delete');
            Route::post('camp/get-devices', 'getDevices')->name('organization.devices');
        });

        Route::controller(PatientController::class)->group(function () {
            Route::get('patients','index')->name('patient');
            Route::post('patient/delete','delete')->name('patient.delete');
        });

        // AdminProfile
        Route::get('/my-profile/{id}',[UserController::class,'myProfile'])->name('admin.profile.view');
        Route::get('/edit-profile/{id}',[UserController::class,'editProfile'])->name('admin.profile.edit');
        Route::post('/update-profile',[UserController::class,'updateProfile'])->name('admin.profile.update');

        Route::controller(PatientReportController::class)->group(function () {
            Route::get('patients/report','index')->name('patient.report');
        });

        Route::controller(RevenueController::class)->group(function () {
            Route::get('revenus','index')->name('revenue');
        });

        Route::controller(BillingController::class)->group(function () {
            Route::get('billing','index')->name('billing');
        });


        Route::controller(TestsController::class)->group(function () {
            Route::get('tests','index')->name('test');
            Route::get('test/create','create')->name('test.create');
            Route::post('test/store','store')->name('test.store');
            Route::get('test/edit/{id}','edit')->name('test.edit');
            Route::post('test/update','update')->name('test.update');
            Route::post('test/delete','delete')->name('test.delete');
        });

        Route::controller(DepartmentController::class)->group(function () {
            Route::get('departments','index')->name('department');
            Route::get('department/create','create')->name('department.create');
            Route::post('department/store','store')->name('department.store');
            Route::post('department/delete','delete')->name('department.delete');
        });

        Route::controller(ProfileController::class)->group(function () {
            Route::get('profiles','index')->name('test.profile');
            Route::get('profile/create','create')->name('test.profile.create');
            Route::post('profile/store','store')->name('test.profile.store');
            Route::post('profile/delete','delete')->name('test.profile.delete');
        });

        Route::controller(SubProfileController::class)->group(function () {
            Route::get('sub-profiles','index')->name('test.sub-profile');
            Route::get('sub-profile/create','create')->name('test.sub-profile.create');
            Route::post('sub-profile/store','store')->name('test.sub-profile.store');
            Route::post('sub-profile/delete','delete')->name('test.sub-profile.delete');
        });

        Route::controller(SatelliteController::class)->group(function () {
            Route::get('satellite-data','index')->name('satellite_data');
            Route::get('satellite-data/show/{id}','show')->name('satellite_data.show');
            Route::get('satellite-map-data','TestMapShow')->name('satellite_data.map');
            // Route::get('lab_technician/create','create')->name('lab_technician.create');
            // Route::post('lab_technician/store','store')->name('lab_technician.store');
            // Route::get('lab_technician/edit/{id}','edit')->name('lab_technician.edit');
            // Route::post('lab_technician/update','update')->name('lab_technician.update');
            Route::post('satellite-data/delete','delete')->name('satellite_data.delete');
        });

        Route::controller(QcReportController::class)->group(function () {
            Route::get('qc-report','index')->name('qc_report');
            Route::post('qc-report/delete','delete')->name('qc_report.delete');
        });
    });
});

