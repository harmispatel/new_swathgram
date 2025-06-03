<?php

namespace App\Http\Controllers;

use App\Models\Camp;
use App\Models\Device;
use App\Models\LabTechnician;
use App\Models\Organization;
use App\Models\Package;
use App\Models\Pathologist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CampController extends Controller
{
    public function index()
    {
        $camps = Camp::with('organizations.camps','LabTechnician','pathologist')->orderBy('id','desc')->get();
        return view('super_admin.camp.index',compact('camps'));
    }

    public function create()
    {
        $organizations = Organization::orderBy('id','desc')->get();
        $pathologists = Pathologist::orderBy('id','desc')->get();
        $lab_technicians = LabTechnician::orderBy('id','desc')->get();
        $packages = Package::where('is_active',1)->orderBy('id','desc')->get();
        return view('super_admin.camp.create',compact('organizations','pathologists','lab_technicians','packages'));
    }

    public function getDevices(Request $request)
    {
        $devices = Device::where('organization_id', $request->organization_id)->get(['id', 'device_code']);
        return response()->json($devices);
    }

    public function getSignatures(Request $request)
    {
        $id = $request->pathologist_id;
        $pathologist = Pathologist::find($id);
        
        if (!$pathologist) {
            return response()->json(['success' => false, 'message' => 'Pathologist not found'], 404);
        }

        return response()->json([
            'success' => 1,
            'signatures' => [
                asset("public/super_admin_uploads/pathologist_signature_image/{$pathologist->signature}"),
                null,
                null,
                null,
            ]
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'camp_name' => 'required',
            'organization_type' => 'required',
            'camp_start_date' => 'required',
            'camp_end_date' => 'required',
            'pathologist' => 'required',
            'lab_technician' => 'required',
            'package' => 'required',
            'associated_device_id' => 'required',
            'description' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'to_email' => 'required|email',
            'cc_email' => 'required|email',
            'report_header_image' => 'required',
            'report_footer_image' => 'required',
            'signature_4' => 'required'
        ]);

        $report_header_image ='';
        if($request->hasFile('report_header_image'))
        {
            $imageName = "camp_header_image_".time().".". $request->file('report_header_image')->getClientOriginalExtension();
            $request->file('report_header_image')->move(public_path('super_admin_uploads/camp_header_image/'), $imageName);
            $report_header_image = $imageName;
        }

        $report_footer_image ='';
        if($request->hasFile('report_footer_image'))
        {
            $imageName = "camp_footer_image_".time().".". $request->file('report_footer_image')->getClientOriginalExtension();
            $request->file('report_footer_image')->move(public_path('super_admin_uploads/camp_footer_image/'), $imageName);
            $report_footer_image = $imageName;
        }

        $report_header_status = isset($request->report_header_status) ? $request->report_header_status : 0;
        $report_footer_status = isset($request->report_footer_status) ? $request->report_footer_status : 0;
        // $signature_1_status = isset($request->signature_1_status) ? $request->signature_1_status : 0; 
        // $signature_2_status = isset($request->signature_2_status) ? $request->signature_2_status : 0; 
        // $signature_3_status = isset($request->signature_3_status) ? $request->signature_3_status : 0;
        // $signature_4_status = isset($request->signature_4_status) ? $request->signature_4_status : 0;

        $camp = new Camp();
        $camp->camp_name = $request->camp_name;
        $camp->organization_id = $request->organization_type;
        $camp->camp_start_date = $request->camp_start_date;
        $camp->camp_end_date = $request->camp_end_date;
        $camp->pathologist_id = $request->pathologist;
        $camp->lab_technician_id = $request->lab_technician;
        $camp->package_id = $request->package;
        $camp->associated_device_id = $request->associated_device_id;
        $camp->address = $request->address;
        $camp->state = $request->state;
        $camp->pincode = $request->pincode;
        $camp->city = $request->city;
        $camp->description = $request->description;
        $camp->to_email = $request->to_email;
        $camp->cc_email = $request->cc_email;

        $camp->report_header_image = $report_header_image;
        $camp->report_header_status = $report_header_status;
        $camp->report_footer_image = $report_footer_image;
        $camp->report_footer_status = $report_footer_status;

        $camp->signature_1 = $request->signature_1;
        $camp->signature_2 = $request->signature_2;
        $camp->signature_3 = $request->signature_3;
        $camp->signature_4 = $request->signature_4;

        // $camp->signature_1_status = $signature_1_status;
        // $camp->signature_2_status = $signature_2_status;
        // $camp->signature_3_status = $signature_3_status;
        // $camp->signature_4_status = $signature_4_status;
        $camp->save();
        
        return redirect()->route('camp')->with('success', 'Camp created successfully.'); 
       
    }

    public function edit($id)
    {
        $camp = Camp::find(decrypt($id));
        $organizations = Organization::orderBy('id','desc')->get();
        $pathologists = Pathologist::orderBy('id','desc')->get();
        $lab_technicians = LabTechnician::orderBy('id','desc')->get();
        $packages = Package::where('is_active',1)->orderBy('id','desc')->get();
      
        $devices = [];
        if ($camp->organization_id) {
            $devices = Device::where('organization_id', $camp->organization_id)->get();
        }
        return view('super_admin.camp.edit',compact('camp','pathologists','organizations','lab_technicians','packages','devices'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'camp_name' => 'required',
            'organization_type' => 'required',
            'camp_start_date' => 'required',
            'camp_end_date' => 'required',
            'pathologist' => 'required',
            'lab_technician' => 'required',
            'package' => 'required',
            'associated_device_id' => 'required',
            'description' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'to_email' => 'required|email',
            'cc_email' => 'required|email',
            // 'signature_4' => 'required'
        ]);

        $camp = Camp::find(decrypt($request->camp_id));
        if($request->hasFile('report_header_image'))
        {
            $imageName = "camp_header_image_".time().".". $request->file('report_header_image')->getClientOriginalExtension();
            $request->file('report_header_image')->move(public_path('super_admin_uploads/camp_header_image/'), $imageName);
            $camp->report_header_image = $imageName;
        }

        if($request->hasFile('report_footer_image'))
        {
            $imageName = "camp_footer_image_".time().".". $request->file('report_footer_image')->getClientOriginalExtension();
            $request->file('report_footer_image')->move(public_path('super_admin_uploads/camp_footer_image/'), $imageName);
            $camp->report_footer_image = $imageName;
        }

        $report_header_status = isset($request->report_header_status) ? $request->report_header_status : 0;
        $report_footer_status = isset($request->report_footer_status) ? $request->report_footer_status : 0;
        // $signature_1_status = isset($request->signature_1_status) ? $request->signature_1_status : 0; 
        // $signature_2_status = isset($request->signature_2_status) ? $request->signature_2_status : 0; 
        // $signature_3_status = isset($request->signature_3_status) ? $request->signature_3_status : 0;
        // $signature_4_status = isset($request->signature_4_status) ? $request->signature_4_status : 0;

       
        $camp->camp_name = $request->camp_name;
        $camp->organization_id = $request->organization_type;
        $camp->camp_start_date = $request->camp_start_date;
        $camp->camp_end_date = $request->camp_end_date;
        $camp->pathologist_id = $request->pathologist;
        $camp->lab_technician_id = $request->lab_technician;
        $camp->package_id = $request->package;
        $camp->associated_device_id = $request->associated_device_id;
        $camp->address = $request->address;
        $camp->state = $request->state;
        $camp->pincode = $request->pincode;
        $camp->city = $request->city;
        $camp->description = $request->description;
        $camp->to_email = $request->to_email;
        $camp->cc_email = $request->cc_email;

        $camp->report_header_status = $report_header_status;
        $camp->report_footer_status = $report_footer_status;

        $camp->signature_1 = $request->signature_1;
        $camp->signature_2 = $request->signature_2;
        $camp->signature_3 = $request->signature_3;
        $camp->signature_4 = $request->signature_4;

        // $camp->signature_1_status = $signature_1_status;
        // $camp->signature_2_status = $signature_2_status;
        // $camp->signature_3_status = $signature_3_status;
        // $camp->signature_4_status = $signature_4_status;
        $camp->update();
        
        return redirect()->route('camp')->with('success', 'Camp Update successfully.');
      
    }

    public function delete(Request $request)
    {
        try {
         
            $camp = Camp::find(decrypt($request->id));

            // Delete header image
            if (!empty($camp->report_header_image)) {
                $headerPath = public_path('super_admin_uploads/camp_header_image/' . $camp->report_header_image);
                if (file_exists($headerPath)) {
                    unlink($headerPath);
                }
            }

            // Delete footer image
            if (!empty($camp->report_footer_image)) {
                $footerPath = public_path('super_admin_uploads/camp_footer_image/' . $camp->report_footer_image);
                if (file_exists($footerPath)) {
                    unlink($footerPath);
                }
            }
            $camp->delete();

            return response()->json([
                'success' => 1,
                'message' => "Camp Delete successfully",
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Internal Server Error!",
            ]);
        }
    }
}


Route::post('camp/signatures', 'getSignatures')->name('camp.signature');