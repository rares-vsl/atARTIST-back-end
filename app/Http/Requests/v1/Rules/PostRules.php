<?php

namespace App\Http\Requests\v1\Rules;

class PostRules
{
    public static function description()
    {
        return [
            'required',
            'string',
        ];
    }

    public static function title()
    {
        return [
            'required',
            'string',
            'max:50'
        ];
    }

    public static function media()
    {
        return [
            'required',
            'image',
        ];
    }
}
