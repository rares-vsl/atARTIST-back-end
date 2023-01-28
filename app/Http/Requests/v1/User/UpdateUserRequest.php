<?php

namespace App\Http\Requests\v1\User;

use App\Http\Requests\ApiFormRequest;
use App\Http\Requests\Rules;

class UpdateUserRequest extends ApiFormRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'  => Rules::name(),
        ];
    }
}
