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

    public function read(array $params = []): JsonResponse
    {
        if (empty($params['id'])) {
            return $this->ok();
        }

        /** @var SiteTemplate $template */
        $template = SiteTemplate::query()
            ->with('tvs', fn($query) => $query->select([
                'id',
                'name',
                'caption',
                'description',
                'category',
            ]))
            ->findOrFail($params['id']);

        $tvs = Collection::wrap(Category::getNoCategoryTvs())
            ->merge(
                Category::query()
                    ->select([
                        'id',
                        'category as name',
                        'rank',
                    ])
                    ->with(
                        'tvs',
                        fn($query) => $query->whereKeyNot($template->tvs->pluck('id'))
                    )
                    ->whereHas('tvs')
                    ->orderBy('rank')
                    ->get()
                    ->filter(fn(Category $category) => $category->tvs->isNotEmpty())
                    ->each(function (Category $category) {
                        $category->setAttribute('items', $category->getAttribute('tvs'));
                        unset($category->tvs);
                    })
            );

        return $this->ok($template, [
            'tvs' => $tvs,
        ]);
    }
}
