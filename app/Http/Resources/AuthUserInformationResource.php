<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserInformationResource extends JsonResource
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
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email,
            'propic' => env('MEDIA_APP_URL') . '/profile/propic/propic-' . $this->id . '.png',
            // hasVerifiedEmail() form Illuminate\Auth\MustVerifyEmail
            // Determine if the user has verified their email address.
            'verified_email' => $this->hasVerifiedEmail(),
            // trashed() form Illuminate\Database\Eloquent\SoftDeletes
            // Determine if the model instance has been soft-deleted.
            'active' => !($this->trashed())
        ];
    }
}
