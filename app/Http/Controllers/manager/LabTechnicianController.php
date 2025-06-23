<?php

namespace App\Http\Controllers\manager;

use App\Models\LabTechnician;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;

class LabTechnicianController extends Controller
{
    public function index()
    {
        $lab_technicians = LabTechnician::with('organizations.camps')->orderBy('id','desc')->get();
        return view('manager.lab_technician.index',compact('lab_technicians'));
    }

    public function create()
    {
        $organizations = Organization::orderBy('id','desc')->get();
        return view('manager.lab_technician.create',compact('organizations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:lab_technicians,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'contact' => 'required|max:11',
            'address' => 'required',
            'state' => 'required',
            'pincode' => 'required|max:6',
            'username' => 'required|unique:lab_technicians,name',
            'city' => 'required',
            'photo' => 'required',
            'organization_type' => 'required',
            'dob' => 'required',
            'signature' => 'required',
            'signature' => 'required',
            'license' => 'required'
        ]);

        
        $photo ='';
        if($request->hasFile('photo'))
        {
            $imageName = "lab_technician_image_".time().".". $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move(public_path('super_admin_uploads/lab_technician_image/'), $imageName);
            $photo = $imageName;
        }

        $signature ='';
        if($request->hasFile('signature'))
        {
            $imageName = "lab_technician_signature_image_".time().".". $request->file('signature')->getClientOriginalExtension();
            $request->file('signature')->move(public_path('super_admin_uploads/lab_technician_signature_image/'), $imageName);
            $signature = $imageName;
        }

        $certificate ='';
        if($request->hasFile('certificate'))
        {
            $imageName = "lab_technician_certificate_image_".time().".". $request->file('certificate')->getClientOriginalExtension();
            $request->file('certificate')->move(public_path('super_admin_uploads/lab_technician_certificate_image/'), $imageName);
            $certificate = $imageName;
        }

        $license ='';
        if($request->hasFile('license'))
        {
            $imageName = "lab_technician_license_image_".time().".". $request->file('license')->getClientOriginalExtension();
            $request->file('license')->move(public_path('super_admin_uploads/lab_technician_license_image/'), $imageName);
            $license = $imageName;
        }

        $user = User::create([
            'username'=>$request->username,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'phone'=>$request->contact,
            'role'=>5,
            'image'=>$photo,
        ]);


        $lab_technician = new LabTechnician();
        $lab_technician->user_id = $user->id;
        $lab_technician->organization_id = $request->organization_type;
        $lab_technician->name = $request->name;
        $lab_technician->email = $request->email;
        $lab_technician->password = Hash::make($request->password);
        $lab_technician->re_password = Hash::make($request->password);
        $lab_technician->contact = $request->contact;
        $lab_technician->address = $request->address;
        $lab_technician->state = $request->state;
        $lab_technician->pincode = $request->pincode;
        $lab_technician->photo = $photo;
        $lab_technician->certificate = $certificate;
        $lab_technician->license = $license;
        $lab_technician->signature = $signature;
        $lab_technician->username = $request->username;
        $lab_technician->city = $request->city;
        $lab_technician->dob = $request->dob;
        $lab_technician->save();  
        
        

        return redirect()->route('manager.lab_technician')->with('success', 'Lab Technician created successfully.'); 
    }

    public function edit($id)
    {
        $lab_technician = LabTechnician::find(decrypt($id));
        $organizations = Organization::orderBy('id','desc')->get();
      
        return view('manager.lab_technician.edit',compact('lab_technician','organizations'));
    }

    public function update(Request $request)
    {
      
        $validated = $request->validate([
            'name' => 'required',
            'email' => Rule::unique('lab_technicians', 'email')->ignore(decrypt($request->lab_technician_id)),
            'contact' => 'required|max:11',
            'address' => 'required',
            'state' => 'required',
            'pincode' => 'required|max:6',
            'username' => ['required',Rule::unique('lab_technicians')->ignore(decrypt($request->lab_technician_id)),],
            'city' => 'required',
            'dob' => 'required',
        ]);

        $lab_technician = LabTechnician::find(decrypt($request->lab_technician_id));
        if($request->hasFile('photo'))
        {
            $imageName = "lab_technician_image_".time().".". $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move(public_path('super_admin_uploads/lab_technician_image/'), $imageName);
            $lab_technician->photo = $imageName;
        }
    
        if($request->hasFile('signature'))
        {
            $imageName = "lab_technician_signature_image_".time().".". $request->file('signature')->getClientOriginalExtension();
            $request->file('signature')->move(public_path('super_admin_uploads/lab_technician_signature_image/'), $imageName);
            $lab_technician->signature = $imageName;
        }

       
        if($request->hasFile('certificate'))
        {
            $imageName = "lab_technician_certificate_image_".time().".". $request->file('certificate')->getClientOriginalExtension();
            $request->file('certificate')->move(public_path('super_admin_uploads/lab_technician_certificate_image/'), $imageName);
            $lab_technician->certificate = $imageName;
        }

        if($request->hasFile('license'))
        {
            $imageName = "lab_technician_license_image_".time().".". $request->file('license')->getClientOriginalExtension();
            $request->file('license')->move(public_path('super_admin_uploads/lab_technician_license_image/'), $imageName);
            $lab_technician->license = $imageName;
        }

         $updateData = [
            'username' => $request->username ?? '',
            'email'    => $request->email ?? '',
            'phone'    => $request->contact ?? '',
            
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        if (isset($imageName)) {
            $updateData['image'] = $imageName;
        }

        $user = User::find($lab_technician->user_id);
        $user->update($updateData);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password',
            ]);

            $lab_technician->password = Hash::make($request->password);
            $lab_technician->re_password = Hash::make($request->password); 
        }
    
        $lab_technician->name = $request->name;
        $lab_technician->organization_id = $request->organization_type;
        $lab_technician->email = $request->email;
        $lab_technician->contact = $request->contact;
        $lab_technician->address = $request->address;
        $lab_technician->state = $request->state;
        $lab_technician->pincode = $request->pincode;
        $lab_technician->username = $request->username;
        $lab_technician->city = $request->city;
        $lab_technician->dob = $request->dob;
        $lab_technician->update();

        return redirect()->route('manager.lab_technician')->with('success', 'Lab Technician Update Successfully.'); 
    }

    public function delete(Request $request)
    {
        try {
          $labtechnicianId=decrypt($request->id);

            $lab_technician=LabTechnician::findOrFail($labtechnicianId);

             if (!$lab_technician) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Lab Technician not found',
                ]);
            }

             $user = User::findOrFail($lab_technician->user_id);
             $lab_technician->delete();

            if ($user) {
                $user->delete();
            }

            return response()->json([
                'success' => 1,
                'message' => "Lab Technician Delete successfully",
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Internal Server Error!",
            ]);
        }
    }
}