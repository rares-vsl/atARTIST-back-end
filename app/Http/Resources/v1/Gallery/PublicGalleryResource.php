<?php

namespace App\Http\Resources\v1\Gallery;

use App\Http\Resources\v1\Post\PostResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicGalleryResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'category' => $this->section->category,
            'slug' => $this->section->slug,
            'name' => $this->section->name,
            'description' => $this->description,
            'posts' => PostResource::collection(
                $this->posts
            )
        ];
    }
}
