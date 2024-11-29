<?php

use App\Http\Middleware\AdminAuthenticate;
use App\Http\Middleware\AdminRedirect;
use App\Http\Middleware\common_files;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //for staff
        $middleware->redirectTo(
            guests : '/',
            users: 'account/dashboard'
        );

        //for admin
        $middleware->alias([
            'admin.guest' => \App\Http\Middleware\AdminRedirect::class,
            'admin.auth' => \App\Http\Middleware\AdminAuthenticate::class,
            'both.aceess' => \App\Http\Middleware\common_files::class,
        ]);


    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
