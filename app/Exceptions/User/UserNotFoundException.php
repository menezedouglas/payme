<?php

namespace App\Exceptions\User;

use App\Exceptions\Contracts\ExceptionInterface;

use Illuminate\Http\JsonResponse;

use Exception;

class UserNotFoundException extends Exception implements ExceptionInterface
{

    /**
     * @var string $message
     */
    protected $message;

    /**
     * @var int $code
     */
    protected $code;

    /**
     * @param string|null $message
     * @param int|null $code
     */
    public function __construct(string $message = 'Não foi possível encontrar usuário', int $code = 404)
    {
        $this->message = $message;
        $this->code = $code;

        parent::__construct($message, $code);
    }

    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report(): ?bool
    {
        return null;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json(['error' => $this->message], $this->code);
    }

}
