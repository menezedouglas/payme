<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator as ValidatorRequest;
use App\Http\Requests\Contracts\BaseRequestInterface;
use Exception;

class BaseRequest extends Validator implements BaseRequestInterface
{

    /**
     * Request for validation
     *
     * @var Request
     */
    protected Request $request;

    /**
     * Exclusive data for request validation
     *
     * @var ValidatorRequest
     */
    protected ValidatorRequest $validator;

    /**
     * Return all validated data
     *
     * @return array
     */
    public function all(): array
    {
        if(!$this->validate())
            throw new Exception(json_encode($this->validator->errors()->messages()), 422);

        return $this->request->all();
    }

    /**
     * Return specified and valid input
     *
     * @param string $key
     * @return mixed
     */
    public function input(string $key)
    {
        if(!$this->validate())
            throw new Exception(json_encode($this->validator->errors()->messages()), 422);

        return $this->request->input($key);
    }

    /**
     * Return rules for request validation
     *
     * @return string[]
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Return attributes names of request
     *
     * @return string[]
     */
    public function attributes(): array
    {
        return [];
    }

    /**
     * Return errors messages of validation
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * Constructor method
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Validate request data
     *
     * @return bool
     */
    protected function validate(): bool
    {
        $this->validator = Validator::make($this->request->all(), $this->rules(), $this->messages(), $this->attributes());

        return !$this->validator->fails();
    }

}
