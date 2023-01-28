<?php

namespace App\Http\Controllers\Api\v1\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Gallery\ShowPublicGalleryRequest;
use App\Http\Resources\v1\Gallery\GalleryResource;
use App\Http\Resources\v1\Gallery\PublicGalleryResource;
use App\Models\Gallery;
use App\Models\Portfolio;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GalleryController extends Controller
{
    public function show(
        ShowPublicGalleryRequest $request,
        Portfolio $portfolio,
        Gallery $gallery
    ) {

        return $this->successResponse(
            ['section' => new PublicGalleryResource(
                $gallery->load('posts')
            )],
            200
        );
    }
}
