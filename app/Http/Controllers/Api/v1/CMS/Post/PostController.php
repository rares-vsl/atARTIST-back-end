<?php

namespace App\Http\Controllers\Api\v1\CMS\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Post\CreatePostRequest;
use App\Http\Requests\v1\Post\UpdatePostRequest;
use App\Http\Resources\v1\Post\PostResource;
use App\Models\Gallery;
use App\Models\Portfolio;
use App\Models\Post;
use App\Traits\GenerateSlug;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    use GenerateSlug;

    public function store(CreatePostRequest $request, Portfolio $portfolio, Gallery $gallery)
    {
        $this->authorize('ownsPortfolio', $portfolio);

        DB::beginTransaction();

        $media = $request->media;

        $slug = $this->generateUniqueSlug('posts');

        $post = Post::create([
            'gallery_id' => $gallery->id,
            'title' => $request->title,
            'description' => $request->description,
            'slug' => $slug,
            'media' => $slug . '.' .  $media->extension(),
        ]);


        $media->storeAs(
            'posts/' . $portfolio->id,
            $post->media
        );

        $path = $media->storeAs(
            'posts/' . $portfolio->id . '/thumbnail',
            $post->media
        );

        $image = Image::make(public_path('media/' . $path))->fit(1200, 1200);

        $image->save();

        DB::commit();

        return $this->successResponse(
            [
                'message' => 'Post created successfully',
                'post' => new PostResource($post)
            ],
            200
        );
    }

    public function index(Portfolio $portfolio, Gallery $gallery)
    {

        $this->authorize('ownsPortfolio', $portfolio);

        return $this->successResponse([
            'posts' => PostResource::collection(
                $gallery->posts
            )
        ], 200);
    }

    public function destroy(Portfolio $portfolio, Gallery $gallery, Post $post)
    {
        $this->authorize('ownsPortfolio', $portfolio);

        File::delete('media/posts/' . $portfolio->id . '/thumbnail/' . $post->media);
        File::delete('media/posts/' . $portfolio->id . '/' . $post->media);

        $post->delete();

        return $this->successResponse([
            'message' => 'Post deleted successfully',
        ], 200);
    }

    public function show(
        Portfolio $portfolio,
        Gallery $gallery,
        Post $post
    ) {
        $this->authorize('ownsPortfolio', $portfolio);
        return $this->successResponse(
            [
                'post' => new PostResource($post)
            ],
            200
        );
    }
    public function update(
        UpdatePostRequest $request,
        Portfolio $portfolio,
        Gallery $gallery,
        Post $post
    ) {
        $this->authorize('ownsPortfolio', $portfolio);

        $post->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $media = $request->media;

        $data = [
            'message' => 'Post updated successfully',
            'post' => new PostResource($post)
        ];

        if (is_null($media))
            return $this->successResponse($data, 200);

        File::delete('media/posts/' . $portfolio->id . '/thumbnail/' . $post->media);
        File::delete('media/posts/' . $portfolio->id . '/' . $post->media);

        $slug = $this->generateUniqueSlug('posts');

        $post->update([
            'slug' => $slug,
            'media' => $slug . '.' .  $media->extension(),
        ]);

        $media->storeAs(
            'posts/' . $portfolio->id,
            $post->media
        );

        $path = $media->storeAs(
            'posts/' . $portfolio->id . '/thumbnail',
            $post->media
        );

        $image = Image::make(public_path('media/' . $path))->fit(1200, 1200);

        $image->save();

        return $this->successResponse($data, 200);
    }
}
