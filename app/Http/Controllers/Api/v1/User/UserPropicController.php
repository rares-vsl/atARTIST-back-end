<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\User\DestroyUserPropicRequest;
use App\Http\Requests\v1\User\UpdateUserPropicRequest;
use App\Http\Resources\AuthUserInformationResource;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Avatar;
use Illuminate\Support\Str;

class UserPropicController extends Controller
{
    public function show(User $user)
    {
        $this->authorize('ownsAccount', $user);
        
        return $this->successResponse(
            ['has_propic' => boolval($user->propic)],
            200
        );
    }

    public function update(UpdateUserPropicRequest $request, User $user)
    {
        $this->authorize('ownsAccount', $user);

        $path = $request->propic->storeAs(
            'profile/propic',
            'propic-' . $user->id . '.png'
        );

        $image = Image::make(
            public_path('media/' . $path)
        )->fit(320, 320);

        $image->save();

        $user->update(['propic' => true]);

        $response = [
            'message' => 'Profile picture updated successfully',
            'user' => new AuthUserInformationResource($user),
        ];

        return $this->successResponse(
            $response,
            200
        );
    }

    public function destroy(DestroyUserPropicRequest $request, User $user)
    {
        $this->authorize('ownsAccount', $user);

        Avatar::create($user->name)
            ->save(public_path('media/profile/propic/propic-' . $user->id . '.png'));

        $user->update(['propic' => false]);

        $response = [
            'message' => 'Profile picture removed successfully',
            'user' => new AuthUserInformationResource($user),
        ];

        return $this->successResponse($response, 200);
    }
}
