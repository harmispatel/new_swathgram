<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function myProfile($id)
    {
        if(Auth::user()->role == "super_admin")
        {
            $data['user'] = User::where('id',decrypt($id))->first();
            return view('auth.profile.super_admin_profile',$data);
        }
        // else
        // {
        //     $data['user'] = User::with(['hasOneShop','hasOneSubscription'])->where('id',decrypt($id))->first();
        //     return view('auth.client-profile',$data);
        // }
    }


    public function editProfile($id)
    {
        if(Auth::user()->role == "super_admin")
        {
            $data['user'] = User::where('id',decrypt($id))->first();
            return view('auth.profile.super_admin_profile_edit',$data);
        }
        // else
        // {
        //     $data['user'] = User::with(['hasOneShop','hasOneSubscription'])->where('id',decrypt($id))->first();
        //     return view('auth.client-profile-edit',$data);
        // }
    }

    public function updateProfile(Request $request)
    {
        $user  = User::find($request->user_id);

        if(Auth::user()->role == "super_admin")
        {
            $request->validate([
                'firstname'             =>      'required',
                'email'                 =>      'required|email|unique:users,email,'.$request->user_id,
                'confirm_password'      =>      'same:password',
                'profile_picture'       =>      'mimes:png,jpg,svg,jpeg,PNG,SVG,JPG,JPEG'
            ]);

            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->email = $request->email;

            if(!empty($request->password))
            {
                $user->password = Hash::make($request->password);
            }

            if($request->hasFile('profile_picture'))
            {
                // Remove Old Image
                $old_image = isset($user->image) ? $user->image : '';
                if(!empty($old_image) && file_exists($old_image))
                {
                    unlink($old_image);
                }

                // Insert New Image
                $imgname = time().".". $request->file('profile_picture')->getClientOriginalExtension();
                $request->file('profile_picture')->move(public_path('super_admin_uploads/users/'), $imgname);
                $user->image = $imgname;
            }

            $user->update();
            return redirect()->route('admin.profile.view',encrypt($request->user_id))->with('success','Profile has been Updated SuccessFully..');
        }
    }

}
