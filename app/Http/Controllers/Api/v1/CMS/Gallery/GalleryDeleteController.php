<?php

namespace App\Http\Controllers\Api\v1\CMS\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Gallery\GalleryResource;
use App\Models\Portfolio;
use App\Models\Section;
use Illuminate\Http\Exceptions\HttpResponseException;

class GalleryDeleteController extends Controller
{
    public function index(Portfolio $portfolio)
    {
        $this->authorize('ownsPortfolio', $portfolio);
        return $this->successResponse(
            [
                'galleries' => $portfolio->getDeletedGalleries()
            ],
            200
        );
    }

    public function update(Portfolio $portfolio, $slug)
    {
        $this->authorize('ownsPortfolio', $portfolio);

        $section = Section::resolveGallery($portfolio->id, $slug);

        $this->validateRequest($section);

        $section->restore();

        $index = $portfolio->publicGalleriesCount();
        $section->gallery->update([
            'index' =>  $index > 0 ? $index : 1
        ]);

        return $this->successResponse(
            [
                'message' => 'Gallery restored successfully',
                'gallery' => new GalleryResource($section->load('gallery'))
            ],
            200
        );
    }

    public function destroy(Portfolio $portfolio, $slug)
    {
        $this->authorize('ownsPortfolio', $portfolio);

        $section = Section::resolveGallery($portfolio->id, $slug);
    
        $this->validateRequest($section);

        $section->forceDelete();

        return $this->successResponse(
            ['message' => 'Gallery fully deleted'],
            200
        );
    }

    private function validateRequest(Section $section)
    {
        if (!$section->trashed())
            throw new HttpResponseException($this->failResponse(
                ['message' => 'This gallery isn\'t deleted'],
                404
            ));
    }
}
