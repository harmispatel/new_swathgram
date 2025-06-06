<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\TestProfile;
use App\Models\TestSubprofile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubProfileController extends Controller
{
    public function index(Request $request)
    {
        $sub_profiles = TestSubprofile::with('department','profile','tests')->orderBy('id','desc')->get();
        $profiles = TestProfile::orderBy('id','desc')->get();
        $departments = Department::where('is_active',1)->orderBy('id','desc')->get();

        $editProfile = null;
        if ($request->has('edit_id')) {
            $editProfile = TestSubprofile::findOrFail(decrypt($request->edit_id));
        }
      
        return view('super_admin.test_sub_profile.index', compact('sub_profiles', 'profiles', 'departments', 'editProfile'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_name'      => 'required|exists:department,id',
            'name'                 => 'required',
            'interpretation'       => 'required',
            'interpretation_flag'  => 'required|in:0,1',
            'profile'                 => 'required',
        ]);

        if ($request->has('edit_id')) {
            // Update
            $test_profile = TestSubprofile::findOrFail(decrypt($request->edit_id));
        } else {
            // Create
            $test_profile = new TestSubprofile();
        }

        $test_profile->department_id        = $request->department_name;
        $test_profile->profile_id           = $request->profile;
        $test_profile->name                 = $request->name;
        $test_profile->interpretation       = $request->interpretation;
        $test_profile->interpretation_flag  = $request->interpretation_flag;
        $test_profile->created_by  = Auth::user()->id;
        $test_profile->save();

        $message = $request->has('edit_id') ? 'Sub Profile updated successfully.' : 'Sub Profile created successfully.';
        return redirect()->route('test.sub-profile')->with('success', $message);
    }

    public function delete(Request $request)
    {
        try {
            $test_profile = TestSubprofile::where('id', decrypt($request->id))->first();
          
            $test = Test::where('profile_id',$test_profile->id)->first();
            if (!empty($test)) {
                return response()->json([
                    'success' => 0,
                    'message' => "Profile Already Used In Test!",
                ]);
            }
            $test_profile->delete();
            return response()->json([
                'success' => 1,
                'message' => "Profile deleted successfully",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Internal Server Error!",
            ]);
        }
    }
}