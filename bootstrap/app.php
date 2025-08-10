<?php


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
    ->withMiddleware(function (Middleware $middleware): void {
        // $middleware->web([
        //     'check.requirement' => App\Http\Middleware\CheckRequirements::class,
        //     'check.installed' => App\Http\Middleware\CheckIfInstalled::class,
        // ]);
        $middleware->alias([
            'check.requirement' => App\Http\Middleware\CheckRequirements::class,
            'check.installed'   => App\Http\Middleware\CheckIfInstalled::class,
        ]);

        $middleware->api([]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
