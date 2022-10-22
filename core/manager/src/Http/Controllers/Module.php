<?php

declare(strict_types=1);

namespace Manager\Http\Controllers;

use App\Models\Category;
use App\Models\SiteModule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class Module extends Controller
{
    /**
     * @param array $params
     *
     * @return JsonResponse
     */
    public function list(array $params = []): JsonResponse
    {
        if (!empty($params['categories'])) {
            $list = Collection::wrap(Category::getNoCategoryModules())
                ->merge(
                    Category::query()
                        ->select(['id', 'category as name', 'rank'])
                        ->with('modules')
                        ->whereHas('modules')
                        ->orderBy('rank')
                        ->get()
                        ->map(function ($item) {
                            $item->items = $item->getAttribute('modules');
                            unset($item->modules);

                            return $item;
                        })
                );
        } else {
            $list = SiteModule::query()
                ->select([
                    'id',
                    'name',
                    'description',
                    'locked',
                    'disabled',
                    'category',
                ])
                ->orderBy('name')
                ->get();
        }

        return $this->ok($list);
    }
}
