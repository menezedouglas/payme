<?php

namespace App\Exceptions\Transfer;

use App\Exceptions\Exception;

class TransferNoAuthorizedException extends Exception
{

    /**
     * @var string $message
     */
    protected $message = 'Você não foi autorizado a realizar esta transferência';

    /**
     * @var int $code
     */
    protected $code = 401;

}
