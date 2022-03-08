<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'manager'=> $this->manager,
            'email' => $this->email,
            'is_admin' => $this->is_admin,
            'pic' => $this->pic ? Storage::url($this->pic) : 'https://www.kindpng.com/picc/m/150-1503949_computer-icons-user-profile-male-profile-icon-png.png'
        ];
    }
}
