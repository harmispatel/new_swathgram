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
            'name'  => $this->name ?? null,
            'email' => $this->email ?? null,
            'username' => $this->username??null,
            'gender' => $this->gender ?? null,
            'dob' => $this->dob ?? null,
            'contact' => $this->contact ?? null,
            'state' => $this->state ?? null,
            'city' => $this->city ?? null,
            'address' => $this->address ?? null,
            'pincode' => $this->pincode ?? null,
            'photo' => $this->photo ?? null,
        ];
    }
}
