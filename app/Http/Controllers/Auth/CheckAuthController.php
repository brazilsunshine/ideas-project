<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class CheckAuthController extends Controller
{
    public function __invoke ()
    {
        $user = null;
        $auth = false;

        if (auth()->check())
        {
            $auth = true;
            $user = auth()->user();
        }

        return [
            'auth' => $auth,
            'user' => $user
        ];
    }
}
