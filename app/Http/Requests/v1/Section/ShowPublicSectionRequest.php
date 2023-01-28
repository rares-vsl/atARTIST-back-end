<?php

namespace App\Http\Requests\v1\Section;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowPublicSectionRequest extends ApiFormRequest
{
    public function authorize()
    {
        return ! $this->portfolio->isArchived() && !  $this->section->isArchived();
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
