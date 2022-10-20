<?php

namespace Manager\Http;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View as ContractView;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Manager\Core;
use Manager\Interfaces\ControllerInterface;

class Kernel extends HttpKernel
{
    /**
     * The application implementation.
     *
     * @var Application|Core
     */
    protected $app;

    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
//    protected $middleware = [
//        \Fruitcake\Cors\HandleCors::class,
//        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
//        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
//        // \Manager\Http\Middleware\TrustHosts::class,
//        \Manager\Http\Middleware\TrustProxies::class,
//        \Manager\Http\Middleware\PreventRequestsDuringMaintenance::class,
//        \Manager\Http\Middleware\TrimStrings::class,
//    ];


    protected $middleware = [
//        \Manager\Http\Middleware\HandleCors::class,
//        \Manager\Http\Middleware\Authenticate::class,
//        \Manager\Http\Middleware\EncryptCookies::class,
//        \Manager\Http\Middleware\VerifyCsrfToken::class,
//        \Illuminate\Session\Middleware\StartSession::class,
//        \Illuminate\Session\Middleware\AuthenticateSession::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Manager\Http\Middleware\VerifyCsrfToken::class,
            \Manager\Http\Middleware\EncryptCookies::class,
            \Manager\Http\Middleware\Authenticate::class,
        ],
    ];

    /**
     * @var string
     */
    protected string $namespace = 'manager';

    /**
     * @var array
     */
    protected array $actions = [
        /** frame management - show the requested frame */
        1 => Controllers\HomeController::class,
        /** show the homepage */
        2 => Controllers\DashboardController::class,
        /** document data */
        3,
        /** content management */
        85,
        27,
        4,
        5,
        6,
        63,
        51 => Controllers\MoveDocument::class,
        52 => Controllers\MoveDocument::class,
        61,
        62,
        56,
        /** show the wait page - gives the tree time to refresh (hopefully) */
        7,
        /** let the user log out */
        8 => Controllers\Users\LogInOut::class,
        0 => Controllers\Users\LogInOut::class,
        /** user management */
        87,
        88,
        89 => Controllers\Users\EditOrNewUser::class,
        90 => Controllers\Users\DeleteUser::class,
        32,
        28 => Controllers\Password::class,
        34 => ChangePassword::class,
        /** role management */
        38 => UserRole::class,
        35 => UserRole::class,
        36 => UserRole::class,
        135 => Permission::class,
        136 => PermissionsGroups::class,
        /** category management */
        120,
        121,
        /** template management */
        16 => Controllers\Template::class,
        19 => Controllers\Template::class,
        20,
        21,
        96,
        117,
        /** snippet management */
        22 => Controllers\Snippet::class,
        23 => Controllers\Snippet::class,
        24,
        25,
        98,
        /** htmlsnippet management */
        78 => Controllers\Chunk::class,
        77 => Controllers\Chunk::class,
        79,
        80,
        97,
        /** @deprecated show the credits page */
        18 => Controllers\Help::class,
        /** empty cache & synchronisation */
        26 => Controllers\RefreshSite::class,
        /** Module management */
        106 => Controllers\Modules::class,
        107,
        108,
        109,
        110,
        111,
        112,
        113,
        /** plugin management */
        100 => Controllers\PluginPriority::class,
        101 => Controllers\Plugin::class,
        102 => Controllers\Plugin::class,
        103,
        104,
        105,
        119,
        /** view phpinfo */
        200 => Controllers\Phpinfo::class,
        /** @deprecated errorpage */
        29 => Controllers\EventLog::class,
        /** file manager */
        31,
        /** access permissions */
        91 => Controllers\WebAccessPermissions::class,
        /** access groups processor */
        92,
        /** settings editor */
        17 => Controllers\SystemSettings::class,
        118,
        /** save settings */
        30,
        /** system information */
        53 => Controllers\SystemInfo::class,
        /** optimise table */
        54,
        /** view logging */
        13,
        /** empty logs */
        55,
        /** calls test page    */
        999,
        /** Empty recycle bin */
        64,
        /** Remove locks */
        67,
        /** Site schedule */
        70 => Controllers\SiteSchedule::class,
        /** Search */
        71 => Controllers\Search::class,
        /** @deprecated About */
        59 => Controllers\Help::class,
        /** Add weblink */
        72,
        /** User management */
        99,
        86 => RoleManagment::class,
        /** template/ snippet management */
        76 => Controllers\Resources::class,
        /** Resource Selector  */
        84,
        /** Backup Manager */
        93,
        /** Duplicate Document */
        94,
        /** Update Tree for Closure Table */
        95 => Controllers\UpdateTree::class,
        /** Help */
        9 => Controllers\Help::class,
        /** Template Variables - Based on Apodigm's Docvars */
        300 => Controllers\Tmplvar::class,
        301 => Controllers\Tmplvar::class,
        302,
        303,
        304,
        305 => Controllers\TmplvarRank::class,
        /** Event viewer: show event message log */
        114 => Controllers\EventLog::class,
        115 => Controllers\EventLogDetails::class,
        116,
        501,
    ];

//    /**
//     * Get the route dispatcher callback.
//     *
//     * @return Closure
//     */
//    protected function dispatchToRouter(): Closure
//    {
//        return function ($request) {
//            $this->app->instance('request', $request);
//            $response = $this->router->dispatch($request);
//            $response->setContent($this->run());
//
//            return $response;
//        };
//    }

    /**
     * @return string|null
     */
    public function run(): ?string
    {
        $out = '';
        $action = $this->app->request->input('a', 1);
        $controllerName = Arr::get($this->actions, $action);

        if (is_int($controllerName)) {
            $out = $this->view('page.' . $action)->render();
        } elseif (class_exists($controllerName) &&
            in_array(ControllerInterface::class, class_implements($controllerName), true)
        ) {
            /** @var ControllerInterface $controller */
            $controller = App::make($controllerName);
            $controller->setIndex($action);

            if (!$controller->canView()) {
                $this->alertAndQuit('error_no_privileges');
            } elseif (($out = $controller->checkLocked()) !== null) {
                $this->alertAndQuit($out, false);
            } elseif ($controller->process()) {
                $out = $controller->render();
            } else {
                $out = '';
            }
        } else {
            $out = $this->view('page.' . $action)->render();
        }

        return $out;
    }

    /**
     * @param string $name
     * @param array $params
     *
     * @return ContractView
     */
    public function view(string $name, array $params = []): ContractView
    {
        return View::addNamespace(
            $this->app->getNamespace(),
            $this->app->viewPath()
        )
            ->make(
                $this->getViewName($name),
                $params
            );
    }

    /**
     * @param $name
     *
     * @return string
     */
    public function getViewName($name): string
    {
        return $this->app->getNamespace() . '::' . $name;
    }
}
