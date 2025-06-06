<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceCatalog;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::with('organizations.camps')->orderBy('id','desc')->get();
        return view('super_admin.device.index',compact('devices'));
    }

    public function create()
    {
        $device_categories = DeviceCatalog::orderBy('id','desc')->get();
        $organizations = Organization::orderBy('id','desc')->get();
        return view('super_admin.device.create',compact('organizations','device_categories'));
    }

    // function generateDeviceCode()
    // {
    //     $prefix = 'LAB';
    //     $middle = 'AH';
    //     $randomNumber = rand(1000, 9999); // 4-digit number
    //     $randomAlpha = strtoupper(Str::random(4)); // 4-character uppercase

    //     return $prefix . $randomNumber . $middle . $randomAlpha;
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_name' => 'required',
            'device_code' => 'required|unique:devices,device_code',
            'device_detail' => 'required',
            'device_serial' => 'required|unique:devices,device_serial',    
            'organization_type' => 'required',
        ]);

        $device = new Device();
        $device->device_code = $request->device_code;
        $device->notes = $request->device_detail;
        $device->device_serial = $request->device_serial;
        $device->organization_id = $request->organization_type;
        $device->save();

        $device_categorie = DeviceCatalog::where('id',$request->device_name)->first();
        $device_categorie->device_code = $request->device_code;
        $device_categorie->update();
        
        return redirect()->route('device')->with('success', 'Device created successfully.'); 
    }

    public function edit($id)
    {
        $device = Device::find(decrypt($id));
        $organizations = Organization::orderBy('id','desc')->get();
        $device_categories = DeviceCatalog::orderBy('id','desc')->get(); 
        return view('super_admin.device.edit',compact('device','organizations','device_categories'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'device_name' => 'required',
            'device_code' => Rule::unique('devices', 'device_code')->ignore(decrypt($request->device_id)),
            'device_detail' => 'required',
            'device_serial' => 'required',
            'organization_type' => 'required',
        ]);

        $device = Device::find(decrypt($request->device_id));
        $device->device_code = $request->device_code;
        $device->notes = $request->device_detail;
        $device->device_serial = $request->device_serial;
        $device->organization_id = $request->organization_type;
        $device->update();

        $device_categorie = DeviceCatalog::where('id',$request->device_name)->first();
        $device_categorie->device_code = $request->device_code;
        $device_categorie->update();
        
        return redirect()->route('device')->with('success', 'Device created successfully.'); 
    }

    public function delete(Request $request)
    {
        try {
            $device = Device::find(decrypt($request->id));
            DeviceCatalog::where('device_code', $device->device_code)->update(['device_code' => null]);
            $device->delete();

            return response()->json([
                'success' => 1,
                'message' => "Device Delete successfully",
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Internal Server Error!",
            ]);
        }
    }
}
