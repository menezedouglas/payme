<?php

namespace App\Exceptions\User;

use App\Exceptions\Exception;

class CannotEditUserException extends Exception
{

    /**
     * @var string $message
     */
    protected $message = 'Não foi possível editar o registro do usuário';

    /**
     * @var int $code
     */
    protected $code = 500;

}
