<?php

namespace App\Http\Requests\v1\User;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class DestroyUserPropicRequest extends ApiFormRequest
{
    public function authorize()
    {
        return $this->user->propic;
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException($this->failResponse(
            ['message' => 'User doesn\'t have a profile picture'],
            404
        ));
    }

    public function rules()
    {
        return [];
    }
}
