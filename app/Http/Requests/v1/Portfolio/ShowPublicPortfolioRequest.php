<?php

namespace App\Http\Requests\v1\Portfolio;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowPublicPortfolioRequest extends ApiFormRequest
{
    public function authorize()
    {
        return ! $this->portfolio->isArchived() && $this->portfolio->publicGalleriesCount() > 0;
    }

    protected function failedAuthorization()
    {
        throw new NotFoundHttpException();
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
