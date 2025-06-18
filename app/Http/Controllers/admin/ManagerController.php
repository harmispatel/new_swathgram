<?php

namespace App\Http\Controllers\admin;

use App\Models\Manager;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;



class ManagerController extends Controller
{
    public function index()
    {
        $managers = Manager::with('organization')->orderBy('id','desc')->get();
        return view('admin.manager.index',compact('managers'));
    }

    public function create()
    {
        $organizations = Organization::orderBy('id','desc')->get();
        return view('admin.manager.create',compact('organizations'));
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required|unique:managers,name',
            'email' => 'required|email|unique:managers,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'contact' => 'required|max:11',
            'address' => 'required',
            'state' => 'required',
            'pincode' => 'required|max:6',
            'username' => 'required',
            'city' => 'required',
            'photo' => 'required',
            'organization_type' => 'required',
            'dob' => 'required'
        ]);

        
        $photo ='';
        if($request->hasFile('photo'))
        {
            $imageName = "manager_image_".time().".". $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move(public_path('super_admin_uploads/manager_image/'), $imageName);
            $photo = $imageName;
        }

        $degree ='';
        if($request->hasFile('degree'))
        {
            $imageName = "manager_degree_image_".time().".". $request->file('degree')->getClientOriginalExtension();
            $request->file('degree')->move(public_path('super_admin_uploads/manager_degree_image/'), $imageName);
            $degree = $imageName;
        }

        $user = User::create([
            'username'=>$request->username,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'phone'=>$request->contact,
            'role'=>6,
            'image'=>$photo,
        ]);

        $manager = new Manager();
        $manager->user_id = $user->id;
        $manager->organization_id = $request->organization_type;
        $manager->name = $request->name;
        $manager->email = $request->email;
        $manager->password = Hash::make($request->password);
        $manager->re_password = Hash::make($request->password);
        $manager->contact = $request->contact;
        $manager->address = $request->address;
        $manager->state = $request->state;
        $manager->pincode = $request->pincode;
        $manager->photo = $photo;
        $manager->degree = $degree;
        $manager->username = $request->username;
        $manager->city = $request->city;
        $manager->dob = $request->dob;
        $manager->save();
        
        return redirect()->route('admin.managers')->with('success', 'Manager created successfully.'); 
    }

    public function edit($id)
    {
        $manager = Manager::find(decrypt($id));
        $organizations = Organization::orderBy('id','desc')->get();
        return view('admin.manager.edit',compact('manager','organizations'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => Rule::unique('managers', 'email')->ignore(decrypt($request->manager_id)),
            'contact' => 'required|max:11',
            'address' => 'required',
            'state' => 'required',
            'pincode' => 'required|max:6',
            'username' => ['required',Rule::unique('managers')->ignore(decrypt($request->manager_id)),],
            'city' => 'required',
            'organization_type' => 'required',
            'dob' => 'required'
        ]);

        $manager = Manager::find(decrypt($request->manager_id));

        // dd($manager);
        if($request->hasFile('photo'))
        {
            $imageName = "manager_image_".time().".". $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move(public_path('super_admin_uploads/manager_image/'), $imageName);
            $manager->photo = $imageName;
        }

        if($request->hasFile('degree'))
        {
            $imageName = "manager_degree_image_".time().".". $request->file('degree')->getClientOriginalExtension();
            $request->file('degree')->move(public_path('super_admin_uploads/manager_degree_image/'), $imageName);
            $manager->degree = $imageName;
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

        $user = User::find($manager->user_id);
        $user->update($updateData);
              
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password',
            ]);
            $manager->password = Hash::make($request->password);
            $manager->re_password = Hash::make($request->password);
        }
       
        $manager->user_id = Auth::user()->id;
        $manager->organization_id = $request->organization_type;
        $manager->name = $request->name;
        $manager->email = $request->email;
        $manager->contact = $request->contact;
        $manager->address = $request->address;
        $manager->state = $request->state;
        $manager->pincode = $request->pincode;
        $manager->username = $request->username;
        $manager->city = $request->city;
        $manager->dob = $request->dob;
        $manager->update();
        
        return redirect()->route('admin.managers')->with('success', 'Manager Update successfully.'); 
    }

    public function delete(Request $request)
    {
        try {
         
            Manager::where('id',decrypt($request->id))->delete();
            return response()->json([
                'success' => 1,
                'message' => "Manager Delete successfully",
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