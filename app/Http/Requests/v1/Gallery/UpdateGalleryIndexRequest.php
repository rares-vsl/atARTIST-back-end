<?php

namespace App\Http\Requests\v1\Gallery;

use App\Http\Requests\ApiFormRequest;
use App\Http\Requests\v1\Rules\GalleryRules;

class UpdateGalleryIndexRequest extends ApiFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'index' => GalleryRules::index(
                $this->portfolio->publicGalleriesCount(),
                $this->gallery->index
            )
        ];
    }
}
