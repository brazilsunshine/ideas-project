<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

class CheckAuthController extends Controller
{
    public function __invoke ()
    {
        $user = null;
        $auth = false;

        if (auth()->check())
        {
            $auth = true;
            $user = auth()->user()->load('profile_image');
        }

        return [
            'auth' => $auth,
            'user' => $user,
        ];
    }
}
