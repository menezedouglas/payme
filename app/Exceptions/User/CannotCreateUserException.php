<?php

namespace App\Exceptions\User;

use App\Exceptions\Exception;

class CannotCreateUserException extends Exception
{

    /**
     * @var string $message
     */
    protected $message = 'Não foi possível registrar o novo usuário';

    /**
     * @var int $code
     */
    protected $code = 500;

}
