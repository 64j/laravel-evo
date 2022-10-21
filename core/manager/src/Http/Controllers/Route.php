<?php

declare(strict_types=1);

namespace Manager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;

class Route extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('handle');
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function handle(Request $request)
    {
        $controller = $request->has('method') ? '\Manager\Http\Controllers\\' . $request->input('method') : null;
        $params = $request->input('params');

        return App::call($controller, ['params' => $params]);
    }
}
