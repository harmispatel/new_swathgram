<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CamplistResource extends JsonResource
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
            'camp_name'  => $this->camp_name ?? null,
            'camp_start_date' => date('d-m-Y', strtotime($this->camp_start_date)) ?? null,
            'camp_end_date' => date('d-m-Y', strtotime($this->camp_end_date)) ?? null,
        ];
    }
}
