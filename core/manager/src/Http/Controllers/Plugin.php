<?php

declare(strict_types=1);

namespace Manager\Http\Controllers;

use App\Models\Category;
use App\Models\SitePlugin;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class Plugin extends Controller
{
    /**
     * @param array $params
     *
     * @return JsonResponse
     */
    public function list(array $params = []): JsonResponse
    {
        if (!empty($params['categories'])) {
            $list = Collection::wrap(Category::getNoCategoryPlugins())
                ->merge(
                    Category::query()
                        ->select(['id', 'category as name', 'rank'])
                        ->with('plugins')
                        ->whereHas('plugins')
                        ->orderBy('rank')
                        ->get()
                        ->map(function ($item) {
                            $item->items = $item->getAttribute('plugins');
                            unset($item->plugins);

                            return $item;
                        })
                );
        } else {
            $list = SitePlugin::query()
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
