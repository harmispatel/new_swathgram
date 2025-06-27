<?php

namespace App\Http\Resources;

use App\Models\Report;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PatientCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'success' => true,
            'message' => "Patient Get Successfully",
            'data' => $this->collection->map(function ($data) {
                $testNames = [];
                $totalValue = 0;

                foreach ($data->reports as $report) {
                    foreach ($report->testResults as $testResult) {
                        if ($testResult->test) {
                            $testNames[] = $testResult->test->test_name;
                        }

                        if (is_numeric($testResult->value)) {
                            $totalValue += $testResult->value;
                        }
                    }
                }

                return [
                    'id'           => (int) $data->id,
                    'patient_name' => $data->username,
                    'tests'        => implode(', ', array_unique($testNames)),
                    'age'          => $data->age,
                    'gender'       => $data->gender === 'male' ? 'M' : ($data->gender === 'female' ? 'F' : 'O'),
                    'cost'         => $totalValue,
                    'email'                => $data->email ?? '',
                    'mobile_number'        => $data->mobile_number ?? '',
                    'address'              => $data->address ?? '',
                    'medical_history'      => $data->medical_history ?? '',
                    'identity_proof_type'  => $data->identity_proof_type ?? '',
                    'identity_proof_number'=> $data->identity_proof_number ?? '',
                    'patient_code'         => $data->patient_code ?? '',
                    'abha_number'          => $data->abha_number ?? '',
                    'abha_address_number'  => $data->abha_address_number ?? '',
                    'abha_address'         => $data->abha_address ?? '',
                    'refrance_by'          => $data->refrance_by ?? '',
                    'camp_name'              => $data->camp->camp_name ?? '',
                    'amount'               => $data->amount ?? '',
                    'package_name' => $data->package->package_name ?? '',
                    'register_at'  => date('d-m-Y', strtotime($data->registered_at)),
                    'create_at'    =>  date('d-m-Y H:i', strtotime($data->created_at)),
                ];
            }),
        ];
    }

    // public function with($request)
    // {
    //     return [
    //         'success' => true,
    //         'message' => "Patient Get Successfully",
    //         'status' => 200
    //     ];
    // }
}
