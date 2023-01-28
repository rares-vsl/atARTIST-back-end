<?php

namespace App\Http\Resources\v1\Gallery;

use Illuminate\Http\Resources\Json\JsonResource;

class GalleriesPublicInfoResource extends JsonResource
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
            'url' =>  'galleries'.'/'.$this->section->slug,
            'name' => $this->section->name,
            'index' => $this->index,
        ];
    }
}
