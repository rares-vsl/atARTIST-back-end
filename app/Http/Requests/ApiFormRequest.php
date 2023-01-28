<?php

namespace App\Http\Requests;

use App\Traits\JSONResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiFormRequest extends FormRequest
{
    use JSONResponse;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        $errors = collect($validator->errors());

        $data = [];

        foreach ($errors as $key => $message) {
            $data[$key] = $message;
        }

        throw new HttpResponseException($this->errorResponse(
            ['errors' => $data],
            'Validation error',
            422
        ));
    }
}
