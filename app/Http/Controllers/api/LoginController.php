<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;


class LoginController extends Controller
{
    public function login(Request $request)
    {
            $role="lab_technician";

            $user = User::where('role',$role)->where('email',$request->email)->first();

            if (!$user || !Hash::check($request->password,$user->password)) {
                return response()->json(['error' => 'Invalid Email and Password'], 401);
            }

            $token = $user->createToken('app-token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user,
                'success' => 'Successfully logged in',
            ]);
    }


    public function forgotPassword(Request $request)
    { 
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Email not found'], 404);
        }

        $token = Password::createToken($user);

          Mail::send('email_api.forgetPassword', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return response()->json(['success' => 'Reset token sent to your email']);
    }

    public function showResetPasswordForm($token) 
    { 
        return view('passwordforgot_api.forgetPasswordLink', ['token' => $token]);
    }

    public function ResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );
        if ($status == Password::PASSWORD_RESET) {
            return back()->with('success', 'Your password has been changed!');
        }

        return back()->withErrors(['email' => __($status)]);
    }
    
}
