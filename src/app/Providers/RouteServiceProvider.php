<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Default web routes
        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        // Landlord-specific routes
        Route::middleware('web')
            ->prefix('landlord')
            ->as('landlord.')
            ->group(base_path('routes/landlord.php'));
    }
}
