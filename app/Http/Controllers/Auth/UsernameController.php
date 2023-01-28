<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AvailableUsernameRequest;
use App\Http\Requests\v1\User\UpdateUsernameRequest;
use App\Http\Resources\AuthUserInformationResource;
use App\Models\User;
use Illuminate\Support\Str;

class UsernameController extends Controller
{
    public function show(AvailableUsernameRequest $request)
    {
        return $this->successResponse(
            ['message' => $request->username . ' is a valid username.'],
            200
        );
    }

    public function update(UpdateUsernameRequest $request, User $user)
    {
        $this->authorize('ownsAccount', $user);

        $user->update(['username' => Str::lower($request->username),]);

        $response = [
            'message' => 'Username updated successfully',
            'user' => new AuthUserInformationResource($user),
        ];

        return $this->successResponse(
            $response,
            200
        );
    }
}
