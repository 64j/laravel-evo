<?php

declare(strict_types=1);

namespace Manager\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class Chunk extends Controller
{
    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return $this->ok(
            Collection::wrap(Category::getNoCategoryChunks())
                ->merge(
                    Category::query()
                        ->select(['id', 'category as name', 'rank'])
                        ->with('chunks')
                        ->whereHas('chunks')
                        ->orderBy('rank')
                        ->get()
                        ->map(function ($item) {
                            $item->items = $item->getAttribute('chunks');
                            unset($item->chunks);

                            return $item;
                        })
                )
        );
    }
}
