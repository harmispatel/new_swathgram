<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\api\BaseController as BaseController;
use App\Http\Resources\PatientCollection;
use Illuminate\Http\Request;

use App\Models\Camp;
use App\Models\Package;
use App\Models\TestProfile;
use App\Models\Test;
use App\Models\Patient;
use App\Models\Report;
use App\Models\PackageTest;
use App\Models\TestResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\CamplistResource;
use App\Http\Resources\PackageListResource;
use App\Models\GenericQualityControl;
use App\Models\Device;
use Carbon\Carbon;
use App\Models\LabTechnician;
use App\Http\Resources\PatientResource;

use App\Http\Resources\QcDataResource;


class CustomController extends BaseController
{
    public function CommanData(){
        $camps = Camp::select('id','camp_name')->get();
        // $packages = Package::select('id','package_name')->get();
        // $profiles = TestProfile::select('id','name')->get();
         
        $data = [
            'camp' => $camps,
            // 'package' => $packages,
            // 'profiles' => $profiles
        ];

        
        return $this->sendResponse($camps, 'Camp Data Get Successful', true);
    }

    public function package()
    {
        $packages = Package::select('id','package_name')->get();
        return $this->sendResponse($packages, 'package list Data Get Successful', true);
    }


     public function amount(){
    //   $packages = Package::select('id','package_name')->get();
        $amounts = [
                ['amount' => 100],
                ['amount' => 200],
                ['amount' => 500],
            ];

        return $this->sendResponse($amounts, 'list Data Get Successful', true);
    }

    public function getTestsByProfile()
    {
        $profiles = TestProfile::with(['tests' => function ($query) {
                $query->where('is_active', 1)
                    ->select('id', 'test_name','profile_id');
            }])
            ->where('test_type_active', 1)
            ->select('id', 'name')
            ->orderBy('id', 'desc')
            ->get();

        return $this->sendResponse($profiles, 'Tests Get Successfully', true);
    }

   

    
    public function PatientCreate(Request $request)
    {
        try {
            $user = Auth::user();
            dd($user);
            if (!$user) {
                return $this->sendResponse(null, 'Unauthorized user', false);
            }

            $lab_tech = LabTechnician::where('user_id', $user->id)->first();
            if (!$lab_tech) {
                return $this->sendResponse(null, 'Lab Technician not found', false);
            }

            $patient = new Patient();
            $patient->user_id = $user->id;
            $patient->email = $request->email;
            $patient->username = $request->username;
            $patient->identity_proof_type = $request->identity_proof_type; 
            $patient->age = $request->age;
            $patient->gender = $request->gender;
            $patient->refrance_by = $request->refrance_by ?? null;
            $patient->mobile_number = $request->mobile_number;
            $patient->address = $request->address;
            $patient->medical_history = $request->medical_history;
            $patient->organization_id = $lab_tech->organization_id;
            $patient->identity_proof_number = $request->identity_proof_number ?: null;
            $patient->camp_id = $request->camp_id ?? null;
            $patient->patient_code = '#' . random_int(2000000000, 2999999999);
            $patient->abha_address_number = $request->abha_address_number;
            $patient->abha_number = $request->abha_number;
            $patient->abha_address = $request->abha_address;
            $patient->amount = $request->amount;
            $patient->save(); 

            $report = null;
            if ($request->camp_id) {
                $camp = Camp::find($request->camp_id);
                if ($camp) {
                    $report = new Report();
                    $report->camp_id = $camp->id;
                    $report->patient_id = $patient->id;
                    $report->pathologist_id = $camp->pathologist_id;
                    $report->organization_id = $camp->organization_id;
                    $report->save();
                }
            }

            if ($request->package && $report) {
                $package_test_ids = PackageTest::where('package_id', $request->package)->pluck('test_id');
                $tests = Test::whereIn('id', $package_test_ids)->get();
                $this->createTestResults($tests, $report, $request->age, $request->gender);
            }

            if ($request->test_list && $report) {
                $tests = Test::whereIn('id', $request->test_list)->get();
                $this->createTestResults($tests, $report, $request->age, $request->gender);
            }

            // return $this->sendResponse(null, 'Patient created successfully', true);
            return $this->sendResponse(new PatientResource($patient, $request->test_list ?? []), 'Patient created successfully', true);


        } catch (\Throwable $th) {
            return $this->sendResponse(null, $th->getMessage(), false);
        }
    }


    private function createTestResults($tests, $report, $age, $gender) {
        foreach ($tests as $test) {
            $test_result = new TestResult();
            $test_result->report_id = $report->id;
            $test_result->test_id = $test->id;
            $test_result->value = $test->price;
            $test_result->unit = $test->unit ?? '';

            if ($age >= 10) {
                $test_result->reference_range = $gender == "male" ? 'male_ref_range' : 'female_ref_range';
            } else {
                $test_result->reference_range = 'child_ref_range';
            }
            $test_result->save();
        }
    }

    public function patientlist()
    {
        try {
            $user_id=Auth::user()->id;
            $patients = Patient::where('user_id',$user_id)->with('camp', 'reports.testResults.test')->get();
            return new PatientCollection($patients);
        } 
        catch (\Throwable $th) 
        {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    // public function changePassword(Request $request)
    // {
    //     $request->validate([
    //         'old_password' => 'required',
    //         'new_password' => 'required|min:6',
    //         're_password'  => 'required|same:new_password',
    //     ]);

    //     $user = auth()->user();

    //     if (!Hash::check($request->old_password, $user->password)) {
    //           return $this->sendResponse(null, 'Old password does not match.', false);
    //     }

    //     $user->password = Hash::make($request->new_password);
    //     $user->save();

    //       return $this->sendResponse(true,'Password updated successfully');
    // }

    public function camplist()
    {
            $technicianId = Auth::id();
            $camps = Camp::whereRelation('labTechnicians', 'lab_technicians.id', $technicianId)
                            ->get();

            return $this->sendResponse(
                CamplistResource::collection($camps),
             'camp list successfully.', true);

    }

    public function packagelist()
    {

        $packages=Package::get();
        return $this->sendResponse(
              PackageListResource::collection($packages),
             'package list successfully.', true);
    }


    public function searchpatient(Request $request)
    {
        $query = Patient::query();

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function($q) use ($search) {
                $q->where('mobile_number', 'like', '%' . $search . '%')
                ->orWhere('identity_proof_type', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%');
            });
        }

        $patients = $query->get(['id', 'username']);

        return $this->sendResponse([
            'camplist' => $patients,
        ], 'Patient list fetched successfully.', true);
    }


    public function qcdata(){
        
            $qcdata = QcDataResource::collection(
               GenericQualityControl::with('test')->get()
            );


        return $this->sendResponse(
          $qcdata,
         'Qc list fetched successfully.', true);
    }
    
}
