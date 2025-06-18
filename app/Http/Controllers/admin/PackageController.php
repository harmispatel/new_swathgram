<?php

namespace App\Http\Controllers\admin;

use App\Models\Organization;
use App\Models\Package;
use App\Models\Test;
use App\Models\TestProfile;
use App\Models\TestSubprofile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::orderBy('id','desc')->get();
        return view('admin.package.index',compact('packages'));
    }

    public function getTestsByProfile(Request $request)
    {
        $tests = Test::where('profile_id', $request->profile_id)->get();
        return response()->json([
            'success'=> 1,
            'data' => $tests
        ]);
    }

    // public function getTestDetails(Request $request)
    // {
    //     $test = Test::with(['testProfile', 'testSubprofile'])->find($request->test_id);
    //     if ($test) {
    //         return response()->json([
    //             'success' => 1,
    //             'data' => [
    //                 'profile_name' => $test->testProfile->name ?? '-',
    //                 'sub_profile_name' => $test->testSubprofile->name ?? '-',
    //                 'test_name' => $test->test_name,
    //                 'price' => $test->price
    //             ]
    //         ]);
    //     }

    //     return response()->json(['success' => 0]);
    // }

    public function getTestDetails(Request $request)
    {
        $testIds = $request->test_ids;

        $tests = Test::with('testProfile', 'testSubprofile')
            ->whereIn('id', $testIds)
            ->get()
            ->map(function ($test) {
                return [
                    'id' => $test->id,
                    'test_name' => $test->test_name,
                    'price' => $test->price,
                    'profile_name' => $test->testProfile->name ?? '-',
                    'sub_profile_name' => $test->testSubprofile->name ?? '-',
                ];
            });

        return response()->json([
            'success' => 1,
            'data' => $tests
        ]);
    }

    public function create()
    {
        $tests = Test::orderBy('id','desc')->get();
        $test_profiles = TestProfile::all();
        $sub_profiles = TestSubprofile::all();
        $organizations = Organization::orderBy('id','desc')->get();
        return view('admin.package.create',compact('organizations','tests','test_profiles','sub_profiles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_name' => 'required',
            'profile' => 'required',
            'test_list' => 'required|array|max:6',
            'test_list.*' => 'exists:tests,id',
            'package_type' => 'required',
            'organization_type' => 'required|array',
            'organization_type.*' => 'exists:organizations,id',
        ]);

        if($request->package_type == "paid"){
            $validated = $request->validate([
                'discounted_type' => 'required',
                'discounted_price' => 'required',
            ]);
        }

        $package = new Package();
        $package->package_name = $request->package_name;
        $package->profile_id = $request->profile;
        $package->package_type = $request->package_type;
        $package->discounted_type = $request->discounted_type;
        $package->discounted_price = $request->discounted_price;
        $package->price = $request->price;
        $package->save();
        
        $package->organizations()->sync($request->organization_type);
        $package->tests()->sync($request->test_list);

        return redirect()->route('admin.package')->with('success', 'Package created successfully.');
    }

    public function edit($id)
    {
        $package = Package::with('tests.testProfile', 'tests.testSubprofile')->find(decrypt($id));
        $organizations = Organization::orderBy('id','desc')->get();
        $tests = Test::orderBy('id','desc')->get();
        $test_profiles = TestProfile::all();
        $sub_profiles = TestSubprofile::all();
      
        return view('admin.package.edit',compact('package','organizations','tests','test_profiles','sub_profiles'));
    }

    public function update(Request $request)
    {
 
        $validated = $request->validate([
            'package_name' => 'required',
            'profile' => 'required',
            'test_list' => 'required|array|max:6',
            'test_list.*' => 'exists:tests,id',
            'package_type' => 'required',
            'organization_type' => 'required|array',
            'organization_type.*' => 'exists:organizations,id',
        ]);

        if($request->package_type == "paid"){
            $validated = $request->validate([
                'discounted_type' => 'required',
                'discounted_price' => 'required',
            ]);
        }

        $package = Package::find(decrypt($request->package_id));
        $package->package_name = $request->package_name;
        $package->profile_id = $request->profile;
        $package->package_type = $request->package_type;
        $package->discounted_type = $request->discounted_type;
        $package->discounted_price = $request->discounted_price;
        $package->price = $request->price;
        $package->update();

        if($request->organization_type){
            $package->organizations()->sync($request->organization_type);
        }
        
        if($request->test_list){
            $package->tests()->sync($request->test_list);
        }
        
        return redirect()->route('admin.package')->with('success', 'Package Update successfully.');
    }

    public function delete(Request $request)
    {
        try {
            $package = Package::find(decrypt($request->id));
            if ($package->camps()->count() > 0) {
                return response()->json([
                    'success' => 0,
                    'message' => "Cannot delete: Package is assigned to camps.",
                ]);
            }

             $package->organizations()->detach();
             $package->tests()->detach();
            $package->delete();

            return response()->json([
                'success' => 1,
                'message' => "Package Delete successfully",
            ]);

        } catch (\Throwable $th) {
            dd($th);
            return response()->json([
                'success' => 0,
                'message' => "Internal Server Error!",
            ]);
        }
    }
}