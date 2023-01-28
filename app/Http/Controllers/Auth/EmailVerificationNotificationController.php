<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    public function store(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->successResponse(
                ['message' => 'Your email has already been verified.'],
                200
            );
        }

        $request->user()->sendEmailVerificationNotification();
        
        return $this->successResponse(
            ['message' => 'Verification link sent!'],
            202
        );
    }
}
