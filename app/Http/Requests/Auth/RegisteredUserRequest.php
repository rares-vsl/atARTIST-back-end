<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiFormRequest;
use App\Http\Requests\Rules;
use Illuminate\Contracts\Validation\Validator;

class RegisteredUserRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username'  => array_merge(Rules::username(), Rules::uniqueUsername()),
            'name'  => Rules::name(),
            'email' => array_merge(Rules::email(), Rules::uniqueEmail()),
            'password' => Rules::password(),
            'password_confirmation' => Rules::confirmPassword()
        ];
    }
    
    public function messages()
    {
        return [
            'username.regex' => Rules::usernameMsg()
        ];
    }
}
