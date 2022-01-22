<?php

namespace App\Exceptions\Auth;

use App\Exceptions\Exception;

class UnauthorizedException extends Exception
{

    /**
     * @var string $message
     */
    protected $message = 'Não autorizado';

    /**
     * @var int $code
     */
    protected $code = 401;

}
