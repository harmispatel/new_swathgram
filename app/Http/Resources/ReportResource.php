<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    public function toArray($request)
    {
        $testNames = [];
        foreach ($this->reports as $report) {
            foreach ($report->testResults as $testResult) {
                $testName = optional($testResult->test)->test_name;

                if ($testName && !in_array($testName, $testNames)) {
                    $testNames[] = $testName;
                }
            }
        }

        return [
            'patient_id'=>$this->id,
            'patient_code'=>$this->patient_code,
            'patient_name'       => $this->username,
            'age'            => $this->age,
            'gender' => $this->gender === 'male' ? 'M' : ($this->gender === 'female' ? 'F' : 'O'),
            'registered_at' => date('d-m-Y', strtotime($this->registered_at)),
            'test_names'     => implode(', ', $testNames), 
            'late_tested' => date('d-m-Y H:i', strtotime($report->created_at)),
            'status' =>$report->status, 
            'comments'=>$report->comments
        
        ];
    }

}
