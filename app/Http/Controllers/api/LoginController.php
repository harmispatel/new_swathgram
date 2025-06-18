<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\api\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LabTechnician;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\LoginResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends BaseController
{
    public function login(Request $request)
    {
        try {
            $role=5;
            $labtechnician = User::where('role',$role)->where('email',$request->email)->first();
            if (!$labtechnician || !Hash::check($request->password,$labtechnician->password)) {
                    return $this->sendResponse(null, 'Invalid Email and Password.', false);
            }
            $remember = $request->boolean('remember', true);

                $labtechnician->remember = $remember;
                $labtechnician->save();

                $tokenResult = $labtechnician->createToken('app-token');
                $token = $tokenResult->plainTextToken;


            return $this->sendResponse([
                'access_token' => $token,
                'user'         => new LoginResource($labtechnician),
            ], 'Login successful.', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something went wrong!', false);
        }
        
    }


    //pending
    public function forgotPassword(Request $request)
    {
     try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
            ]);

            if ($validator->fails()) {
                return $this->sendResponse(null, $validator->errors()->first(), false);
            }

            $LabTechnician = User::where('email', $request->email)->first();

            if (!$LabTechnician) {
                return $this->sendResponse(null, 'Email not found.', false);

            }

            $token = Password::createToken($LabTechnician);

            $email = $LabTechnician->email;
            Mail::send('email_api.forgetPassword', ['token' => $token,'email'=>$email], function($message) use($request){
                $message->to($request->email);
                $message->subject('Reset Password');
            });


            return $this->sendResponse(null, 'Send Link Your Mail Please Check.', true);
        } catch (\Throwable $th) {

            return $this->sendResponse(null, 'Something went wrong!', false);
        }

    }
    public function showResetPasswordForm($token,$email)
    {
        return view('passwordforgot_api.reset-password', ['token' => $token,'email'=>$email]);
    }
    public function ResetPasswordForm(Request $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return view('passwordforgot_api.redirectpage');
        }
     return back()->withInput()->withErrors(['email' => __($status)]);

    }


    public function logout(Request $request)
    {
        // $user = Auth::user();
        // $user->tokens()->delete();
        $request->user()->tokens()->delete();
        return $this->sendResponse(null, 'User logged out successfully.', true);
    }

    public function get()
    {
         try {
            $user = Auth::user();
            return $this->sendResponse([
                'user' => new loginResource($user),
            ],  'Data get successful.', true);
         } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something went wrong!', false);
        }    
    }

    public function profileupdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(null, $validator->errors()->first(), false);
        }

        $user = Auth::user();

        if (!$user) {
            return $this->sendResponse(null, 'Unauthorized.', false);
        }

        $labtechnician = LabTechnician::where('user_id', $user->id)->first();

        if (!$labtechnician) {
            return $this->sendResponse(null, 'Lab Technician not found.', false);
        }


        $user->update([
            'username' => $request->username,
            'phone'    => $request->phone,
            'address'  => $request->address
        ]);

    
        $updateData = [
            'username' => $request->username,
            'contact'  => $request->phone,
            'address'  => $request->address
        ];

     
        if ($request->hasFile('photo')) {
            $extension = $request->file('photo')->getClientOriginalExtension();
            $imageName = 'lab_technician_image_' . time() . '.' . $extension;

          
            $photo = $request->file('photo');
            $photoDirLT = public_path('super_admin_uploads/lab_technician_image/');
            $photoDirUser = public_path('super_admin_uploads/users/');

          
            $photo->move($photoDirLT, $imageName);

           
            if (file_exists($photoDirLT . $imageName)) {
                copy($photoDirLT . $imageName, $photoDirUser . $imageName);
            }

          
            $user->image = $imageName;
            $user->save();
            $updateData['photo'] = $imageName;
        }

        $labtechnician->update($updateData);
        $labtechnician->load('user');

        return $this->sendResponse([
            'user' => new loginResource($labtechnician),
        ], 'Profile updated successfully.', true);
    }


    public function changePassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'new_password' => 'required|min:6',
        ]);

    if ($validator->fails()) {
        return $this->sendResponse(null, $validator->errors()->first(), false);
    }
        $user = auth()->user();

        // if (!Hash::check($request->old_password, $user->password)) {
        //       return $this->sendResponse(null, 'Old password does not match.', false);
        // }

        $user->update([
            'password'=>Hash::make($request->new_password)
        ]);

          $labtechnician = LabTechnician::where('user_id', $user->id)->first();

            $labtechnician->update([
                'password' => Hash::make($request->new_password),
            ]);

         return $this->sendResponse(null,'Password updated successfully',true);
    }

}
