<?php

namespace Manager\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\App;

class Authenticate extends Middleware
{
    /**
     * Get the controller method the user should be redirected to when they are not authenticated.
     *
     * @param $request
     *
     * @return mixed|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return App::call('\Manager\Http\Controllers\LoginController@run');
        }

        return null;
    }
}
