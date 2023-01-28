<?php

namespace App\Http\Requests\v1\Portfolio;

use App\Http\Requests\ApiFormRequest;
use App\Http\Requests\v1\Rules\PortfolioRules;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreatePortfolioRequest extends ApiFormRequest
{
    public function authorize()
    {
        return $this->user()->portfolio()->doesntExist();
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException($this->failResponse(
            ['message' => 'User has alreay a portfolio'],
            409
        ));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => array_merge(PortfolioRules::name(), PortfolioRules::uniquename())
        ];
    }
}
