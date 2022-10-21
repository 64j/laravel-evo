<?php

declare(strict_types=1);

namespace Manager\Http\Controllers;

use Illuminate\Contracts\View\View as ContractView;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class Home extends Controller
{
    /**
     * @param Request $request
     *
     * @return ContractView
     */
    public function handle(Request $request): ContractView
    {
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
     * @return array
     */
    protected function getMenu(): array
    {
        return [
            [
                'icon' => '<i class="fa fa-bars fa-1x"></i>',
            ],
            [
                'href' => '?a=2',
                'title' => '<span class="d-none d-md-inline-block">' . __('global.home') . '</span>',
                'icon' => '<i class="fa fa-tachometer fa-1x d-md-none"></i>',
            ],
            [
                'href' => '?a=2',
                'title' => '<span class="d-none d-md-inline-block">' . __('global.elements') . '</span>',
                'icon' => '<i class="fa fa-th fa-1x d-md-none"></i>',
                'items' => [
                    [
                        'href' => '?a=2',
                        'title' => __('global.templates'),
                        'icon' => '<i class="fa fa-fw fa-newspaper me-1"></i>',
                        'items' => [],
                    ],
                    [
                        'href' => '?a=2',
                        'title' => __('global.tmplvars'),
                        'icon' => '<i class="fa fa-fw fa-list-alt me-1"></i>',
                        'items' => [],
                    ],
                    [
                        'href' => '?a=2',
                        'title' => __('global.htmlsnippets'),
                        'icon' => '<i class="fa fa-fw fa-th-large me-1"></i>',
                        'items' => [],
                    ],
                    [
                        'href' => '?a=2',
                        'title' => __('global.snippets'),
                        'icon' => '<i class="fa fa-fw fa-code me-1"></i>',
                        'items' => [],
                    ],
                    [
                        'href' => '?a=2',
                        'title' => __('global.plugins'),
                        'icon' => '<i class="fa fa-fw fa-plug me-1"></i>',
                        'items' => [],
                    ],
                    [
                        'href' => '?a=2',
                        'title' => __('global.modules'),
                        'icon' => '<i class="fa fa-fw fa-cube me-1"></i>',
                        'items' => [],
                    ],
                ],
            ],
            [
                'href' => '?a=2',
                'title' => '<span class="d-none d-md-inline-block">' . __('global.modules') . '</span>',
                'icon' => '<i class="fa fa-cubes fa-1x d-md-none"></i>',
            ],
            [
                'href' => '?a=2',
                'title' => '<span class="d-none d-md-inline-block">' . __('global.users') . '</span>',
                'icon' => '<i class="fa fa-users fa-1x d-md-none"></i>',
                'items' => [
                    [
                        'href' => '?a=2',
                        'title' => __('global.users'),
                        'icon' => '',
                    ],
                    [
                        'href' => '?a=2',
                        'title' => __('global.role_management_title'),
                        'icon' => '',
                    ],
                    [
                        'href' => '?a=2',
                        'title' => __('global.web_permissions'),
                        'icon' => '',
                    ],
                ],
            ],
            [
                'href' => '?a=2',
                'title' => '<span class="d-none d-md-inline-block">' . __('global.tools') . '</span>',
                'icon' => '<i class="fa fa-wrench fa-1x d-md-none"></i>',
                'items' => [
                    [
                        'href' => '?a=2',
                        'title' => __('global.refresh_site'),
                        'icon' => '',
                    ],
                    [
                        'href' => '?a=2',
                        'title' => __('global.search'),
                        'icon' => '',
                    ],
                    [
                        'href' => '?a=2',
                        'title' => __('global.bk_manager'),
                        'icon' => '',
                    ],
                    [
                        'href' => '?a=2',
                        'title' => __('global.remove_locks'),
                        'icon' => '',
                    ],
                ],
            ],
            'separator',
            [
                'icon' => '<i class="fa fa-search fa-1x"></i>',
            ],
            [
                'icon' => '<i class="fa fa-desktop fa-1x"></i>',
            ],
            [
                'icon' => '<i class="far fa-user-circle fa-1x"></i>',
                'items.class' => 'dropdown-menu-end',
                'items' => [
                    [
                        'href' => '?a=2',
                        'title' => __('global.change_password'),
                        'icon' => '',
                    ],
                    [
                        'href' => '?a=2',
                        'title' => __('global.logout'),
                        'icon' => '',
                    ],
                ],
            ],
            [
                'icon' => '<i class="fa fa-cogs fa-1x"></i>',
                'items.class' => 'dropdown-menu-end',
                'items' => [
                    [
                        'href' => '?a=2',
                        'title' => __('global.settings_config'),
                        'icon' => '',
                    ],
                    [
                        'href' => '?a=2',
                        'title' => __('global.site_schedule'),
                        'icon' => '',
                    ],
                    [
                        'href' => '?a=2',
                        'title' => __('global.eventlog_viewer'),
                        'icon' => '',
                    ],
                    [
                        'href' => '?a=2',
                        'title' => __('global.view_logging'),
                        'icon' => '',
                    ],
                    [
                        'href' => '?a=2',
                        'title' => __('global.view_sysinfo'),
                        'icon' => '',
                    ],
                    [
                        'href' => '?a=2',
                        'title' => __('global.help'),
                        'icon' => '',
                    ],
                ],
            ],
        ];
    }
}
