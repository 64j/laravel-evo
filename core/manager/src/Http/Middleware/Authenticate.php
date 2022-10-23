<?php

namespace Manager\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Contracts\Foundation\Application;
use Manager\Core;

class Authenticate extends Middleware
{
    /**
     * @var Application|Core
     */
    protected Application $app;

    /**
     * @param Application $app
     * @param Auth $auth
     */
    public function __construct(Application $app, Auth $auth)
    {
        $this->auth = $auth;
        $this->app = $app;
    }

    /**
     * @param $request
     * @param Closure $next
     * @param ...$guards
     *
     * @return mixed
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (in_array(
            $request->input('method'),
            $this->app['config']->get('auth.guards.manager.except_methods', []),
            true
        )
        ) {
            return $this->app->call($this->app->getRouteNamespace() . '\\' . $request->input('method'));
        }

        return parent::handle($request, $next, ...$guards);
    }
}
