<?php

namespace App\Services\Authentication;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\{
    Auth,
    Hash
};

use App\Exceptions\Auth\LoginException;
use App\Repositories\User\UserInterface;

class Login extends Auth
{
    /**
     * User Repository Interface
     *
     * @var UserInterface $user
     */
    protected UserInterface $user;

    /**
     * Authentication Guardian
     *
     * @var string $guardName
     */
    protected string $guardName;

    /**
     * User Authorization
     *
     * @var string $authorization
     */
    protected string $authorization;

    /**
     * Constructor Method
     *
     * @param Auth $auth
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * Authenticate user
     *
     * @param string $email
     * @param string $password
     * @return Login
     * @throws LoginException
     */
    public function make(string $email, string $password): Login
    {
        if (!$user = $this->user->where(['email' => $email])->first())
            throw new LoginException();

        $this->guardName = $user->type->name;

        if (!Hash::check($password, $user->password))
            throw new LoginException();

        if (!$this->authorization = static::guard($this->guardName)->login($user))
            throw new LoginException();

        return $this;
    }

    /**
     * Response authorization
     *
     * @return JsonResponse
     */
    public function response(): JsonResponse
    {
        return response()->json([
            'authorization' => $this->authorization,
            'type' => 'Bearer',
            'validate' => 3600
        ]);
    }
}
