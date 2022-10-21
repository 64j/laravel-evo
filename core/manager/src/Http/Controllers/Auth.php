<?php

declare(strict_types=1);

namespace Manager\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadeAuth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class Auth extends Controller
{
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

            if ($request->expectsJson()) {
                return [
                    'success' => true,
                    'redirect' => '/',
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
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        FacadeAuth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
