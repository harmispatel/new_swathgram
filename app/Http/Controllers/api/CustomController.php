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
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\CamplistResource;
use App\Http\Resources\PackageListResource;
use App\Models\GenericQualityControl;
use App\Models\Device;
use Carbon\Carbon;
use App\Models\LabTechnician;
use App\Http\Resources\PatientResource;
use App\Http\Resources\QcDataResource;
use App\Mail\ProblemReportMail;
use App\Models\ProblemReport;
use Illuminate\Support\Facades\{Auth, DB, Mail};
use App\Traits\{ImageTrait, PushNotificationTrait};

use App\Http\Resources\ReportResource;
use App\Models\Department;
use App\Models\SupportDepartment;
use App\Models\SupportSubDepartment;
use App\Http\Resources\TestResultResource;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Resources\ReportsMultipleResource;
use GuzzleHttp\Psr7\Request as Psr7Request;

class CustomController extends BaseController
{
    use ImageTrait;

    public function CommanData()
    {
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
        try {
            $packages = Package::select('id','package_name')->get();
            return $this->sendResponse($packages, 'package list Data Get Successful', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something went wrong!', false);
        }
    }
    
    public function getTestsByProfile()
    {
        try {
             $profiles = TestProfile::with(['tests' => function ($query) {
                $query->where('is_active', 1)
                    ->select('id', 'test_name','profile_id');
            }])
            ->where('test_type_active', 1)
            ->select('id', 'name')
            ->get();

            return $this->sendResponse($profiles, 'Tests Get Successfully', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something went wrong!', false);
        }
       
    }

    public function patientRegister(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return $this->sendResponse(null, 'Unauthorized user', false);
            }

            $lab_tech = LabTechnician::where('user_id', $user->id)->first();
            if (!$lab_tech) {
                return $this->sendResponse(null, 'Lab Technician not found', false);
            }
           
            $identityProofMap = [
                'Passport'        => 'passport',
                'Driving License' => 'driver_license',
                'Aadhar Number'   => 'national_id',
                'PAN card'        => 'pan_card',
                'Voter ID'        => 'voter_id',
                'Other Govt. ID'  => 'other',
            ];

            $identity_proof_type_request = $request->identity_proof_type;

            $patient = new Patient();
            $patient->user_id = $user->id;
            $patient->email = $request->email;
            $patient->username = $request->username;
            $patient->identity_proof_type = $identityProofMap[$identity_proof_type_request] ?? '';
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
            $patient->package_id=$request->package;
        
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
            return $this->sendResponse(new PatientResource($patient, $request->test_list ?? []), 'Patient created successfully', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something went wrong!', false);
        }
    }


    public function patientUpdate(Request $request)
    {
        try {
            $patient_id = $request->patient_id;
            $user = Auth::user();
            if (!$user) {
                return $this->sendResponse(null, 'Unauthorized user', false);
            }

            $lab_tech = LabTechnician::where('user_id', $user->id)->first();
            if (!$lab_tech) {
                return $this->sendResponse(null, 'Lab Technician not found', false);
            }

            $patient = Patient::find($patient_id);
            $patient->user_id = $user->id;
            if ($request->has('email')) $patient->email = $request->email;
            if ($request->has('username')) $patient->username = $request->username;
            if ($request->has('identity_proof_type')) $patient->identity_proof_type = $request->identity_proof_type; 
            if ($request->has('age')) $patient->age = $request->age;
            if ($request->has('gender')) $patient->gender = $request->gender;
            if ($request->has('refrance_by')) $patient->refrance_by = $request->refrance_by ?? null;
            if ($request->has('mobile_number')) $patient->mobile_number = $request->mobile_number;
            if ($request->has('address')) $patient->address = $request->address;
            if ($request->has('medical_history')) $patient->medical_history = $request->medical_history;
            if ($request->has('organization_id')) $patient->organization_id = $lab_tech->organization_id;
            if ($request->has('identity_proof_number')) $patient->identity_proof_number = $request->identity_proof_number ?: null;
            if ($request->has('abha_address_number')) $patient->abha_address_number = $request->abha_address_number;
            if ($request->has('abha_number')) $patient->abha_number = $request->abha_number;
            if ($request->has('abha_address')) $patient->abha_address = $request->abha_address;
            if ($request->has('amount')) $patient->amount = $request->amount;
            $patient->camp_id = $request->camp_id ?? null;
            $patient->package_id=$request->package;
            $patient->update();

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
            return $this->sendResponse(new PatientResource($patient, $request->test_list ?? []), 'Patient Updated successfully', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something went wrong!', false);
        }
    }

    private function createTestResults($tests, $report, $age, $gender) 
    {
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
            $patients = Patient::where('user_id',$user_id)->with('package','camp', 'reports.testResults.test')->get();
            return new PatientCollection($patients);
        } 
        catch (\Throwable $th) 
        {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function camplist()
    {
        try {
            $user = Auth::user();
            $lab_technician = LabTechnician::where('user_id',$user->id)->first();
            $labTechnicianId = $lab_technician->user_id;

            $camps = Camp::with(['organizations', 'labTechnicians', 'pathologist'])
                ->whereHas('labTechnicians',function ($query) use ($labTechnicianId){
                    $query->where('lab_technicians.user_id',$labTechnicianId);
            })->orderBy('id','desc')->get();

            return $this->sendResponse(CamplistResource::collection($camps),'camp list successfully.', true);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function packagelist()
    {
        try {
           $packages=Package::with('tests')->orderBy('id','desc')->get();
           return $this->sendResponse(PackageListResource::collection($packages),'package list successfully.', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something went wrong!', false);
        }
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

    public function qcdata()
    {
        try {
            $lt_id = Auth::user()->id;
          
            $qcdata = GenericQualityControl::where('lt_id',$lt_id)->with('test')->get();
            $data = QcDataResource::collection($qcdata);
            return $this->sendResponse($data,'Qc list fetched successfully.', true);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
        
    }

    public function problemReport(Request $request)
    {
        try {

            $problemReport = new ProblemReport();
            $problemReport->user_id = Auth::user()->id;
            $problemReport->subject = $request->subject ?? '';
            $problemReport->description = $request->description ?? '';

            $uploadedFiles = [];

            if ($request->hasFile('files')) {
                $uploadedFiles = $this->addMultipleFiles('problemreport', 'documents', $request->file('files'));
            }

            $problemReport->image = json_encode($uploadedFiles);
            $problemReport->save();
            $email = 'harmistest@gmail.com';

            $ccEmails = ['harmistest@gmail.com', 'harmistest@gmail.com']; // Add CC emails here
            // Mail::to($email)
            //     ->cc($ccEmails)
            //     ->send(new ProblemReportMail($problemReport, $uploadedFiles));

            return $this->sendResponse($uploadedFiles, 'Your Problem Request Sent.', true);
        } catch (\Throwable $th) {
            
            return $this->sendResponse(null, 'Something went wrong!', false);
        }
    }


    public function report(Request $request)
    {
        try {
            $user=Auth::user();
            $patient=Patient::where('user_id',$user->id)->with('reports.testResults.test')->get();

            return $this->sendResponse(ReportResource::collection($patient),'Report list successfully.', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something went wrong!', false);
        }
    }

    public function patientByReport(Request $request)
    {
        try {
            if($request->patient_id)
            {
                $reports = Report::with('patient', 'testResults.test')
                                ->where('patient_id', $request->patient_id)
                                ->get();

                if($reports->isEmpty()){
                    return $this->sendResponse(null, 'Patient Report Not Available', true);
                }
                return $this->sendResponse(ReportsMultipleResource::collection($reports), 'Patient Report Fetch successfully.', true);
            }

        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something went wrong!', false);
        }
    }

    public function Supportdepartments()
    {
        try {
            $departments = SupportDepartment::select('id','DepartmentName','is_active')->get();
            return $this->sendResponse($departments,'Supports fetched successfully', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something went wrong!', false);
        }
    }

    public function SupportSubdepartments(Request $request)
    {
        try {
            $support_id = $request->id;
            $sub_departments = SupportSubDepartment::where('departmentId',$support_id)->select('id','subDepartmentName','videoUrl')->get();

            if ($sub_departments->isEmpty()) {
                return $this->sendResponse(null,'subDepartment Not available', true);
            }
 
            return $this->sendResponse($sub_departments,'subDepartment fetched successfully', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something went wrong!', false);
        }
    }

    public function getTestResult(Request $request)
    {
        try {
            $patient_id = $request->patient_id;
            $report = Report::where('patient_id', $patient_id)->first();
            if (!$report) {
                 return $this->sendResponse(null, 'No report found for this patient.', false);
            }
            $test_results = TestResult::where('report_id', $report->id)->with('test')->get();
            $patient = Patient::with('camp')->where('id',$patient_id)->first();

            $data = [
                'patient' => [
                    'id' => $patient->id,
                    'name' => $patient->username,
                    'gender'       => $patient->gender === 'male' ? 'M' : ($patient->gender === 'female' ? 'F' : 'O'),  
                    'age' => $patient->age,
                    'patient_code' => $patient->patient_code ?? '',
                    'camp_name' => $patient->camp->camp_name ?? '',
                    'create_at'    => date('d-m-Y H:i', strtotime($patient->created_at)),
                ],
                'test_results' => $test_results->map(function ($testResult) {
                    return [
                        'id' => $testResult->id,
                        'amount' => $testResult->value,
                        'test_name' => $testResult->test->test_name ?? '',
                        'test_code' => $testResult->test->test_code ?? '',
                    ];
                }),
            ];

            return $this->sendResponse($data, 'Test Result successfully', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something went wrong!', false);
        }
    }

    public function deleteTestResults(Request $request)
    {
        try {
            $patient_id = $request->patient_id;

            $report = Report::where('patient_id', $patient_id)->first();

            if (!$report) {
                return $this->sendResponse(null, 'No report found for this patient.', false);
            }

            TestResult::where('report_id', $report->id)->delete();

            return $this->sendResponse(null, 'Test results deleted successfully.', true);

        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something went wrong!', false);
        }
    }   
    
    //edit result
    public function updateTestResult(Request $request)
    {
        try {
            $patient_id = $request->patient_id;
            $report = Report::where('patient_id', $patient_id)->first();

            if (!$report) {
                return $this->sendResponse(null, 'No report found for this patient.', false);
            }

            foreach ($request->results as $result) {
                TestResult::where('id', $result['id'])
                    ->where('report_id', $report->id)
                    ->update(['value' => $result['value']]);
            }

            return $this->sendResponse(null, 'Test results updated successfully.', true);

        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something went wrong!', false);
        }
    }
 
    public function updatepatient(request $request)
    {
         try {

            $validator = Validator::make($request->all(), [
                'username' => 'unique:users,username',
            ]);

            if ($validator->fails()) {
                return $this->sendResponse(null, $validator->errors()->first(), false);
            }

            
            $patients =Patient::find($request->patient_id);
            if (!$patients) {
                return $this->sendResponse(null, 'Patient not found.', false);
            }

           $user = User::find($patients->user_id);
            if (!$user) {
                return $this->sendResponse(null, 'User not found.', false);
            }

            $user->update([
                'username'=>$request->username,
            ]);

            $patients->update([
                'username'=>$request->username,
                'gender'=>$request->gender,
                'age'=>$request->age
            ]);
            return $this->sendResponse(null, 'patient update successfully.', true);

        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something went wrong!', false);

        }
        
    }

    public function deletePatient(Request $request)
    {
        try {
            $patient = Patient::find($request->patient_id);
            if (!$patient) {
                return $this->sendResponse(null, 'Patient not found.', false);
            }

            $user = User::find($patient->user_id);

            $patient->delete();
            if ($user) {
                $user->delete();
            }

            return $this->sendResponse(null, 'Patient deleted successfully.', true);

        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something went wrong! ' . $th->getMessage(), false);
        }
    }
}
