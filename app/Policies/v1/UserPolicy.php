<?php

namespace App\Policies\v1;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    public function ownsAccount(User $auth, User $user)
    {
        return $auth->id === $user->id
            ? Response::allow()
            : Response::deny('');
    }
}
