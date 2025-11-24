<?php

namespace App\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Logout {

    private Request $request;

    public function handle(Request $request):void
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
    }
}