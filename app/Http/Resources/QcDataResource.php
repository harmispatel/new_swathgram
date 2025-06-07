<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;


class QcDataResource  extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

      $created = Carbon::parse($this->created_time);

        return [
            'qc_id' => $this->qc_id,
            'L1' => $this->L1,
            'L2' => $this->L2,
            'C1' => $this->C1,
            'C2' => $this->C2,
            'C3' => $this->C3,
            'date' => $created->format('Y-m-d'),
            'time' => $created->format('H:i:s'),
            'status' => $this->status,
            'active' => $this->active,
            'test_name' => $this->test ? $this->test->test_name : null,
        ];

    }
}
