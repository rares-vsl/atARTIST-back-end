<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{

    public function update(UpdatePasswordRequest $request, User $user)
    {
        if (!Hash::check($request->old_password, $user->password)) {
            return $this->failResponse(
                ['message' => 'The provided password does not match our records.'],
                401
            );
        }

        $user->update(['password' => Hash::make($request->password)]);

        return $this->successResponse(
            ['message' => 'Password updated successfully'],
            200
        );
    }
}
