<?php


namespace App\Http\Controllers\Api\v1\CMS;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Portfolio\PortfolioInfoResource;
use App\Models\User;
use Illuminate\Http\Request;

class CMSController extends Controller
{

    public function show(Request $request)
    {
        $portfolio = $request->user()->portfolio()->firstOrFail();

        $this->authorize('ownsPortfolio', $portfolio);
        
        return $this->successResponse(
            ['portfolio' => new PortfolioInfoResource($portfolio)],
            200
        );
    }
}
