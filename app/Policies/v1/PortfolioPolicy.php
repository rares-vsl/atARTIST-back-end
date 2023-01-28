<?php

namespace App\Policies\v1;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PortfolioPolicy
{
    use HandlesAuthorization;

    public function ownsPortfolio(User $user, Portfolio $portfolio){
        return $user->portfolio?->id === $portfolio->id
            ? Response::allow()
            : Response::deny();
    }
}
