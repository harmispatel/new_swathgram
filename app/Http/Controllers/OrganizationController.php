<?php

namespace App\Http\Controllers;

use App\Models\LabTechnician;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class OrganizationController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('organization')){
            $organizations = Organization::orderBy('id','desc')->get();
            return view('super_admin.organization.index',compact('organizations'));
        } else {
          return redirect()->back()->with('error','You have no rights for this action!');
        }
    }

    public function create()
    {
        if(Auth::user()->can('organization.create')){
            return view('super_admin.organization.create');
        }
        else{
            return redirect()->back()->with('error','You have no rights for this action!');
        }
    }

    public function store(Request $request)
    {
            $validated = $request->validate([
                'organization_name' => 'required',
                'owner_name' => 'required',
                'email' => 'required|email|unique:organizations,email',
                'password' => 'required',
                'contact' => 'required|max:11',
                'address' => 'required',
                'state' => 'required',
                'pincode' => 'required|max:6',
                'gst_pan_number' => 'required',
                'revenue_type' => 'required',
                'revenue_share' => 'required',
                'org_cin' => 'required',
                'org_info' => 'required',
                'username' => 'required',
                'country' => 'required',
            ]);

           
            $org_logo ='';
            if($request->hasFile('org_logo'))
            {
                $imageName = "organization_image_".time().".". $request->file('org_logo')->getClientOriginalExtension();
                $request->file('org_logo')->move(public_path('super_admin_uploads/organization_image/'), $imageName);
                $org_logo = $imageName;
            }

            $user = User::create([
                'username'=>$request->username,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'image' => $org_logo,
                'role'=>2,
            ]);

            $role = Role::where('id',$user->role)->first();
            $user->assignRole($role->name);

            $organization = new Organization();
            $organization->user_id = $user->id;
            $organization->organization_name = $request->organization_name;
            $organization->owner_name = $request->owner_name;
            $organization->email = $request->email;
            $organization->password = Hash::make($request->password);
            $organization->contact = $request->contact;
            $organization->address = $request->address;
            $organization->state = $request->state;
            $organization->pincode = $request->pincode;
            $organization->otp_authentication = $request->otp_authentication;
            $organization->gst_pan_number = $request->gst_pan_number;
            $organization->org_logo = $org_logo;
            $organization->premium = $request->premium;
            $organization->app_selection = $request->app_selection ?? [];
            $organization->revenue_type = $request->revenue_type;
            $organization->revenue_share = $request->revenue_share;
            $organization->org_cin = $request->org_cin ?? null;
            $organization->username = $request->username;
            $organization->country = $request->country;
            $organization->org_info = $request->org_info;
            $organization->save();
            
            return redirect()->route('organization')->with('success', 'Organization created successfully.');
    }

    public function edit($id)
    {
         if(Auth::user()->can('organization.edit')){
            $organization = Organization::find(decrypt($id));
            // $selectedApps = json_decode($organization->app_selection, true) ?? [];
            $selectedApps = $organization->app_selection ?? [];
            return view('super_admin.organization.edit',compact('organization','selectedApps'));
         }else{
            return redirect()->back()->with('error','You have no rights for this action!');
         }
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
                'organization_name' => 'required',
                'owner_name' => 'required',
                'email' => ['required','email',Rule::unique('organizations', 'email')->ignore(decrypt($request->organization_id))],
                'contact' => 'required|max:11',
                'address' => 'required',
                'state' => 'required',
                'pincode' => 'required|max:10',
                'gst_pan_number' => 'required',
                'revenue_type' => 'required',
                'revenue_share' => 'required',
                'org_cin' => 'required',
                'org_info' => 'required',
                'username' => 'required',
                'country' => 'required',
            ]);

            $organization_id = decrypt($request->organization_id);

            $organization = Organization::find($organization_id);
            if($request->hasFile('org_logo'))
            {
                $imageName = "organization_image_".time().".". $request->file('org_logo')->getClientOriginalExtension();
                $request->file('org_logo')->move(public_path('super_admin_uploads/organization_image/'), $imageName);
                $organization->org_logo = $imageName;
            }


            $user = User::find($organization->user_id);
            $user->username = $request->username;
            $user->email = $request->email;

            if ($request->filled('password')) {
                $request->validate([
                    'password' => 'required|min:6',
                ]);
                $user->password = Hash::make($request->password);
                $organization->password = Hash::make($request->password);
            }
            $user->save();
            
            $organization->user_id = Auth::user()->id;
            $organization->organization_name = $request->organization_name;
            $organization->owner_name = $request->owner_name;
            $organization->email = $request->email;
            $organization->contact = $request->contact;
            $organization->address = $request->address;
            $organization->state = $request->state;
            $organization->pincode = $request->pincode;
            $organization->otp_authentication = $request->otp_authentication;
            $organization->gst_pan_number = $request->gst_pan_number;
            $organization->premium = $request->premium;
            $organization->app_selection = $request->app_selection ?? [];
            $organization->revenue_type = $request->revenue_type;
            $organization->revenue_share = $request->revenue_share;
            $organization->org_cin = $request->org_cin ?? null;
            $organization->username = $request->username;
            $organization->country = $request->country;
            $organization->org_info = $request->org_info;
            $organization->update();
            
            return redirect()->route('organization')->with('success', 'Organization Update successfully.');
    }

    public function delete(Request $request)
    {
         if(Auth::user()->can('organization.delete')){
            try {
            
                $organization = Organization::find(decrypt($request->id));
                $lab_technician = LabTechnician::where('organization_id',$organization->id)->first();

                // pathologists,lab_technician
                if ($organization->managers()->count() > 0) {
                    return response()->json([
                        'success' => 0,
                        'message' => "Cannot delete: Organization is assigned to Manager.",
                    ]);
                }

                if ($organization->pathologists()->count() > 0) {
                    return response()->json([
                        'success' => 0,
                        'message' => "Cannot delete: Organization is assigned to Pathologists.",
                    ]);
                }
                
                if (!empty($lab_technician)) {
                    return response()->json([
                        'success' => 0,
                        'message' => "Cannot delete: Organization is assigned to lab Technician.",
                    ]);
                }
                
                $organization->delete();
                return response()->json([
                    'success' => 1,
                    'message' => "Organization Delete successfully",
                ]);

            } catch (\Throwable $th) {
                dd($th);
                return response()->json([
                    'success' => 0,
                    'message' => "Internal Server Error!",
                ]);
            }
        }else{
            return redirect()->back()->with('error','You have no rights for this action!');
         }
    }
}
