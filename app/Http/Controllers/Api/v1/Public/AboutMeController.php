<?php

namespace App\Http\Controllers\Api\v1\Public;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;

class AboutMeController extends Controller
{
    public function show(Portfolio $portfolio)
    {
        return $this->successResponse(
            ['section' => $portfolio->getAboutMeSection()],
            200
        );
    }
}
