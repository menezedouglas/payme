<?php

namespace App\Exceptions\Transfer;

use App\Exceptions\Exception;

class CannotCreateNewTransferException extends Exception
{

    /**
     * @var string $message
     */
    protected $message = 'Não foi possível realizar a tranferência';

    /**
     * @var int $code
     */
    protected $code = 500;

}
