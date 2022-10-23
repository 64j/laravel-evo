<?php

namespace Manager\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Manager\Core;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The application instance.
     *
     * @var Application|Core
     */
    protected $app;

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->namespace = $this->app->getRouteNamespace();

        $this->routes(
            fn() => Route::namespace($this->namespace)
                ->group(
                    fn() => [
                        Route::get('/', 'Controller@handle')->middleware('web')->name('login'),
                        Route::post('/', 'Controller@handle')->middleware(['auth:manager']),
                        Route::put('/', 'Controller@handle')->middleware(['web']),
                    ]
                )
        );
    }
}
