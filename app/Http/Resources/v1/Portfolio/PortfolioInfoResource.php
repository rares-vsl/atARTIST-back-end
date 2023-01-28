<?php

namespace App\Http\Resources\v1\Portfolio;

use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioInfoResource extends JsonResource
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
            'name' => $this->name,
            'icon' => env('SERVER_URL') . $this->icon(),
            // trashed() form Illuminate\Database\Eloquent\SoftDeletes
            // Determine if the model instance has been soft-deleted.
            'active' => !($this->trashed()),
            'archived' => $this->isArchived(),
            'galleries_count' => $this->publicGalleriesCount()
        ];
    }
}
