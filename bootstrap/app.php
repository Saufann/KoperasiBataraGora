<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\SuperAdminOnly;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {

        // REGISTER MIDDLEWARE DISINI

        $middleware->alias([
            // 'admin.auth' => AdminAuth::class,
            'admin.auth' => \App\Http\Middleware\AdminMiddleware::class,
            'superadmin' => SuperAdminOnly::class,

        ]);

    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })

    ->create();
