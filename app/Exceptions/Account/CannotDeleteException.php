<?php

namespace App\Exceptions\Account;

use App\Exceptions\Exception;

class CannotDeleteException extends Exception
{

    /**
     * Error message
     *
     * @var string
     */
    protected $message = 'Não foi possível excluir a conta financeira';

    /**
     * HTTP Status Code
     *
     * @var int
     */
    protected $code = 500;

}
