<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;

class LogoutController extends Controller
{
    use HttpResponses;

    /**
     * LOGOUT
     */
    public function __invoke ()
    {
        // Auth::user()->currentAccessToken()->delete();
        auth()->guard('web')->logout();

        return $this->success([
            'message' => 'You have successfully logged out!'
        ]);
    }
}
