<?php

declare(strict_types=1);

namespace Manager\Http\Controllers;

use App\Models\UserRole;
use Illuminate\Http\JsonResponse;

class Role extends Controller
{
    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return $this->ok(
            UserRole::query()
                ->select([
                    'id',
                    'name',
                    'description',
                ])
                ->get()
        );
    }
}
