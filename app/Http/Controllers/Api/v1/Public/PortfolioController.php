<?php


namespace App\Http\Controllers\Api\v1\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Portfolio\ShowPublicPortfolioRequest;
use App\Http\Resources\v1\Portfolio\PortfolioPublicResource;
use App\Models\Portfolio;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PortfolioController extends Controller
{

    public function show(ShowPublicPortfolioRequest $request, Portfolio $portfolio)
    {
        return $this->successResponse(
            ['portfolio' => new PortfolioPublicResource($portfolio)],
            200
        );
    }
}
