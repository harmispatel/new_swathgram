<?php

namespace App\Http\Controllers\admin;

use App\Models\Camp;
use App\Models\Device;
use App\Models\LabTechnician;
use App\Models\Organization;
use App\Models\Package;
use App\Models\Pathologist;
use Illuminate\Http\Request;

class CampController extends Controller
{
    public function index()
    {
        $camps = Camp::with(['organizations', 'labTechnicians', 'pathologist'])->orderBy('id','desc')->get();
        return view('admin.camp.index',compact('camps'));
    }

    public function create()
    {  
        $organizations = Organization::orderBy('id','desc')->get();
        $pathologists = Pathologist::orderBy('id','desc')->get();
        $lab_technicians = LabTechnician::orderBy('id','desc')->get();
        $packages = Package::where('is_active',1)->orderBy('id','desc')->get();
        return view('admin.camp.create',compact('organizations','pathologists','lab_technicians','packages'));
    }

    public function getDevices(Request $request)
    {
        // try {
       
            $devices = Device::where('organization_id', $request->organization_id)->get(['id', 'device_code']);
            return response()->json($devices);
        // } catch (\Throwable $th) {
        //     dd($th);
        // }
        
    }

    public function store(Request $request)
    {
        
            $validated = $request->validate([
                'camp_name' => 'required',
                'organization_type' => 'required',
                'camp_start_date' => 'required',
                'camp_end_date' => 'required',
                'pathologist' => 'required',
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
                'lab_technician' => 'required|array',
                'lab_technician.*' => 'exists:lab_technicians,id',
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
        
            $camp = new Camp();
            $camp->camp_name = $request->camp_name;
            $camp->organization_id = $request->organization_type;
            $camp->camp_start_date = $request->camp_start_date;
            $camp->camp_end_date = $request->camp_end_date;
            $camp->pathologist_id = $request->pathologist;
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
            $camp->save();

            $camp->labTechnicians()->sync($request->lab_technician);
            
            return redirect()->route('admin.camp')->with('success', 'Camp created successfully.'); 
            
        
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
        return view('admin.camp.edit',compact('camp','pathologists','organizations','lab_technicians','packages','devices'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'camp_name' => 'required',
            'organization_type' => 'required',
            'camp_start_date' => 'required',
            'camp_end_date' => 'required',
            'pathologist' => 'required',
            'package' => 'required',
            'associated_device_id' => 'required',
            'description' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'to_email' => 'required|email',
            'cc_email' => 'required|email',
            'lab_technician' => 'required|array',
            'lab_technician.*' => 'exists:lab_technicians,id',
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
       
        $camp->camp_name = $request->camp_name;
        $camp->organization_id = $request->organization_type;
        $camp->camp_start_date = $request->camp_start_date;
        $camp->camp_end_date = $request->camp_end_date;
        $camp->pathologist_id = $request->pathologist;
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
        $camp->update();

        if(!empty($request->lab_technician)){
            $camp->labTechnicians()->sync($request->lab_technician);
        }
    
        return redirect()->route('admin.camp')->with('success', 'Camp Update successfully.');
      
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