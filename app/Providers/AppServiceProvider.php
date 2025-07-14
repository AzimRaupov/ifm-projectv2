<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::middleware('web')
            ->prefix('teacher')
            ->name('teacher.')
            ->group(base_path('routes/teacher.php'));
        Route::middleware('web')
            ->prefix('api')
            ->name('api.')
            ->group(base_path('routes/api.php'));
    }
}
