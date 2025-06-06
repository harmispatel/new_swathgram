<?php

namespace App\Http\Resources;

use App\Models\Report;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PatientCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
     public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {

                $patient_id = $data->id;
                $report = Report::where('patient_id',$patient_id)->with('patient','organization','testResults')->orderBy('id','desc')->get();
                

                return [
                    'id'=>(int) $data->id,
                    'patient_name' => $data->username,  
                    'age'=>$data->age,
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
