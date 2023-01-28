<?php

namespace App\Http\Requests\v1\Portfolio;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeletedPortfolioRequest extends ApiFormRequest
{
    public function authorize()
    {
        $portfolio = $this->user()->portfolio()->firstOrFail();
        return $portfolio->deleted_at != null;
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException($this->failResponse(
            ['message' => 'User doesn\'t have a deleted portfolio'],
            404
        ));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [];
    }
}
