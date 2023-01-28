<?php

namespace App\Http\Resources\v1\Portfolio;

use Illuminate\Http\Resources\Json\JsonResource;

class NewPortfolioResource extends JsonResource
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
            'active' => true,
            'archived' => false,
            'galleries_count' => 1,
            'sections' => $this->CMSSectionsWithInfo()

        ];
    }
}
