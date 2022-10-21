<?php

declare(strict_types=1);

namespace Manager\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as RoutingController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use JsonSerializable;

class Controller extends RoutingController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * @param Request $request
     */
    public function handle(Request $request)
    {
        if ($request->isMethod('post')) {
            $controller = $request->has('method') ? '\Manager\Http\Controllers\\' . $request->input('method') : null;
            $params = $request->input('params');

            return App::call($controller, ['params' => $params]);
        }

        $view = View::addNamespace(
            App::getNamespace(),
            App::viewPath()
        );

        if (Auth::check()) {
            return $view->make('manager::template.default', [

            ])
                ->with([
                    'controller' => $this,
                ]);
        } else {
            return $view->make('manager::template.login', [])
                ->with([
                    'controller' => $this,
                ]);
        }
    }

    /**
     * @param $data
     * @param array $meta
     * @param int $status
     * @param array $headers
     *
     * @return JsonResponse
     */
    protected function ok($data = [], array $meta = [], int $status = 200, array $headers = []): JsonResponse
    {
        if ($data instanceof JsonSerializable) {
            $data = $data->jsonSerialize();
        }

        return Response::json([
            'meta' => $meta,
            'data' => $data,
        ], $status, $headers);
    }
}
