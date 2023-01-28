<?php

namespace App\Http\Resources\v1\Gallery;

use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
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
            'category' => $this->category,
            'slug' => $this->slug,
            'name' => $this->name,
            'posts_count' => $this->gallery?->postCount(),
            'index' => $this->gallery?->index,
            'description' => $this->gallery?->description,
            'archived' => $this->isArchived(),
        ];
    }
}
