<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{

    /**
     * Rules for input validation
     *
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email:rfc', // Add ",dns" into email rules for production
            'cpf' => 'required',
            'cnpj' => 'nullable',
            'password' => 'required|string|min:6|max:20'
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
            'first_name.required' => 'O :attribute é obrigatório',
            'first_name.string' => 'Este formato para o :attribute não é aceito',
            'first_name.max' => 'É permitido até 255 caracteres para o :attribute',
            'last_name.required' => 'O :attribute é obrigatório',
            'last_name.string' => 'Este formato para o :attribute não é aceito',
            'last_name.max' => 'É permitido até 255 caracteres para o :attribute',
            'email.required' => 'O :attribute é obrigatório',
            'email.email' => 'O :attribute informado é inválido',
            'cpf.required' => 'O :attribute é obrigatório',
            'password.required' => 'A :attribute é obrigatória',
            'password.string' => 'A :attribute informado é inválida',
            'password.min' => 'A :attribute precisa ter no mínimo 6 caracteres',
            'password.max' => 'A :attribute precisa ter no máximo 6 caracteres'
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
            'first_name' => 'Primeiro Nome',
            'last_name' => 'Último Nome',
            'email' => 'E-mail',
            'cpf' => 'CPF',
            'cnpj' => 'CNPJ',
            'password' => 'Senha'
        ];
    }
}
