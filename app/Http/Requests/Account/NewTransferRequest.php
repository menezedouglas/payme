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
            'value.required' => 'O :attribute é obrigatório',
            'value.numeric' => 'O :attribute é inválido',
            'value.min' => 'O :attribute precisa ser maior ou igual a 1',
            'to.required' => 'O :attribute é obrigatório',
            'to.numeric' => 'O :attribute é inválido'
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
            'value' => 'Valor',
            'to' => 'Beneficiário',
        ];
    }

}
