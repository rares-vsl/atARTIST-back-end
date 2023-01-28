<?php

namespace App\Http\Requests\v1\User;

use App\Http\Requests\ApiFormRequest;
use App\Http\Requests\Rules;

class UpdateUsernameRequest extends ApiFormRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username'  => array_merge(Rules::username(), Rules::uniqueUsername($this->user->id)),
        ];
    }

    public function messages()
    {
        return [
            'username.regex' => Rules::usernameMsg()
        ];
    }
}
