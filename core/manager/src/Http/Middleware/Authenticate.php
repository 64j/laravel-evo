<?php

namespace Manager\Http\Middleware;

use Exception;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class Authenticate extends Middleware
{
    /**
     * Get the controller method the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     *
     * @throws Exception
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            Redirect::action('LoginController@test', [])->getContent();
            //return action('LoginController@test');
            //return App::make(LoginController::class)->run();
        }
    }
}
