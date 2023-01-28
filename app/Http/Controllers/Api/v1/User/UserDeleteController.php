<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UserDeleteController extends Controller
{
    public function update(Request $request,  $username)
    {
        $user = User::withTrashed()->where('username', $username)->firstOrFail();

        if (! $user->trashed())
            throw new HttpResponseException($this->failResponse(
                ['message' => 'This user isn\'t deleted'],
                404
            ));

        $token = $request->bearerToken();

        $personalAccessToken = PersonalAccessToken::findToken($token);

        if ($personalAccessToken == null)
            throw new UnauthorizedHttpException('');

        $auth = $personalAccessToken->tokenable()->withTrashed()->first();

        Auth::login($auth);

        $this->authorize('ownsAccount', $user);

        $user->restore();

        return $this->successResponse(
            ['message' => 'User restored successfully'],
            200
        );
    }
}
