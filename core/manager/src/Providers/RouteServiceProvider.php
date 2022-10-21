<?php

namespace Manager\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $namespace = 'Manager\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->routes(
            fn() => Route::namespace($this->namespace)
                ->group(
                    fn() => [
                        Route::get('/', 'Controller@handle')->name('login'),
                        Route::post('/', 'Controller@handle')->middleware('auth:manager'),
                    ]
                )
        );
    }
}
