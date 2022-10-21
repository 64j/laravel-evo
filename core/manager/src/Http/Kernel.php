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
        \Manager\Http\Middleware\HandleCors::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        //\Manager\Http\Middleware\TrimStrings::class,
        //\Manager\Http\Middleware\Authenticate::class,
        //\Manager\Http\Middleware\EncryptCookies::class,
        //\Manager\Http\Middleware\VerifyCsrfToken::class,
    ];

    protected $routeMiddleware = [
        'auth' => \Manager\Http\Middleware\Authenticate::class,
    ];
}
