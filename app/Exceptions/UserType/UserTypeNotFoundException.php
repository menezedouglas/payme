<?php

namespace App\Exceptions\UserType;

use App\Exceptions\Contracts\ExceptionInterface;

use Illuminate\Http\JsonResponse;

use Exception;

class UserTypeNotFoundException extends Exception implements ExceptionInterface
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
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = 'Não foi possível identificar o tipo de usuario', int $code = 404)
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
