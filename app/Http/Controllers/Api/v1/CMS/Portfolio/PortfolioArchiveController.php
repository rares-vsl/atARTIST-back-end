<?php

namespace App\Http\Controllers\Api\v1\CMS\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Portfolio\PortfolioInfoResource;
use App\Models\Portfolio;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PortfolioArchiveController extends Controller
{
    public function update(Portfolio $portfolio)
    {
        $this->authorize('ownsPortfolio', $portfolio);

        if (is_null($portfolio->archived_at)) {
            $archive = Carbon::now();
            $message = 'Portfolio archived successfully';
        } else {
            $archive = null;
            $message = 'Portfolio unarchived successfully';
        }

        $portfolio->update(['archived_at' => $archive]);

        return $this->successResponse(
            ['message' => $message,
            'portfolio' => new PortfolioInfoResource($portfolio)],
            200
        );
    }
}
