<?php

namespace App\Http\Requests\Account;

use App\Http\Requests\BaseRequest;

class NewTransferRequest extends BaseRequest
{

    /**
     * Rules for input validation
     *
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'value' => 'required|numeric|min:1',
            'to' => 'required|numeric'
        ];
    }

    /**
     * Validation inputs name
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'email.required' => 'O :attribute é obrigatório',
            'password.required' => 'A :attribute é obrigatória'
        ];
    }

    /**
     * Validation errors messages
     *
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'email' => 'E-mail',
            'password' => 'Senha'
        ];
    }

}
