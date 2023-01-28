<?php

namespace App\Http\Controllers\Api\v1\CMS\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Portfolio\AvailablePortfolioNameRequest;
use App\Traits\JSONResponse;

class PortfolioNameController extends Controller
{
    public function show(AvailablePortfolioNameRequest $request)
    {
        return $this->successResponse(
            ['message' => $request->name . ' is a valid name.'],
            200
        );
    }
}
