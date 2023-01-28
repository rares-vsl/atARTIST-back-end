<?php

namespace App\Http\Controllers\Api\v1\CMS\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Portfolio\DeletedPortfolioRequest;
use App\Http\Resources\v1\Portfolio\PortfolioInfoResource;
use App\Models\Portfolio;

class PortfolioDeleteController extends Controller
{

    public function update(DeletedPortfolioRequest $request, $portfolioName)
    {
        $portfolio = Portfolio::onlyTrashed()->where('name', $portfolioName)->firstOrFail();

        $this->authorize('ownsPortfolio', $portfolio);

        $portfolio->restore();

        return $this->successResponse(
            [
                'message' => 'Portfolio restored successfully',
                'portfolio' => new PortfolioInfoResource($portfolio)
            ],
            200
        );
    }

    public function destroy(DeletedPortfolioRequest $request, $portfolioName)
    {
        $portfolio = Portfolio::withTrashed()->where('name', $portfolioName)->firstOrFail();

        $this->authorize('ownsPortfolio', $portfolio);

        $portfolio->forceDelete();

        return $this->successResponse(
            ['message' => 'Portfolio fully deleted successfully'],
            200
        );
    }
}
