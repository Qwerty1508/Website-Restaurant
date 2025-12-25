<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
            \App\Http\Middleware\SecurityHeaders::class,
            \App\Http\Middleware\ViewerMiddleware::class,
            \App\Http\Middleware\MaintenanceMiddleware::class, // Global maintenance check
        ]);
        
        // Exclude visitor tracking API routes from CSRF verification
        $middleware->validateCsrfTokens(except: [
            'api/maintenance-visitor/*',
            'api/site-visitor/*',
        ]);
        
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Redirect 404 pages to landing page
        $exceptions->renderable(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
            return redirect('/');
        });
    })->create();
