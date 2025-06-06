<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\api\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\LabTechnician;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\loginResource;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    public function login(Request $request)
    {
            $role="lab_technician";

            $labtechnician = LabTechnician::where('role',$role)->where('email',$request->email)->first();

            if (!$labtechnician || !Hash::check($request->password,$labtechnician->password)) {
                return response()->json(['error' => 'Invalid Email and Password'], 401);
            }
            $remember = $request->boolean('remember', true);

             $labtechnician->remember = $remember;
             $labtechnician->save();
             
              $tokenResult = $labtechnician->createToken('app-token');
             $token = $tokenResult->plainTextToken;

    
             return $this->sendResponse([
                'access_token' => $token,
                'user'         => new loginResource($labtechnician),
            ], 'Login successful.', true);
    }


    public function forgotPassword(Request $request)
    { 
        $request->validate(['email' => 'required|email']);

        $LabTechnician = LabTechnician::where('email', $request->email)->first();
        
        if (!$LabTechnician) {
            return response()->json(['error' => 'Email not found'], 404);
        }

        $token = Password::createToken($LabTechnician);

        $email = $LabTechnician->email;
          Mail::send('email_api.forgetPassword', ['token' => $token,'email'=>$email], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return response()->json(['success' => 'Reset token sent to your email']);
    }

    public function showResetPasswordForm($token,$email) 
    { 
        return view('passwordforgot_api.reset-password', ['token' => $token,'email'=>$email]);
    }

    
     public function ResetPasswordForm(Request $request)
    {

        $status = Password::broker('lab_technicians')->reset(
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
        $user = Auth::guard('api')->user();

        if (!$user) {
             return $this->sendResponse(null, 'Unauthorized.', false);
        }
        $user->tokens()->delete(); 
        
        return $this->sendResponse(null, 'User logged out successfully.', true);
    }

   
   public function get(){

        $labtechnician = Auth::guard('api')->user();
        if(!$labtechnician ){
             return $this->sendResponse(null, 'Unauthorized.', false);
        }
        return $this->sendResponse([
                        'user' => new loginResource($labtechnician),
                    ],  'Data get successful.', true);
   }
   
   
   
    public function profileupdate(request $request)
    {
        $request->validate([
            'username'=>'required',
        ]);

         $labtechnician = Auth::guard('api')->user();
         
            if (!$labtechnician) {
                   return $this->sendResponse(null, 'Unauthorized.', false);
            }

            $updateData = [
                'username' => $request->username,
                'address' =>$request->address,
                'contact'=>$request->contact
            ];

            if ($request->hasFile('photo')) {
                $imageName = "lab_technician_image_" . time() . "." . $request->file('photo')->getClientOriginalExtension();
                $request->file('photo')->move(public_path('super_admin_uploads/lab_technician_image/'), $imageName);
                $updateData['photo'] = $imageName; 
            }

            $labtechnician->update($updateData);

            return $this->sendResponse([
                'user' => new loginResource($labtechnician),
            ], 'Profile updated successfully.', true);
    }

     public function changePassword(Request $request)
     {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            're_password'  => 'required|same:new_password',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->old_password, $user->password)) {
              return $this->sendResponse(null, 'Old password does not match.', false);
        }

        $user->update([
            'password'=>Hash::make($request->new_password)
        ]);
          return $this->sendResponse(true,'Password updated successfully');
    }



}
