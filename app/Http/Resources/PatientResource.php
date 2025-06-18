<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{


 protected $testList;

    public function __construct($resource, $testList = [])
    {
        // Pass both the patient and test_list
        parent::__construct($resource);
        $this->testList = $testList;
    }

    public function toArray($request)
    {
        return [
            'id'                   => $this->id,
            'username'             => $this->username ?? '',
            'email'                => $this->email ?? '',
            'age'                  => $this->age ?? '',
            'gender'               => $this->gender ?? '',
            'mobile_number'        => $this->mobile_number ?? '',
            'address'              => $this->address ?? '',
            'medical_history'      => $this->medical_history ?? '',
            'identity_proof_type'  => $this->identity_proof_type ?? '',
            'identity_proof_number'=> $this->identity_proof_number ?? '',
            'patient_code'         => $this->patient_code ?? '',
            'abha_number'          => $this->abha_number ?? '',
            'abha_address_number'  => $this->abha_address_number ?? '',
            'abha_address'         => $this->abha_address ?? '',
            'refrance_by'          => $this->refrance_by ?? '',
            'camp_id'              => $this->camp_id ?? '',
            'amount'               => $this->amount ?? '',
            'test_list'            => $this->testList,
        ];
    }
}
