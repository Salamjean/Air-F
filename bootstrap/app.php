<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'prestataire' => \App\Http\Middleware\PrestataireMiddleware::class,
            'responsable' => \App\Http\Middleware\ResponsableMiddleware::class,
            'financier' => \App\Http\Middleware\FinancierMiddleware::class,
            'personnel' => \App\Http\Middleware\PersonnelMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
