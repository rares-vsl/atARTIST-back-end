<?php

namespace App\Http\Controllers\Api\v1\CMS\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Portfolio\DestroyPortfolioIconRequest;
use App\Http\Requests\v1\Portfolio\UpdatePortfolioIconRequest;
use App\Http\Resources\v1\Portfolio\PortfolioInfoResource;
use App\Models\Portfolio;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class PortfolioIconController extends Controller
{
    public function show(Portfolio $portfolio)
    {
        return $this->successResponse(
            ['has_icon' => boolval($portfolio->icon)],
            200
        );
    }

    public function update(UpdatePortfolioIconRequest $request, Portfolio $portfolio)
    {
        $this->authorize('ownsPortfolio', $portfolio);

        $path = $request->icon->storeAs(
            'portfolio/icon',
            'icon-' . $portfolio->id . '.png'
        );

        $image = Image::make(
            public_path('media/' . $path)
        )->fit(320, 320);

        $image->save();

        $portfolio->update(['icon' => true]);

        return $this->successResponse(
            [
                'message' => 'Portfolio\'s icon updated successfully',
                'portfolio' => new PortfolioInfoResource($portfolio)
            ],
            200
        );
    }

    public function destroy(DestroyPortfolioIconRequest $request, Portfolio $portfolio)
    {
        $this->authorize('ownsPortfolio', $portfolio);

        File::delete($portfolio->icon());
        $portfolio->update(['icon' => false]);

        return $this->successResponse(
            [
                'message' => 'Portfolio\'s icon removed successfully',
                'portfolio' => new PortfolioInfoResource($portfolio)
            ],
            200
        );
    }
}
