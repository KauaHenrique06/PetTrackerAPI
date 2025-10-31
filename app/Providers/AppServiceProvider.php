<?php

namespace App\Providers;

use App\Actions\Fortify\ResetUserPassword;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ResetsUserPasswords::class, function () {
        return new ResetUserPassword;
    });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api/index.php'));
    }
}
