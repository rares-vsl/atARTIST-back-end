<?php

namespace App\Http\Requests\v1\Gallery;

use App\Http\Requests\ApiFormRequest;
use App\Http\Requests\v1\Rules\GalleryRules;
use App\Http\Requests\v1\Rules\SectionRules;

class UpdateGalleryRequest extends ApiFormRequest
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
                SectionRules::name(),
                SectionRules::uniqueName($this->portfolio->id, $this->gallery->section_id)
            ),
            'description' => GalleryRules::description()
        ];
    }
}
