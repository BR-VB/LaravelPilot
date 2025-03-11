<?php

use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\GetHttpRequestLocale;
use App\Http\Middleware\SetGlobalData;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('web', SetGlobalData::class);

        //api
        $middleware->statefulApi();
        $middleware->appendToGroup('api', GetHttpRequestLocale::class);

        //alias definition
        $middleware->alias([
            'isAdminUser' => EnsureUserIsAdmin::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
