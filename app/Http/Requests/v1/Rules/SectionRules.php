<?php

namespace App\Http\Requests\v1\Rules;

use Illuminate\Validation\Rule;

class SectionRules
{
    public static function name()
    {
        return [
            'required',
            'string',
            'min:2',
            'max:32',
            'regex:/^[A-Za-z0-9\s]+$/',
        ];
    }

    public static function nameMsg()
    {
        return 'The name can contain only letters and numbers';
    }

    public static function uniqueName($portfolio_id, $section_id = null)
    {
        return [
            Rule::unique('sections')
                ->where(fn ($query) => $query->where('portfolio_id', $portfolio_id))
                ->ignore($section_id)
        ];
    }
}

