<?php

namespace App\Exceptions\User;

use App\Exceptions\Exception;

class UserNotFoundException extends Exception
{

    /**
     * @var string $message
     */
    protected $message = 'Não foi possível encontrar usuário';

    /**
     * @var int $code
     */
    protected $code = 404;

}
