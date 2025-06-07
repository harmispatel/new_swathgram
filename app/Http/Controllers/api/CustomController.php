<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\api\BaseController as BaseController;
use App\Http\Resources\PatientCollection;
use Illuminate\Http\Request;

use App\Models\Camp;
use App\Models\package;
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

use App\Http\Resources\QcDataResource;


class CustomController extends BaseController
{
    public function CommanData(request $request){
        $camps = Camp::select('id','camp_name')->get();
        $packages = Package::select('id','package_name')->get();
        $profiles = TestProfile::select('id','name')->get();
         
        $data = [
            'camp' => $camps,
            'package' => $packages,
            'profiles' => $profiles
        ];
        return $this->sendResponse($data, 'Patient Data Get Successful', true);
    }

    public function getTestsByProfile(Request $request)
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

            $patient = new Patient();
            $patient->user_id = $user->id;
            $patient->email = $request->email;
            $patient->username = $request->username;
            $patient->identity_proof_type = $request->identity_proof_type;
            $patient->age = $request->age;
            $patient->gender = $request->gender;
            $patient->refrance_by = isset($request->refrance_by) ? $request->refrance_by : '';
            $patient->mobile_number = $request->mobile_number;
            $patient->address = $request->address;
            $patient->medical_history = $request->medical_history;
            $patient->organization_id = $user->organization_id;
            $patient->identity_proof_number = $user->identity_proof_number;
            $patient->camp_id = $request->camp_name ?? null;
            $patient->patient_code = '#' . random_int(2000000000,2000000000);
            $patient->save();

            $camp = Camp::where('id',$request->camp_id)->first();
          
            if ($camp && $patient) {
                $report = new Report();
                $report->camp_id = $camp->id;
                $report->patient_id = $patient->id;
                $report->pathologist_id = $camp->pathologist_id;
                $report->organization_id = $camp->organization_id;
                $report->save();
            }

            if($request->package){
                $package_test_ids = PackageTest::where('package_id',$request->package)->pluck('test_id');
                $tests = Test::whereIn('id',$package_test_ids)->get();
                $this->createTestResults($tests, $report, $request->age, $request->gender);
            }

            if($request->test_list){
                $tests = Test::whereIn('id',$request->test_list)->get();
                $this->createTestResults($tests, $report, $request->age, $request->gender);
            }

            return $this->sendResponse(true,'Patient created successfully');
          
       } catch (\Throwable $th) {
         return $this->sendResponse(false, 'something went wrong');
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

    public function patientlist(Request $request)
    {
        try {

            $patients = Patient::with('camp', 'reports.testResults.test')->orderBy('id','desc')->get();
            return new PatientCollection($patients);
        } 
        catch (\Throwable $th) 
        {
            dd($th);
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            're_password'  => 'required|same:new_password',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->old_password, $user->password)) {
              return $this->sendResponse(null, 'Old password does not match.', false);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

          return $this->sendResponse(true,'Password updated successfully');
    }

    public function camplist(request $request)
    {
            $technicianId = Auth::id();
            $camps = Camp::whereRelation('labTechnicians', 'lab_technicians.id', $technicianId)
                            ->get();

            return $this->sendResponse([
                'camplist' => CamplistResource::collection($camps),
            ], 'camp list successfully.', true);

    }

    public function packagelist(request $request)
    {

        $packages=Package::get();
        return $this->sendResponse([
                'camplist' => PackageListResource::collection($packages),
            ], 'camp list successfully.', true);

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


    public function qcdata(request $request){

        // $device=Device::get();

        // $qcdata= GenericQualityControl::with('test')->get();
        
            $qcdata = QcDataResource::collection(
               GenericQualityControl::with('test')->get()
            );


        return $this->sendResponse([
            'qcdata' =>$qcdata,
        ], 'Qc list fetched successfully.', true);

    }
    
}
