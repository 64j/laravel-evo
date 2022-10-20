<?php

declare(strict_types=1);

namespace Manager\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * @var string
     */
    protected string $view = 'template.login';

    public function run(Request $request)
    {
        if ($request->isMethod('POST')) {
            $credentials = $request->validate([
                'username' => ['required'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return Redirect::to('/');
            }
        }

        $this->parameters = [
            'test' => 'test',
            'errors' => collect()
        ];

        return $this->handle();
    }
}
