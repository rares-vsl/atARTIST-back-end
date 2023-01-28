<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AvailableEmailRequest;
use App\Http\Requests\Auth\UpdateEmailRequest;
use App\Http\Resources\AuthUserInformationResource;
use App\Models\User;

class EmailController extends Controller
{
    public function show(AvailableEmailRequest $request)
    {
        return $this->successResponse(
            ['message' => $request->email . ' is a valid email.'],
            200
        );
    }

    public function update(UpdateEmailRequest $request, User $user)
    {
        $this->authorize('ownsAccount', $user);

        $user->update(['email' => $request->email]);

        $response = [
            'message' => 'Username updated successfully',
            'user' => new AuthUserInformationResource($user),
        ];

        return $this->successResponse($response, 200);
    }
}
