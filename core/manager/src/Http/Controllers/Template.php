<?php

declare(strict_types=1);

namespace Manager\Http\Controllers;

use App\Models\Category;
use App\Models\SiteTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class Template extends Controller
{
    /**
     * @param array $params
     *
     * @return JsonResponse
     */
    public function list(array $params = []): JsonResponse
    {
        if (!empty($params['categories'])) {
            $list = Collection::wrap(Category::getNoCategoryTemplates())
                ->merge(
                    Category::query()
                        ->select(['id', 'category as name', 'rank'])
                        ->with('templates')
                        ->whereHas('templates')
                        ->orderBy('rank')
                        ->get()
                        ->map(function ($item) {
                            $item->items = $item->getAttribute('templates');
                            unset($item->templates);

                            return $item;
                        })
                );
        } else {
            $list = SiteTemplate::query()
                ->select([
                    'id',
                    'templatename as name',
                    'templatealias as alias',
                    'description',
                    'locked',
                    'category',
                ])
                ->orderBy('templatename')
                ->get();
        }

        return $this->ok($list);
    }
}
