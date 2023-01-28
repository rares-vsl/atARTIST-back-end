<?php

namespace App\Http\Requests\v1\Rules;

use Illuminate\Validation\Rule;

class PortfolioRules
{
    public static function name()
    {
        return [
            'required',
            'string',
            'min:5',
            'max:32',
            'regex:/^[A-Za-z0-9\s]+$/',
        ];
    }

    public static function uniqueName($id = null)
    {
        return [
            Rule::unique('portfolios')->ignore($id)
        ];
    }

    public static function icon()
    {
        return [
            'required',
            'image',
        ];
    }
}
