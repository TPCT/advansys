<?php

namespace App\Providers;

use App\Http\Middleware\SetLocale;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->phone ?: $request->ip());
        });

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('/{locale?}/api')
                ->where(['locale' => implode('|', array_keys(config('app.locales')))])
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('/{locale?}/api/admin')
                ->where(['locale' => implode('|', array_keys(config('app.locales')))])
                ->group(base_path('routes/admin.php'));

            Route::middleware('api')
                ->prefix('/{locale?}/api/frontend')
                ->where(['locale' => implode('|', array_keys(config('app.locales')))])
                ->group(base_path('routes/frontend.php'));
        });
    }

    public function configureRateLimiting(): void{

    }
}
