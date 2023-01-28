<?php

namespace App\Http\Resources\v1\Gallery;

use Illuminate\Http\Resources\Json\JsonResource;

class GalleriesResource extends JsonResource
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
            'posts_count' => $this->posts_count,
            'index' => $this->index,
            'description' => $this->description,
            //'trash' => $this->trashed(),
            'archived' => $this->isArchived(),
        ];     
        
    }
}
