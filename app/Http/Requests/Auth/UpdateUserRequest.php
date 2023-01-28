<?php

namespace App\Http\Requests\Auth;

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
            'username' => array_merge(
                Rules::username(),
                Rules::uniqueUsername($this->user()->id)
            ),
            'name' => Rules::name(),
        ];
    }
}
