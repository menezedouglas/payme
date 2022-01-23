<?php

namespace App\Exceptions\Transaction;

use App\Exceptions\Exception;

class CannotRollbackTransactionException extends Exception
{

    /**
     * @var string $message
     */
    protected $message = 'Não foi possível reverter a transação';

    /**
     * @var int $code
     */
    protected $code = 500;

}
