<?php

namespace App\Http\Controllers;

use App\Exceptions\Auth\LoginException;
use App\Http\Controllers\Controller;

use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\User\UserInterface;

class AuthController extends Controller
{

    protected UserInterface $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function login(LoginRequest $request)
    {
        try {

            $credentials = $request->all();

            $user = $this->user->where(['email' => $credentials['email']])->first();

            $guard = $user->type->name;

            if(!$token = auth($guard)->attempt($credentials))
                abort(401, 'Usuario ou senha incorretos');

            return response()->json(['authorization' => $token]);

        } catch (\Exception $error) {
            throw new LoginException($error);
        }
    }

    public function sendCodeToResetPassword() {}

    public function resetPassword() {}

    public function logout() {}

}
