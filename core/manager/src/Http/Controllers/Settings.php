<?php

declare(strict_types=1);

namespace Manager\Http\Controllers;

use App\Models\Category;
use App\Models\Permissions;
use App\Models\User;
use App\Models\UserAttribute;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Settings extends Controller
{
    /**
     * @return JsonResponse
     */
    public function read(): JsonResponse
    {
        return $this->ok([
            'user' => $this->getUser(),
            'config' => $this->app->getSettings(),
            'categories' => $this->getCategories(),
            'permissions' => $this->getPermissionsByRole(),
            'lexicon' => __('global'),
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
    protected function getUser(): array
    {
        $attributes = UserAttribute::query()
            ->whereHas('user', fn($query) => $query->whereKey(Auth::user()->getKey()))
            ->first();

        $attributes->username = $attributes->user->username;

        unset($attributes->user);

        return $attributes->setHidden([])->toArray();
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

        return array_map(
            function ($item) {
                $item['disabled'] = !$item['role_permissions'];
                unset($item['role_permissions']);

                return $item;
            },
            Permissions::query()
                ->select(['key', 'name', 'lang_key'])
                ->with(
                    'rolePermissions',
                    fn($query) => $query->select(['permission'])
                        ->where('role_id', $role)
                )
                ->get()
                ->keyBy('key')
                ->toArray()
        );
    }
}
