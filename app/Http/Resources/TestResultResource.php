<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestResultResource extends JsonResource
{
   public function toArray($request)
    {
        return [
            'id' => $this->id,
            'amount' => $this->value,
            'test_name' => $this->test->test_name ?? '',
            'test_code' => $this->test->test_code ?? '',
        ];
        
    }

}
