<?php

namespace App\Exceptions\Transaction;

use App\Exceptions\Exception;

class TransactionNotFoundException extends Exception
{

    /**
     * @var string $message
     */
    protected $message = 'Não foi possível identificar a transação';

    /**
     * @var int $code
     */
    protected $code = 404;

}
