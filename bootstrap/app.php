<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\IsSuperAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'is_super_admin' => IsSuperAdmin::class,
            'auth' => Authenticate::class,
            'isAdmin' => App\Http\Middleware\IsAdmin::class,
            'pathologist' => App\Http\Middleware\IsPathologist::class,
            'labtechician' => App\Http\Middleware\IsLabTechnician::class,
            'manager' => App\Http\Middleware\Ismanager::class,
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
