<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Pathologist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PathologistController extends Controller
{
    public function index()
    {
        $pathologists = Pathologist::with('organizations','organizations.camps')
                                    ->orderBy('id','desc')
                                    ->get();
   
        return view('super_admin.pathologist.index',compact('pathologists'));
    }

    public function create()
    {
        $organizations = Organization::orderBy('id','desc')->get();
        return view('super_admin.pathologist.create',compact('organizations'));
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:pathologists,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'contact' => 'required|max:11',
            'address' => 'required',
            'state' => 'required',
            'pincode' => 'required|max:6',
            'username' => 'required',
            'city' => 'required',
            'photo' => 'required',
            // 'organization_type' => 'required',
            'organization_type' => 'required|array',
            'organization_type.*' => 'exists:organizations,id',
            'dob' => 'required',
            'license' => 'required',
            'signature' => 'required'
        ]);

        
        $photo ='';
        if($request->hasFile('photo'))
        {
            $imageName = "pathologist_image_".time().".". $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move(public_path('super_admin_uploads/pathologist_image/'), $imageName);
            $photo = $imageName;
        }

        $signature ='';
        if($request->hasFile('signature'))
        {
            $imageName = "pathologist_signature_image_".time().".". $request->file('signature')->getClientOriginalExtension();
            $request->file('signature')->move(public_path('super_admin_uploads/pathologist_signature_image/'), $imageName);
            $signature = $imageName;
        }

        $license ='';
        if($request->hasFile('license'))
        {
            $imageName = "pathologist_license_image_".time().".". $request->file('license')->getClientOriginalExtension();
            $request->file('license')->move(public_path('super_admin_uploads/pathologist_license_image/'), $imageName);
            $license = $imageName;
        }

        $pathologist = new Pathologist();
        $pathologist->user_id = Auth::user()->id;
        $pathologist->name = $request->name;
        $pathologist->email = $request->email;
        $pathologist->password = Hash::make($request->password);
        $pathologist->re_password = Hash::make($request->password);
        $pathologist->contact = $request->contact;
        $pathologist->address = $request->address;
        $pathologist->state = $request->state;
        $pathologist->pincode = $request->pincode;
        $pathologist->photo = $photo;
        $pathologist->license = $license;
        $pathologist->signature = $signature;
        $pathologist->username = $request->username;
        $pathologist->city = $request->city;
        $pathologist->dob = $request->dob;
        $pathologist->save();

        $pathologist->organizations()->sync($request->organization_type);
        
        return redirect()->route('pathologists')->with('success', 'Pathologist created successfully.'); 
    }

    public function edit($id)
    {
        $pathologist = Pathologist::find(decrypt($id));
        $organizations = Organization::orderBy('id','desc')->get();
      
        return view('super_admin.pathologist.edit',compact('pathologist','package'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => Rule::unique('pathologists', 'email')->ignore(decrypt($request->pathologist_id)),
            'contact' => 'required|max:11',
            'address' => 'required',
            'state' => 'required',
            'pincode' => 'required|max:6',
            'username' => 'required',
            'city' => 'required',
            'dob' => 'required'
        ]);

        $pathologist = Pathologist::find(decrypt($request->pathologist_id));
        if($request->hasFile('photo'))
        {
            $imageName = "pathologist_image_".time().".". $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move(public_path('super_admin_uploads/pathologist_image/'), $imageName);
            $pathologist->photo = $imageName;
        }
    
        if($request->hasFile('signature'))
        {
            $imageName = "pathologist_signature_image_".time().".". $request->file('signature')->getClientOriginalExtension();
            $request->file('signature')->move(public_path('super_admin_uploads/pathologist_signature_image/'), $imageName);
            $pathologist->signature = $imageName;
        }

       
        if($request->hasFile('license'))
        {
            $imageName = "pathologist_license_image_".time().".". $request->file('license')->getClientOriginalExtension();
            $request->file('license')->move(public_path('super_admin_uploads/pathologist_license_image/'), $imageName);
            $pathologist->license = $imageName;
        }

         if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password',
            ]);

            $pathologist->password = Hash::make($request->password);
            $pathologist->re_password = Hash::make($request->password);
        }

       
        $pathologist->user_id = Auth::user()->id;
        $pathologist->name = $request->name;
        $pathologist->email = $request->email;
        $pathologist->contact = $request->contact;
        $pathologist->address = $request->address;
        $pathologist->state = $request->state;
        $pathologist->pincode = $request->pincode;
        $pathologist->username = $request->username;
        $pathologist->city = $request->city;
        $pathologist->dob = $request->dob;
        $pathologist->update();

        if($request->organization_type){
            $pathologist->organizations()->sync($request->organization_type);
        }
       
        
        return redirect()->route('pathologists')->with('success', 'Pathologist created successfully.'); 
    }

    public function delete(Request $request)
    {
        try {
            $id = decrypt($request->id);
            $pathologist = Pathologist::findOrFail($id);

            if ($pathologist->photo) {
                $photoPath = public_path(str_replace(asset('/'), '', $pathologist->photo));
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
            }

            // Delete signature
            if ($pathologist->signature) {
                $signaturePath = public_path(str_replace(asset('/'), '', $pathologist->signature));
                if (file_exists($signaturePath)) {
                    unlink($signaturePath);
                }
            }

            // Delete license
            if ($pathologist->license) {
                $licensePath = public_path(str_replace(asset('/'), '', $pathologist->license));
                if (file_exists($licensePath)) {
                    unlink($licensePath);
                }
            }

            // Detach from pivot table (organization_pathologist)
            $pathologist->organizations()->detach();
            $pathologist->delete();

            return response()->json([
                'success' => 1,
                'message' => "Pathologist Delete successfully",
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Internal Server Error!",
            ]);
        }
    }
}