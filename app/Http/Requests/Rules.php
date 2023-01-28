<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class Rules
{
    public static function name()
    {
        return [
            'required',
            'string',
            'min:3',
            'max:100',
            'regex:/^[A-Za-z\s]+$/'
        ];
    }

    public static function username()
    {
        return [
            'required',
            'string',
            'min:4',
            'max:25',
            'regex: /^[A-Za-z0-9_]+$/',
            Rule::notIn(['auth', 'api'])
        ];
    }

    public static function usernameMsg()
    {
        return 'Username can contain only letters, numbers and underscore';
    }

    public static function uniqueUsername($id = null)
    {
        return [
            Rule::unique('users')->ignore($id),
            Rule::notIn(['auth', 'api'])
        ];
    }

    public static function email()
    {
        return [
            'required',
            'string',
            'max:255',
            'email',
        ];
    }

    public static function uniqueEmail($id = null)
    {
        return [
            Rule::unique('users')->ignore($id)
        ];
    }

    public static function existsEmail()
    {
        return [
            'exists:users',
        ];
    }

    public static function password()
    {
        return [
            'required',
            'string',
            Password::min(8)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols(),
        ];
    }

    public static function confirmPassword()
    {
        return [
            'required',
            'string',
            'same:password',
        ];
    }

    public static function remembrerMe()
    {
        return [
            'required',
            'boolean',
        ];
    }
}
