<?php

namespace App\Http\Middleware;

use App\Traits\JSONResponse;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    use JSONResponse;
    
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
        abort($this->failResponse(['message' => 'Unauthenticated'], 401));
    }
}
