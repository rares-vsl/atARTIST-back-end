<?php

namespace App\Http\Requests\v1\Post;

use App\Http\Requests\ApiFormRequest;
use App\Http\Requests\v1\Rules\PostRules;

class UpdatePostRequest extends ApiFormRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => PostRules::title(),
            'description' => PostRules::description(),
            'media' => 'image'
        ];
    }
}
