<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Test;
use App\Models\TestProfile;
use App\Models\TestSubprofile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestsController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('test')){
            $tests = Test::with('testProfile','testSubprofile','department')->orderBy('id','desc')->get();
            return view('super_admin.tests.index',compact('tests'));
        } else {
          return redirect()->back()->with('error','You have no rights for this action!');
        }      
    }

    public function create()
    {
        if(Auth::user()->can('test.create')){
            $departments = Department::orderBy('id','desc')->get();
            $profiles = TestProfile::with('department')->orderBy('id','desc')->get();
            $sub_profiles = TestSubprofile::with('department','profile')->orderBy('id','desc')->get();
            return view('super_admin.tests.create',compact('departments','profiles','sub_profiles'));
        } else {
          return redirect()->back()->with('error','You have no rights for this action!');
        }     
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'test_name'    => 'required',
            'test_code'    => 'required|unique:tests,test_code',
            'unit'         => 'required',
            'department'   => 'required',
            'price'        => 'required',
            'manual_machine' => 'nullable',  // remove this this cluman not availble in  database
            'profile'      => 'required',
            'sub_profile'  => 'required',
            'test_serial_number' => 'required',
            'test_method'  => 'required',
            'image_permissions' => 'required',
            'test_mode' => 'required',
            
            'male_lower_range' => 'required',
            'male_upper_range' => 'required',
            'male_preview' => 'required',

            'female_lower_range' => 'required',
            'female_upper_range' => 'required',
            'female_preview' => 'required',

            'child_lower_range' => 'required',
            'child_upper_range' => 'required',
            'child_preview' => 'required',

            // male_ref_range => male_preview
            //child_ref_range => child_preview
            //female_ref_range => female_preview
        ]);

        $test = new Test();
        $test->test_name = $request->test_name;
        $test->test_code = $request->test_code;
        $test->unit = $request->unit;
        $test->department_id = $request->department;
        $test->price = $request->price;
        $test->manual_machine = $request->manual_machine;
        $test->profile_id = $request->profile;
        $test->sub_profile_id = $request->sub_profile;
        $test->test_serial_number = $request->test_serial_number;
        $test->test_method = $request->test_method;
        $test->image_permissions = $request->image_permissions;
        
        $test->male_lower_range = $request->male_lower_range;
        $test->male_upper_range = $request->male_upper_range;
        $test->male_ref_range = $request->male_preview;

        $test->female_lower_range = $request->female_lower_range;
        $test->female_upper_range = $request->female_upper_range;
        $test->female_ref_range = $request->female_preview;

        $test->child_lower_range = $request->child_lower_range;
        $test->child_upper_range = $request->child_upper_range;
        $test->child_ref_range = $request->child_preview;
        $test->save();
        
        return redirect()->route('test')->with('success', 'Test created successfully.'); 
    }

    public function edit($id)
    {
        if(Auth::user()->can('test.edit')){
            $test = Test::with('department')->find(decrypt($id));
            $departments = Department::orderBy('id','desc')->get();
            $profiles = TestProfile::with('department')->orderBy('id','desc')->get();
            $sub_profiles = TestSubprofile::with('department','profile')->orderBy('id','desc')->get();
            return view('super_admin.tests.edit',compact('test','departments','profiles','sub_profiles'));
        } else {
          return redirect()->back()->with('error','You have no rights for this action!');
        }     
    }

    public function update(Request $request)
    {
        $test_id = decrypt($request->test_id);

        $validated = $request->validate([
            'test_name'    => 'required',
            'test_code' => 'required|unique:tests,test_code,' . $test_id,
            'unit'         => 'required',
            'department'   => 'required',
            'price'        => 'required',
            'manual_machine' => 'nullable',  // remove this this cluman not availble in  database
            'profile'      => 'required',
            'sub_profile'  => 'required',
            'test_serial_number' => 'required',
            'test_method'  => 'required',
            'image_permissions' => 'required',
            'test_mode' => 'required',
            
            'male_lower_range' => 'required',
            'male_upper_range' => 'required',
            'male_preview' => 'required',

            'female_lower_range' => 'required',
            'female_upper_range' => 'required',
            'female_preview' => 'required',

            'child_lower_range' => 'required',
            'child_upper_range' => 'required',
            'child_preview' => 'required',

            // male_ref_range => male_preview
            //child_ref_range => child_preview
            //female_ref_range => female_preview
        ]);

        $test = Test::find($test_id);
        $test->test_name = $request->test_name;
        $test->test_code = $request->test_code;
        $test->unit = $request->unit;
        $test->department_id = $request->department;
        $test->price = $request->price;
        // 'manual_machine' = $request->;
        $test->profile_id = $request->profile;
        $test->sub_profile_id = $request->sub_profile;
        $test->test_serial_number = $request->test_serial_number;
        $test->test_method = $request->test_method;
        $test->image_permissions = $request->image_permissions;
        
        $test->male_lower_range = $request->male_lower_range;
        $test->male_upper_range = $request->male_upper_range;
        $test->male_ref_range = $request->male_preview;

        $test->female_lower_range = $request->female_lower_range;
        $test->female_upper_range = $request->female_upper_range;
        $test->female_ref_range = $request->female_preview;

        $test->child_lower_range = $request->child_lower_range;
        $test->child_upper_range = $request->child_upper_range;
        $test->child_ref_range = $request->child_preview;
        $test->update();
        
        return redirect()->route('test')->with('success', 'Test created successfully.'); 
    }

    public function delete(Request $request)
    {
        if(Auth::user()->can('test.delete')){
            try {
                Test::where('id',decrypt($request->id))->delete();
                return response()->json([
                    'success' => 1,
                    'message' => "Test Delete successfully",
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
}
