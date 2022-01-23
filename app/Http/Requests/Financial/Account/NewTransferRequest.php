<?php

namespace App\Http\Requests\Financial\Account;

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
            'amount' => 'required|numeric|min:1',
            'to' => 'required',
            'type' => 'required|string'
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
            'amount.required' => 'O :attribute é obrigatório',
            'amount.numeric' => 'O :attribute é inválido',
            'amount.min' => 'O :attribute precisa ser maior ou igual a 1',
            'to.required' => 'O :attribute é obrigatório',
            'type.required' => 'O :attribute é obrigatório',
            'type.string' => 'O :attribute é inválido'
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
            'amount' => 'Montante',
            'to' => 'Beneficiário',
            'type' => 'Tipo'
        ];
    }

}
