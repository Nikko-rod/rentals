<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
->withRouting(
    web: [
        __DIR__ . '/../routes/web.php',
        __DIR__ . '/../routes/admin.php',
        __DIR__ . '/../routes/tenant.php',
        __DIR__ . '/../routes/landlord.php',
    ]
)
    ->withMiddleware(function (Middleware $middleware) {
        // Register middleware aliases
        $middleware->alias([
            'is_admin' => IsAdmin::class,
            'role' => RoleMiddleware::class,
            'landlord' => \App\Http\Middleware\Landlord::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        
    })
    ->create();



    