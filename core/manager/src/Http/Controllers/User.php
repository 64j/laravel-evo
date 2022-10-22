<?php

declare(strict_types=1);

namespace Manager\Http\Controllers;

use App\Models\UserAttribute;
use Illuminate\Http\JsonResponse;

class User extends Controller
{
    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return $this->ok(
            UserAttribute::query()
                ->with(['user', 'userRole'])
                ->get()
                ->map(function (UserAttribute $userAttribute) {
                    $userAttribute->setRawAttributes([
                        'id' => $userAttribute->internalKey,
                        'username' => $userAttribute->user->username,
                        'fullname' => $userAttribute->fullname,
                        'role' => $userAttribute['userRole']->name,
                        'email' => $userAttribute->email,
                        'lastlogin' => $userAttribute->lastlogin,
                        'logincount' => $userAttribute->logincount,
                        'blocked' => $userAttribute->blocked,
                    ]);

                    unset($userAttribute->user);
                    unset($userAttribute->userRole);

                    return $userAttribute;
                })
        );
    }
}
