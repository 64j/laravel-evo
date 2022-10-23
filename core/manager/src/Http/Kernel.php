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
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
//        \Manager\Http\Middleware\TrimStrings::class,
//        \Manager\Http\Middleware\Authenticate::class,
//        \Manager\Http\Middleware\EncryptCookies::class,
//        \Manager\Http\Middleware\VerifyCsrfToken::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        ],
        'api' => [
            \Manager\Http\Middleware\Authenticate::class,
        ]
    ];

    protected $routeMiddleware = [
        'cors' => \Manager\Http\Middleware\HandleCors::class,
        'auth' => \Manager\Http\Middleware\Authenticate::class,
        'session.start' => \Illuminate\Session\Middleware\StartSession::class,
        'session.auth' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'session.errors' => \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    ];
}
