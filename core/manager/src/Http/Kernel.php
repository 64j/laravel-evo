<?php

namespace Manager\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        \Fruitcake\Cors\HandleCors::class,
        //        \Illuminate\Session\Middleware\StartSession::class,
        //        \Illuminate\Session\Middleware\AuthenticateSession::class,
        //        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        //        \Manager\Http\Middleware\Authenticate::class,
        //        \Manager\Http\Middleware\EncryptCookies::class,
        //        \Manager\Http\Middleware\VerifyCsrfToken::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            //\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'api' => [
            //\Manager\Http\Middleware\Authenticate::class,
        ]
    ];

    protected $routeMiddleware = [
        'auth' => \Manager\Http\Middleware\Authenticate::class,
    ];
}
