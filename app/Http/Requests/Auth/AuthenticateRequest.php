<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiFormRequest;
use App\Http\Requests\Rules;

class AuthenticateRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email'  => Rules::email(),
            'password' => Rules::password(),
            'remember_me' => Rules::remembrerMe()
        ];
    }
}
