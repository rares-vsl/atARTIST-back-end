<?php

namespace App\Http\Requests\v1\Portfolio;

use App\Http\Requests\ApiFormRequest;
use App\Http\Requests\v1\Rules\PortfolioRules;
use Illuminate\Http\Exceptions\HttpResponseException;

class DestroyPortfolioIconRequest extends ApiFormRequest
{
    public function authorize()
    {
        return $this->portfolio->icon;
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException($this->failResponse(
            ['message' => 'Portfolio doesn\'t have an icon'],
            404
        ));
    }

    public function rules()
    {
        return [];
    }
}
