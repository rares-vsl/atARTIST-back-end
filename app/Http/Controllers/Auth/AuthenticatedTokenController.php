<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthenticateRequest;
use App\Http\Resources\AuthUserInformationResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthenticatedTokenController extends Controller
{
    public function store(AuthenticateRequest $request)
    {
        $data = $request->except('remember_me');

        $user = User::withTrashed()->where('email', ($request->email))->first();

        if (!Hash::check($request->password, $user?->password)) {
            return $this->failResponse([
                'message' => 'These credentials do not match our records.',
            ], 401);
        }

        $token = $user->createToken('auth', []);

        if (!$request->remember_me)
            $token->accessToken->update(['expires_at' => now()->addDay(1)]);

        $data = [
            'token' => [
                'value' => $token->plainTextToken,
                'expires_at' => null
            ],
            'user' => new AuthUserInformationResource($user)
        ];
        return $this->successResponse($data, 200);
    }

    public function show(Request $request)
    {
        $token = $request->bearerToken();

        $personalAccessToken = PersonalAccessToken::findToken($token);

        if ($personalAccessToken == null)
            throw new UnauthorizedHttpException('');

        $user = $personalAccessToken->tokenable()->withTrashed()->first();

        return $this->successResponse(
            ['user' => new AuthUserInformationResource($user)],
            200
        );
    }

    public function destroy()
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->successResponse([
            'message' => 'User logged out.',
        ], 200);
    }
}
