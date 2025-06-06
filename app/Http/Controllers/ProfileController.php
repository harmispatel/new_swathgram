<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Test;
use App\Models\TestProfile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $profiles = TestProfile::with('department','tests')->orderBy('id','desc')->get();
        $departments = Department::where('is_active',1)->orderBy('id','desc')->get();

        $editProfile = null;
        if ($request->has('edit_id')) {
            $editProfile = TestProfile::findOrFail(decrypt($request->edit_id));
        }

        return view('super_admin.test_profile.index', compact('profiles', 'departments', 'editProfile'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_name'      => 'required|exists:department,id',
            'name'                 => 'required',
            'interpretation'       => 'required',
            'interpretation_flag'  => 'required|in:0,1',
        ]);

        if ($request->has('edit_id')) {
            // Update
            $test_profile = TestProfile::findOrFail(decrypt($request->edit_id));
        } else {
            // Create
            $test_profile = new TestProfile();
        }

        $test_profile->department_id        = $request->department_name;
        $test_profile->name                 = $request->name;
        $test_profile->interpretation       = $request->interpretation;
        $test_profile->interpretation_flag  = $request->interpretation_flag;
        $test_profile->save();

        $message = $request->has('edit_id') ? 'Profile updated successfully.' : 'Profile created successfully.';
        return redirect()->route('test.profile')->with('success', $message);
    }

    public function delete(Request $request)
    {
        try {
            $test_profile = TestProfile::where('id', decrypt($request->id))->first();
          
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