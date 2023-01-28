<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ConfirmablePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ConfirmablePasswordController extends Controller
{
    public function store(ConfirmablePasswordRequest $request)
    {
        if (!Hash::check($request->password, Auth::user()->password)) {
            return $this->failResponse([
                'message' => 'The provided password does not match our records.',
            ], 401);
        }

        $token = Auth::user()->createToken('auth', ['password.confirm']);
        $token->accessToken->update(['expires_at' => now()->addHour()]);

        $data = [
            'token' => $token->plainTextToken,
        ];
        
        return $this->successResponse($data, 200);
    }
}
