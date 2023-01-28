<?php

namespace App\Http\Resources\v1\AboutMe;

use Illuminate\Http\Resources\Json\JsonResource;

class AboutMeSectionResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'archived' => $this->isArchived(),
            'biography' => $this->biography->bio,
            'contact' => $this->contact->email,
        ];
    }
}
