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
                
                $testNames = [];
                $totalValue = 0;
                foreach ($data->reports as $report) {
                    foreach ($report->testResults as $testResult) {
                        if ($testResult->test) {
                            $testNames[] = $testResult->test->test_name;
                        }
                    }

                    if (is_numeric($testResult->value)) {
                        $totalValue += $testResult->value;
                    }
                }
               

                return [
                    'id'=>(int) $data->id,
                    'patient_name' => $data->username,  
                    'tests' => implode(', ', array_unique($testNames)),
                    'age'=>$data->age,
                    'cost' => $totalValue
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
