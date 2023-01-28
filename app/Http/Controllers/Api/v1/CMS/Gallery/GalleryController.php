<?php

namespace App\Http\Controllers\Api\v1\CMS\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Gallery\CreateGalleryRequest;
use App\Http\Requests\v1\Gallery\UpdateGalleryRequest;
use App\Http\Resources\v1\Gallery\GalleryResource;
use App\Models\Gallery;
use App\Models\Portfolio;
use App\Models\Section;
use App\Models\SectionCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GalleryController extends Controller
{

    public function index(Portfolio $portfolio)
    {
        $this->authorize('ownsPortfolio', $portfolio);
        return $this->successResponse(
            [
                'galleries' => $portfolio->getCMSGalleries()
            ],
            200
        );
    }

    public function store(CreateGalleryRequest $request, Portfolio $portfolio)
    {
        DB::beginTransaction();

        $this->authorize('ownsPortfolio', $portfolio);

        $index = $portfolio->publicGalleriesCount() + 1;

        $section = Section::create([
            'portfolio_id' => $portfolio->id,
            'category'     => SectionCategory::gallery(),
            'name'         => Str::title($request->name),
            'slug'         => Str::slug($request->name, '-')
        ]);

        $gallery = Gallery::create([
            'section_id' => $section->id,
            'index' => $index,
            'description' => $request->description,
        ]);

        DB::commit();

        return $this->successResponse(
            [
                'message' => 'Gallery created successfully',
                'gallery' => [
                    'slug' => $section->slug,
                    'name' => $section->name,
                    'index' => $gallery->index,
                    'description' => $gallery->description,
                    'posts_count' => 0
                ]
            ],
            200
        );
    }

    public function show(Portfolio $portfolio, $slug)
    {
        $this->authorize('ownsPortfolio', $portfolio);

        $section = Section::resolveGallery($portfolio->id, $slug);

        return $this->successResponse(
            ['gallery' => new GalleryResource($section->load('gallery'))],
            200
        );
    }

    public function update(UpdateGalleryRequest $request, Portfolio $portfolio, Gallery $gallery)
    {
        $this->authorize('ownsPortfolio', $portfolio);

        $section = $gallery->section;


        $section->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-')
        ]);

        $gallery->update([
            'description' => $request->description
        ]);

        
        return $this->successResponse(
            [
                'message' => 'Gallery updated successfully',
                'gallery' => [
                    'category'=> 'gallery',
                    'slug' => $section->slug,
                    'name' => $section->name,
                    'index' => $gallery->index,
                    'description' => $gallery->description,
                    'posts_count' => $gallery->postCount()
                ]
            ],
            200
        );
    }

    public function destroy(Portfolio $portfolio, Gallery $gallery)
    {
        $this->authorize('ownsPortfolio', $portfolio);

        $section = $gallery->section;

        // Se non è archiviata è necessario ridistribuire gli indici
        if (!$gallery->isArchived()) {
            $portfolio->decrementPublicGalleriesIndex(
                $gallery->index + 1,
                $portfolio->publicGalleriesCount()
            );
        }
        // Invalidiamo l'indice
        $gallery->update([
            'index' => 0
        ]);

        $section->delete();

        return $this->successResponse(
            [
                'message' => 'Gallery deleted successfully',
                'galleries' => $portfolio->getCMSGalleries()
            ],
            200
        );
    }
}
