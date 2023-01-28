<?php

namespace App\Http\Resources\v1\Post;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug, 
            'thumbnail' => env('MEDIA_APP_URL') .'/'. $this->mediaURL() . 'thumbnail/'. $this->media,
            'media' =>  env('MEDIA_APP_URL') .'/'. $this->mediaURL() .  $this->media
        ];
    }
}
