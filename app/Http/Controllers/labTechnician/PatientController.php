<?php

namespace App\Http\Controllers\labTechnician;

use App\Models\Camp;
use App\Models\Organization;
use App\Models\Package;
use App\Models\PackageTest;
use App\Models\Patient;
use App\Models\Report;
use App\Models\Test;
use App\Models\TestProfile;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query()->orderBy('id', 'desc');
        if ($request->filled('organization_type')) {
            $query->where('organization_id', $request->organization_type);
        }

        if ($request->filled('camp_id')) {
            $query->where('camp_id', $request->camp_id);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        $patients = $query->get();
        $organizations = Organization::orderBy('id', 'desc')->get();
        $camps = Camp::orderBy('id', 'desc')->get();

        return view('lab_technician.patient.index', compact('patients', 'organizations', 'camps'));
    }


    public function create()
    {
        $tests = Test::where('is_active',1)->orderBy('id','desc')->get();
        $camps = Camp::orderBy('id','desc')->get();
        $packages = Package::where('is_active',1)->orderBy('id','desc')->get();
        $test_profiles = TestProfile::where('test_type_active',1)->orderBy('id','desc')->get();
        return view('lab_technician.patient.create',compact('packages','camps','tests','test_profiles'));
    }

    public function getTestsByProfile(Request $request)
    {
        $tests = Test::where('profile_id', $request->profile_id)->get();
        return response()->json([
            'success'=> 1,
            'data' => $tests
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'camp_name' => 'required',
            'email' => 'required|email|unique:patients,email',
            'username' => 'required',
            'identity_proof_type' => 'required',
            'identity_proof_number' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'mobile_number' => 'required',
            'package' => 'required',
            'address' => 'required',
            'medical_history' => 'required',
            'profile' => 'required',
            'test_list' => 'required|array',
            'test_list.*' => 'exists:tests,id',
            'refrance_by' => 'nullable|string'
        ]);

        $user = Auth::guard('lab_technician')->user();

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

        $camp = Camp::where('id',$request->camp_name)->first();
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
    
        return redirect()->route('lab_technician.patient')->with('success', 'Patient created successfully.'); 
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


    public function delete(Request $request)
    {
        try {
            $patient = Patient::find(decrypt($request->id));
            $patient->delete();

            return response()->json([
                'success' => 1,
                'message' => "Patient Delete successfully",
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Internal Server Error!",
            ]);
        }
    }

}
