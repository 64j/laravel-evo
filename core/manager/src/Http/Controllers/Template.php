<?php

declare(strict_types=1);

namespace Manager\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class Template extends Controller
{
    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return $this->ok(
            Collection::wrap(Category::getNoCategoryTemplates())
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
                )
        );
    }
}
