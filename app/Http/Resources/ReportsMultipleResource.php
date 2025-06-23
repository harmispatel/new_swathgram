<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportsMultipleResource extends JsonResource
{
    public function toArray($request)
    {
        $testNames = [];
        $lastTestDate = null;
        foreach ($this->testResults as $testResult) {
            if ($testResult->test) {
                $testNames[] = $testResult->test->test_name;
            }

            if (!$lastTestDate || $testResult->created_at > $lastTestDate) {
                $lastTestDate = $testResult->created_at;
            }
        }

        return [
            'id'           => (int) $this->id,
            'patient_id'   => $this->patient->id,
            'patient_name' => $this->patient->username,
            'age'          => $this->patient->age,
            'gender'       => $this->patient->gender === 'male' ? 'M' : ($this->patient->gender === 'female' ? 'F' : 'O'),
            'register_at'  => date('d-m-Y', strtotime($this->patient->registered_at)),
            'create_at'    => date('d-m-Y H:i', strtotime($lastTestDate)),
            'patient_code'=> $this->patient->patient_code,
            'tests'        => implode(', ', array_unique($testNames)),
        ];
    }
}
