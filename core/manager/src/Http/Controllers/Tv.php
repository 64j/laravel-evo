<?php

declare(strict_types=1);

namespace Manager\Http\Controllers;

use App\Models\Category;
use App\Models\SiteTmplvar;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class Tv extends Controller
{
    /**
     * @param array $params
     *
     * @return JsonResponse
     */
    public function list(array $params = []): JsonResponse
    {
        if (!empty($params['categories'])) {
            $list = Collection::wrap(Category::getNoCategoryTvs())
                ->merge(
                    Category::query()
                        ->select(['id', 'category as name', 'rank'])
                        ->with('tvs')
                        ->whereHas('tvs')
                        ->orderBy('rank')
                        ->get()
                        ->map(function ($item) {
                            $item->items = $item->getAttribute('tvs');
                            unset($item->tvs);

                            return $item;
                        })
                );
        } else {
            $list = SiteTmplvar::query()
                ->select([
                    'id',
                    'name',
                    'description',
                    'locked',
                    'category',
                ])
                ->orderBy('name')
                ->get();
        }

        return $this->ok($list);
    }
}
