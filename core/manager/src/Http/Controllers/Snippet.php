<?php

declare(strict_types=1);

namespace Manager\Http\Controllers;

use App\Models\Category;
use App\Models\SiteHtmlsnippet;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class Snippet extends Controller
{
    /**
     * @param array $params
     *
     * @return JsonResponse
     */
    public function list(array $params = []): JsonResponse
    {
        if (!empty($params['categories'])) {
            $list = Collection::wrap(Category::getNoCategorySnippets())
                ->merge(
                    Category::query()
                        ->select(['id', 'category as name', 'rank'])
                        ->with('snippets')
                        ->whereHas('snippets')
                        ->orderBy('rank')
                        ->get()
                        ->map(function ($item) {
                            $item->items = $item->getAttribute('snippets');
                            unset($item->snippets);

                            return $item;
                        })
                );
        } else {
            $list = SiteHtmlsnippet::query()
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
