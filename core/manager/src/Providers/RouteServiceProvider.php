<?php

namespace Manager\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
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
