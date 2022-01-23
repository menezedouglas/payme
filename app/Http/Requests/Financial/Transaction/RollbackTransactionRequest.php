<?php

namespace App\Http\Requests\Financial\Transaction;

use App\Http\Requests\BaseRequest;

class RollbackTransactionRequest extends BaseRequest
{

    /**
     * Rules for input validation
     *
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'id' => 'required|numeric|min:1|exists:App\Models\Financial\Transaction'
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
            'id.required' => 'O :attribute é obrigatório',
            'id.numeric' => 'O :attribute é inválido',
            'id.min' => 'O valor mínimo para o :attribute é 1',
            'id.exists' => 'O :attribute não existe'
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
            'id' => 'Código da transação'
        ];
    }

}
