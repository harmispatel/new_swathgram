<?php

namespace App\Providers;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;


class RouteServiceProvider extends ServiceProvider
{
 
   protected $namespace = 'App\Http\Controllers';

  
  public function boot()
  {
    parent::boot();
  }


  public function map()
  {
   //  $this->mapApiRoutes();

     $this->mapLabTechnicianRoutes();
     $this->mapWebRoutes();
     $this->mapApiRoutes();
     $this->mapAdminRoutes();
     $this->mapPathologistRoutes();
     $this-> mapManagerRoutes();

  }


  protected function mapLabTechnicianRoutes()
  {
    Route::middleware('web')
       ->namespace($this->namespace)
       ->group(base_path('routes/LabTechnician.php'));
  }

  protected function mapWebRoutes()
  {
    Route::middleware('web')
       ->namespace($this->namespace)
       ->group(base_path('routes/web.php'));
  }

  protected function mapApiRoutes()
  {
    Route::prefix('api')
        ->middleware('api')
        ->namespace($this->namespace)
        ->group(base_path('routes/api.php'));
  }
  // protected function mapAdminRoutes()
  // {
  //   Route::middleware('admin')
  //      ->namespace($this->namespace)
  //      ->group(base_path('routes/admin.php'));
  // }

  protected function mapAdminRoutes()
  {
      Route::middleware(['web'])
          ->group(base_path('routes/admin.php'));
  }

  protected function mapPathologistRoutes()
  {
      Route::middleware(['web'])
          ->group(base_path('routes/Pathologist.php'));
         
  }
  protected function mapManagerRoutes()
  {
      Route::middleware(['web'])
          ->group(base_path('routes/manager.php'));
         
  }
  
}
