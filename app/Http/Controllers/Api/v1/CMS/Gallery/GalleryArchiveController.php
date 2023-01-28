<?php

namespace App\Http\Controllers\Api\v1\CMS\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Portfolio;
use Carbon\Carbon;

class GalleryArchiveController extends Controller
{
    public function update(Portfolio $portfolio, Gallery $gallery)
    {
        $this->authorize('ownsPortfolio', $portfolio);

        $section =  $gallery->section;

        $galleryIndex = $gallery->index;
        $maxIndex     = $portfolio->publicGalleriesCount();


        if ($gallery->isArchived()) {
            $archive = null;
            $this->unarchive($portfolio, $gallery, $galleryIndex,  $maxIndex);
            $message = 'Gallery unarchived successfully';
        } else {
            $archive = Carbon::now();
            $this->archive($portfolio, $galleryIndex,  $maxIndex);
            $message = 'Gallery archived successfully';
        }

        $section->update(['archived_at' => $archive]);

        return $this->successResponse(
            [
                'message' => $message,
                'galleries' => $portfolio->getCMSGalleries()
            ],
            200
        );
    }

    private function unarchive(Portfolio $portfolio, Gallery $gallery, $galleryIndex,  $maxIndex)
    {
        // se l'indice della galleria non è maggiore del numero di gallerie
        if ($galleryIndex <= $maxIndex)
            // la inseriamo tra le gallerie
            $portfolio->incrementPublicGalleriesIndex(
                $galleryIndex,
                $maxIndex
            );
        else // altrimenti la inseriamo alla fine
            $gallery->update([
                'index' => $maxIndex + 1
            ]);
    }

    private function archive(Portfolio $portfolio, $galleryIndex,  $maxIndex)
    {
        if ($galleryIndex < $maxIndex)
            $portfolio->decrementPublicGalleriesIndex(
                $galleryIndex + 1,
                $maxIndex
            );
    }
}
