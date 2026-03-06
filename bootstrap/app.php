<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function () {
            Route::middleware('web')
                ->namespace('App\Http\Controllers')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('api')
                ->namespace('App\Http\Controllers')
                ->group(base_path('routes/api.php'));

            Route::middleware('console')
                ->group(base_path('routes/console.php'));
        },
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'is_admin' => \App\Http\Middleware\IsAdmin::class,
            'is_user' => \App\Http\Middleware\IsUser::class,
            'is_broker' => \App\Http\Middleware\IsBroker::class,
        ]);

        $middleware->append(\VinkiusLabs\LaravelPageSpeed\Middleware\CollapseWhitespace::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
