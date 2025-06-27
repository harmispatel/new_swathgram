<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ManagerController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('permission:managers|manager.create|manager.edit|manager.update|manager.delete');
    //     $this->middleware('permission:manager.create')->only(['create', 'store']);
    //     $this->middleware('permission:manager.edit')->only(['edit', 'update']);
    //     $this->middleware('permission:manager.delete')->only(['delete']);
    // }


    public function index()
    {
         if(Auth::user()->can('managers')){
            $managers = Manager::with('organization')->orderBy('id','desc')->get();
            return view('super_admin.manager.index',compact('managers'));
        } else {
          return redirect()->back()->with('error','You have no rights for this action!');
        }    
    }

    public function create()
    {
        if(Auth::user()->can('manager.create')){
            $user = Auth::user();
            if($user->role == '2'){
                $organizations = Organization::where('user_id',$user->id)->orderBy('id','desc')->get();
            }else{
                $organizations = Organization::orderBy('id','desc')->get();
            }
            return view('super_admin.manager.create',compact('organizations'));
        } else {
          return redirect()->back()->with('error','You have no rights for this action!');
        }    
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
        ]);

        $role = Role::where('id',$user->role)->first();
        $user->assignRole($role->name);

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
        return redirect()->route('managers')->with('success', 'Manager created successfully.'); 
    }

    public function edit($id)
    {
        if(Auth::user()->can('manager.edit')){
            $manager = Manager::find(decrypt($id));
            $user = Auth::user();
            if($user->role == '2'){
                $organizations = Organization::where('user_id',$user->id)->orderBy('id','desc')->get();
            }else{
                $organizations = Organization::orderBy('id','desc')->get();
            }
        
             return view('super_admin.manager.edit',compact('manager','organizations'));

         } else {
          return redirect()->back()->with('error','You have no rights for this action!');
        }
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
        
        return redirect()->route('managers')->with('success', 'Manager created successfully.'); 
    }

    // public function delete(Request $request)
    // {
    //     try {
         
    //         Manager::where('id',decrypt($request->id))->delete();
    //         return response()->json([
    //             'success' => 1,
    //             'message' => "Manager Delete successfully",
    //         ]);

    //     } catch (\Throwable $th) {
    //         dd($th);
    //         return response()->json([
    //             'success' => 0,
    //             'message' => "Internal Server Error!",
    //         ]);
    //     }
    // }

    public function delete(Request $request)
    {
        if(Auth::user()->can('manager.delete')){
            try {
                $managerId = decrypt($request->id);

                $manager = Manager::findOrFail($managerId);

                if (!$manager) {
                    return response()->json([
                        'success' => 0,
                        'message' => 'Manager not found',
                    ]);
                }

                $user = User::findOrFail($manager->user_id);
                $manager->delete();

                if ($user) {
                    $user->delete();
                }

                return response()->json([
                    'success' => 1,
                    'message' => "Manager Delete successfully",
                ]);

            }  catch (\Throwable $th) {
                dd($th);
                return response()->json([
                    'success' => 0,
                    'message' => "Internal Server Error!",
                ]);
            }
         } else {
          return redirect()->back()->with('error','You have no rights for this action!');
        }    
        
    }

}