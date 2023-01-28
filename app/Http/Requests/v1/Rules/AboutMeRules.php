<?php

namespace App\Http\Requests\v1\Rules;

use Illuminate\Validation\Rule;

class AboutMeRules
{
    public static function biography()
    {
        return [
            'required',
            'string',
        ];
    }

    public static function contact()
    {
        return [
            'required',
            'string',
            'max:255',
            'email',
        ];
    }
}

