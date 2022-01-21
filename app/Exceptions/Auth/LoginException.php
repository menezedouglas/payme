<?php

namespace App\Exceptions\Auth;

use App\Exceptions\Exception;

class LoginException extends Exception
{

    /**
     * @var string $message
     */
    protected $message = 'Usuário ou senha incorretos';

    /**
     * @var int $code
     */
    protected $code = 401;

}
