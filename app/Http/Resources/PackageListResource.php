<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageListResource extends JsonResource
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
            'package_name'  => $this->package_name ?? null,
            'package_price' => $this->price ?? null,
            'package_type' => $this->package_type??null,
            'tests' => $this->tests->pluck('test_name')
        ];
    }
}
