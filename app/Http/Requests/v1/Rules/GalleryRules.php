<?php

namespace App\Http\Requests\v1\Rules;

class GalleryRules
{
    public static function description()
    {
        return [
            'required',
            'string',
            'max:255',
        ];
    }

    public static function index($max, $currentIndex)
    {
        return [
            'required',
            'integer',
            'min:1',
            'max:'.$max,
            'not_in:'.$currentIndex
        ];
    }
}
