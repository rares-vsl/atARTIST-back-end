<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ConfirmablePasswordRequest;
use App\Http\Requests\v1\User\UpdateUserRequest;
use App\Http\Resources\AuthUserInformationResource;
use App\Http\Resources\v1\User\UserProfileResource;
use App\Models\User;
use Str;
use Avatar;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{    
    public function show(User $user)
    {
        return $this->successResponse(
            ['user' => new UserProfileResource($user)],
            200
        );
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('ownsAccount', $user);

        $user->update([
            'name' => Str::title($request->name),
        ]);

        if (!$user->propic) {
            Avatar::create($user->name)
                ->save(public_path('media/profile/propic/propic-' . $user->id . '.png'));
        }

        $response = [
            'message' => 'Name updated successfully',
            'user' => new AuthUserInformationResource($user),
        ];

        return $this->successResponse($response, 200);
    }

    public function destroy(User $user)
    {
        $this->authorize('ownsAccount', $user);
        
        Auth::user()->tokens()->delete();
        $user->delete();

        return $this->successResponse(
            ['message' => 'User deleted successfully'],
            200
        );
    }
}
