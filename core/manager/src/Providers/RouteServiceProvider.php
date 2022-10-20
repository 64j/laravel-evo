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
        $this->routes(function () {
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(app_path('routes/web.php'));
        });

//        $this->routes(
//            fn() => Route::middleware('web')
//                ->namespace($this->namespace)
//                ->group(app_path('routes/web.php'))
//        );
    }
}
