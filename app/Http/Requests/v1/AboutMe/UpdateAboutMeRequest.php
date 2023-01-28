<?php

namespace App\Http\Requests\v1\AboutMe;

use App\Http\Requests\ApiFormRequest;
use App\Http\Requests\v1\Rules\AboutMeRules;

class UpdateAboutMeRequest extends ApiFormRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'biography' => AboutMeRules::biography(),
            'contact' => AboutMeRules::contact()
        ];
    }
}
