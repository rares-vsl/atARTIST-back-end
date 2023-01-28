<?php

namespace App\Http\Controllers\Api\v1\CMS\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Gallery\UpdateGalleryIndexRequest;
use App\Models\Gallery;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class GalleryIndexController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function update(
        UpdateGalleryIndexRequest $request,
        Portfolio $portfolio,
        Gallery $gallery
    ) {
        $this->authorize('ownsPortfolio', $portfolio);
        if (!$gallery->isArchived()) {
            $newIndex = $request->index;
            $currentIndex = $gallery->index;

            if ($newIndex < $currentIndex) {
                $portfolio->incrementPublicGalleriesIndex(
                    $newIndex,
                    $currentIndex - 1
                );
            } else {
                $portfolio->decrementPublicGalleriesIndex(
                    $currentIndex + 1,
                    $newIndex
                );
            }
        }
        
        $gallery->update([
            'index' => $request->index
        ]);
        return $this->successResponse(
            [
                'message' => 'Gallery\'s index updated successfully',
                'galleries' => $portfolio->getCMSGalleries()
            ],
            200
        );
    }
}
