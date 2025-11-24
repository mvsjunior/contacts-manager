<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Authenticate;
use App\Actions\Logout;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    public function index()
    {
        if(auth('web')->check()){
            return response()->redirectTo(route('home.index'));
        }

        return view('auth.login');
    }

    public function auth(AuthRequest $request)
    {
        $authAction = new Authenticate(
                        $request->validated('email'),
                        $request->validated('password'), 
                        $request->validated('remember', false)
        );

        if($authAction->handle()){
            $request->session()->regenerate();
            return response()->redirectTo(route("home.index"));
        }

        Session::flash("message", "Incorrect email address or password.");
        return response()->redirectTo(route("login"));
    }
}
