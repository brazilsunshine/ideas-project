<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditProfileController extends Controller
{
    public function __invoke (Request $request)
    {
        $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'min:4', 'max:255', 'unique:users'],
        ]);

        try
        {
            $user = auth()->user();

            $user->name = $request->name;
            $user->username = $request->username;

            $user->save();
        }
        catch (\Exception $exception)
        {
            \Log::info(['EditProfileController', $exception->getMessage()]);

            return [
                'success' => false,
                'msg' => 'problem editing'
            ];
        }

        return [
            'success' => true,
            'user' => $user->load('profile_image')
        ];
    }
}
