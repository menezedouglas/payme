<?php

namespace App\Http\Requests\Contracts;

interface BaseRequestInterface
{
    /**
     * Return rules for request validation
     *
     * @return string[]
     */
    public function rules(): array;

    /**
     * Return attributes names of request
     *
     * @return string[]
     */
    public function attributes(): array;

    /**
     * Return errors messages of validation
     *
     * @return string[]
     */
    public function messages(): array;
}
