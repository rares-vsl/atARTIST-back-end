<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordResetLinkRequest;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    public function store(PasswordResetLinkRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status != Password::RESET_LINK_SENT)
            return $this->failResponse(
                ['message' =>  __($status)],
                422
            );
            
        return $this->successResponse(
            ['message' => __($status)],
            200
        );
    }
}
