<?php

declare(strict_types=1);

namespace Manager\Http\Controllers;

use Illuminate\Contracts\View\View as ContractView;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadeAuth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class Auth extends Controller
{
    /**
     * @return ContractView
     */
    public function formLogin(): ContractView
    {
        return $this->view('template.login', []);
    }

    /**
     * @param Request $request
     *
     * @return array|RedirectResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
                'username' => ['required'],
                'password' => ['required'],
            ]
        );

        if (FacadeAuth::attempt($credentials)) {
            $request->session()->regenerate();

            $request->user()->setRememberToken(hash('sha256', $token = Str::random(60)));
            $request->user()->save();
            $request->session()->put('access_token', $token);

            if ($request->expectsJson()) {
                return [
                    'success' => true,
                    'redirect' => '/',
                    'token' => $token,
                ];
            }

            return Redirect::intended();
        }

        throw ValidationException::withMessages([
            'username' => __('global.login_processor_wrong_password'),
            'password' => __('global.login_processor_unknown_user'),
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function logout(Request $request)
    {
        FacadeAuth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return [
                'success' => true,
                'redirect' => '/',
            ];
        }

        return Redirect::to('/');
    }
}
