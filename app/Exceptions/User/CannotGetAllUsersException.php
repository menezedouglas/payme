<?php

namespace App\Exceptions\User;

use App\Exceptions\Exception;

class CannotGetAllUsersException extends Exception
{

    /**
     * @var string $message
     */
    protected $message = 'Não foi possível buscar todos os usuarios';

    /**
     * @var int $code
     */
    protected $code = 500;

}
