<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id'    => $this->id,
            'email' => $this->email ?? null,
            'username' => $this->username ?? null,
            'phone' => $this->phone ?? null,
            // 'photo' => $this->photo ?? null,
            'photo'    => $this->image 
                        ? asset('public/super_admin_uploads/users/' . $this->image)
                        : asset('public/admin_images/demo_images/profiles/profile1.jpg'),
            'address'=> $this->address ?? null,
            'remember' => $this->remember ?? null
        ];
    }
}
