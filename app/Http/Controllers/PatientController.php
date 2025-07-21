<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\{Camp, LabTechnician, Organization,Package,PackageTest,Patient,Report,Test,TestProfile,TestResult,User, UserOtp};
use Carbon\Carbon;
use Illuminate\Support\Facades\{Auth,Hash, Validator};
use Twilio\Rest\Client;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->can('patient')){    
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

            return view('super_admin.patient.index', compact('patients', 'organizations', 'camps'));
            
        } else {
            return redirect()->back()->with('error','You have no rights for this action!');
        } 

    }

    public function delete(Request $request)
    {
        if(Auth::user()->can('patient.delete')){ 
            try {
                $patient = Patient::find(decrypt($request->id));
                $user = User::find($patient->user_id);
                $patient->delete();  
                if ($user) {
                    $user->delete();
                }

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
        } else {
          return redirect()->back()->with('error','You have no rights for this action!');
        }      
    }


    public function create()
    {
        if(Auth::user()->can('patient.create')){
            $tests = Test::where('is_active',1)->orderBy('id','desc')->get();
            $camps = Camp::orderBy('id','desc')->get();
            $packages = Package::where('is_active',1)->orderBy('id','desc')->get();
            $test_profiles = TestProfile::where('test_type_active',1)->orderBy('id','desc')->get();
            return view('super_admin.patient.create',compact('packages','camps','tests','test_profiles'));
        } else {
          return redirect()->back()->with('error','You have no rights for this action!');
        } 
    }

    public function getTestsByProfile(Request $request)
    {
        $tests = Test::where('profile_id', $request->profile_id)->get();
        return response()->json([
            'success'=> 1,
            'data' => $tests
        ]);
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

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'camp_name' => 'required',
            'email' => 'required|email|unique:patients,email',
            'username' => 'required|unique:patients,username',
            'identity_proof_type' => 'required',
            'identity_proof_number' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'mobile_number' => 'required',
            'package' => 'required',    
            'address' => 'required',
            'medical_history' => 'required',
            'profile' => 'required',
            // 'test_list' => 'required',
            // 'test_list.*' => 'exists:tests,id',
            'refrance_by' => 'nullable|string'
        ]);

        if (!session('otp_verified')) {
            return redirect()->back()->withErrors(['otp' => 'OTP not verified.']);
        }


        $user = User::create([
            'username'=>$request->username,
            'email'=>$request->email,
            'password'=>Hash::make(123456),
            'role'=>4,
        ]);

         $user = Auth::user();
        $lab_tech = LabTechnician::where('user_id',$user->id)->first();

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
        $patient->organization_id = $lab_tech->organization_id;
        $patient->identity_proof_number = $lab_tech->identity_proof_number ?? null;
        $patient->camp_id = $request->camp_name ?? null;
        $patient->patient_code = '#' . random_int(2000000000,2000000000);
        $patient->package_id =$request->package;
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

        session()->forget('otp_verified'); 
        return redirect()->route('patient')->with('success', 'Patient created successfully.'); 
    }

    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'camp_name' => 'required',
            'email' => 'required|email|unique:patients,email',
            'username' => 'required|unique:patients,username',
            'identity_proof_type' => 'required',
            'identity_proof_number' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'mobile_number' => 'required',
            'package' => 'required',    
            'address' => 'required',
            'medical_history' => 'required',
            'profile' => 'required',
            // 'test_list' => 'required',
            // 'test_list.*' => 'exists:tests,id',
            'refrance_by' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }


        $otpCode = rand(100000, 999999);
        $mobile = $request->mobile_number;

        // $account_sid = getenv("TWILIO_SID");
        // $auth_token = getenv("TWILIO_TOKEN");
        // $twilio_number = getenv("TWILIO_FROM");

        // $message = "Patient OTP is ".$otpCode;

        // $client = new Client($account_sid, $auth_token);
        // $client->messages->create($mobile, [
        //     'from' => $twilio_number, 
        //     'body' => $message]);

        UserOtp::updateOrCreate(
            ['mobile_number' => $mobile],
            ['otp' => $otpCode, 'expire_at' => Carbon::now()->addMinutes(5)]
        );
        return response()->json(['success' => true, 'message' => 'OTP sent.']);
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|digits:10',
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid input.']);
        }

        session()->put('otp_verified', true);

        $otpData = UserOtp::where('mobile_number', $request->mobile_number)
                      ->where('otp', $request->otp)
                      ->where('expire_at', '>', Carbon::now())
                      ->first();

        if (!$otpData) {
            return response()->json(['success' => false, 'message' => 'OTP invalid or expired.']);
        }
        $otpData->delete();
        return response()->json(['success' => true, 'message' => 'OTP verified.']);
    }
}
