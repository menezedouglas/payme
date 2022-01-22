<?php

namespace App\Exceptions\Account;

use App\Exceptions\Exception;

class AccountNotFoundException extends Exception
{

    /**
     * Error message
     *
     * @var string
     */
    protected $message = 'Conta financeira não pode ser encontrada';

    /**
     * HTTP Status Code
     *
     * @var int
     */
    protected $code = 404;

}
