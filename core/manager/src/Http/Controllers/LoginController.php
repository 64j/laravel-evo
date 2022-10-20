<?php

declare(strict_types=1);

namespace Manager\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @var string
     */
    protected string $view = 'template.login';

    public function test()
    {
        return [];
    }

    /**
     * @return bool
     */
    public function run(Request $request): bool
    {
        dD($request);

        $user = User::query()->find(1);

        dd(Auth::login($user));
        dd(Auth::validate([]));
        dd($this->kernel->getApplication()->request);
        $credentials = $request->getCredentials();

        $user = User::query()->find(1);

        Auth::login($user);

        $this->parameters = [
            'test' => 'test',
            'errors' => collect()
        ];

        return true;
    }
}
