<?php

declare(strict_types=1);

namespace Manager\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class Plugin extends Controller
{
    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return $this->ok(
            Collection::wrap(Category::getNoCategorySnippets())
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
                )
        );
    }
}
