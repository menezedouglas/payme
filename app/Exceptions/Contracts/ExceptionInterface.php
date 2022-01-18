<?php

namespace App\Exceptions\Contracts;

use Illuminate\Http\JsonResponse;

interface ExceptionInterface
{
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report(): ?bool;

    /**
     * Render the exception into an HTTP response.
     *
     * @return JsonResponse
     */
    public function render(): JsonResponse;
}
