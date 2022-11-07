<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    use HttpResponses;

    /**
     * REGISTER
     */
    public function __invoke (StoreUserRequest $request)
    {
        $request->validated($request->all());

        $user = User::create([
            'name' => $request->name, // name is coming from Register.vue
            'username' => $request->username, // username is coming from Register.vue
            'email' => $request->email, // email is coming from Register.vue
            'password' => Hash::make($request->password), // password is coming from Register.vue
        ]);

        // try to log the user in
        try {
            Auth::attempt($request->only('username', 'password'));
        }
        catch (\Exception $e)
        {
            \Log::info(['RegisterController', $e->getMessage()]);

            return [
                'success' => false,
                'msg' => 'problem with login'
            ];
        }

        return $this->success([
            'user' => $user,
//            'token' => $user->createToken("API token of $user->name")->plainTextToken
        ]);
    }
}
