<?php

namespace App\Exceptions\Requests;

use App\Exceptions\Exception;

class RequestException extends Exception
{

    /**
     * Error message
     *
     * @var string
     */
    protected $message = 'Houve um erro ao tentar validar os dados da requisição';

    /**
     * HTTP Status Code
     *
     * @var int
     */
    protected $code = 422;

}
