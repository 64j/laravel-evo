<?php

declare(strict_types=1);

namespace Manager\Http\Controllers;

use App\Models\Category;
use App\Models\RolePermissions;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Settings extends Controller
{
    public function get()
    {
        return $this->ok([
            'config' => $this->app->getSettings(),
            'categories' => $this->getCategories(),
            'permissions' => $this->getPermissionsByRole(1),
        ]);
    }

    /**
     * @return array
     */
    protected function getCategories(): array
    {
        $collect = Collection::make();

        $collect->add([
            'id' => 0,
            'category' => __('global.no_category'),
            'rank' => 0,
        ]);

        $collect = $collect->merge(Category::query()->get());

        return $collect->keyBy('id')->toArray();
    }

    /**
     * @return array
     */
    protected function getPermissionsByRole(): array
    {
        $role = (int) User::query()
            ->with('attributes')
            ->find(Auth::user()->getKey())
            ->attributes
            ->role;

        return RolePermissions::query()
            ->with('permissions')
            ->where('role_id', $role)
            ->get()
            ->pluck('permissions')
            ->filter(fn($permission) => $permission)
            ->map(function ($permission) {
                $permission->lang_key = __('global.' . $permission->lang_key);

                return $permission;
            })
            ->pluck('disabled', 'key')
            ->toArray();
    }
}
