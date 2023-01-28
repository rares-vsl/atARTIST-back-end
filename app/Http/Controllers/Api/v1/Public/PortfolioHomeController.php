<?php


namespace App\Http\Controllers\Api\v1\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Portfolio\ShowPublicPortfolioRequest;
use App\Http\Resources\v1\Gallery\PublicGalleryResource;
use App\Http\Resources\v1\Portfolio\PortfolioPublicResource;
use App\Models\Portfolio;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PortfolioHomeController extends Controller
{

    public function show(ShowPublicPortfolioRequest $request, Portfolio $portfolio)
    {
        return $this->successResponse(
            ['section' => new PublicGalleryResource(
                $portfolio->homeSection()
                    ->with('posts')
                    ->firstOrFail()
            )],
            200
        );
    }
}
