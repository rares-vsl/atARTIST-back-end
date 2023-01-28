<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiFormRequest;
use App\Http\Requests\Rules;

class UpdatePasswordRequest extends ApiFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'old_password' => Rules::password(),
            'password' => Rules::password(),
            'password_confirmation' => Rules::confirmPassword()
        ];
    }
}
