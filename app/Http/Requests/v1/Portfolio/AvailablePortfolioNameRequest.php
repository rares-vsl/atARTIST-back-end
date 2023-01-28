<?php

namespace App\Http\Requests\v1\Portfolio;

use App\Http\Requests\ApiFormRequest;
use App\Http\Requests\v1\Rules\PortfolioRules;

class AvailablePortfolioNameRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => array_merge(['required'], PortfolioRules::uniquename()),
        ];
    }
}
