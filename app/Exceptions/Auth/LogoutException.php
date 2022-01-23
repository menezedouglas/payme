<?php

namespace App\Exceptions\Auth;

use App\Exceptions\Exception;

class LogoutException extends Exception
{

    /**
     * @var string $message
     */
    protected $message = 'Não foi possível encerrar sua sessão';

    /**
     * @var int $code
     */
    protected $code = 500;

}
