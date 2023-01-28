<?php

namespace App\Http\Requests\v1\Portfolio;

use App\Http\Requests\ApiFormRequest;
use App\Http\Requests\v1\Rules\PortfolioRules;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\JSONResponse;

class UpdatePortfolioRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => array_merge(
                PortfolioRules::name(),
                PortfolioRules::uniquename($this->portfolio->id)
            )
        ];
    }
}
