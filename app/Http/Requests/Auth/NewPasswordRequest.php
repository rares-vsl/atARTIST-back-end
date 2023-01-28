<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiFormRequest;
use App\Http\Requests\Rules;

class NewPasswordRequest extends ApiFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'token' => 'required',
            'email' => array_merge(Rules::email(), Rules::existsEmail()),
            'password' => Rules::password(),
            'password_confirmation' => Rules::confirmPassword()

        ];
    }
}
