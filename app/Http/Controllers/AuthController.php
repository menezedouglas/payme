<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Exceptions\Auth\LoginException;
use App\Services\Authentication\Login;

class AuthController extends Controller
{

    /**
     * Login Service
     *
     * @var Login $login
     */
    protected Login $login;

    /**
     * Constructor Method
     *
     * @param Login $login
     */
    public function __construct(Login $login)
    {
        $this->login = $login;
    }

    /**
     * Authenticate User
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws LogicException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            return $this->login->make(
                $request->input('email'),
                $request->input('password')
            )->response();
        } catch (\Exception $error) {
            throw new LoginException($error);
        }
    }

    public function sendCodeToResetPassword() {}

    public function resetPassword() {}

    public function logout() {}

}
