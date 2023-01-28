<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisteredUserRequest;
use App\Http\Resources\AuthUserInformationResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Avatar;

class RegisteredUserController extends Controller
{    
    public function store(RegisteredUserRequest $request)
    {
        $user = User::create([
            'name' => Str::title($request->name),
            'username' => Str::lower($request->username),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Avatar::create($user->name)
            ->save(public_path('media/profile/propic/propic-' . $user->id . '.png'));

        $token = $user->createToken('auth', [])->plainTextToken;

        event(new Registered($user));

        $data = [
            'token' => [
                'value' => $token,
                'expires_at' => null
            ],
            'user' => new AuthUserInformationResource($user)
        ];

        return $this->successResponse($data, 200);
    }
}
