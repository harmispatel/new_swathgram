<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $input = $request->except('_token');

        // lab_technician guard
        // if (Auth::->attempt($input)) {
        //     $labTech = Auth::guard('lab_technician')->user();
        //     $username = $labTech->username;
        //     return redirect()->route('lab_technician.dashboard')->with('success', 'Welcome ' . $username);
        // }
        
        if (Auth::attempt($input)){
            $role = Auth::user()->role; //elseif(Auth::user()->role == 5)
            if ($role == 1){
                $username = Auth::user()->firstname." ".Auth::user()->lastname;
                return redirect()->route('super_admin.dashboard')->with('success', 'Welcome '.$username);
            }elseif($role == 5){
                    
                $username = Auth::user()->firstname." ".Auth::user()->lastname;
                return redirect()->route('super_admin.dashboard')->with('success', 'Welcome ' . $username);

            }elseif($role == 2){

                dd($role == 2);
                 $username = Auth::user()->firstname." ".Auth::user()->lastname;
                return redirect()->route('super_admin.dashboard')->with('success', 'Welcome ' . $username);
            }
                
            
        }
        return back()->with('error', 'Please Enter Valid Email & Password');
    }

    public function logout()
    {
        session()->forget('locale');
        session()->save();
        Auth::logout();
        return redirect()->route('login');
    }

    // public function showForgotPassword()
    // {
        //     return view('auth.forgot_password');
    // }

    // public function ForgotPassword(Request $request)
    // {
        //     $request->validate([
        //         'email' => 'required|email|exists:users,email',
        //         'old_password' => 'required',
        //         'password' => 'required|min:6|confirmed',
        //     ]);

        //     $user = User::where('email', $request->email)->first();

        //     if (!Hash::check($request->old_password, $user->password)) {
        //         return back()->withErrors(['old_password' => 'Old password is incorrect.']);
        //     }

        //     $user->password = Hash::make($request->password);
        //     $user->save();

        //     return redirect()->route('login')->with('success', 'Password changed successfully.');
    // }


    public function showForgetPasswordForm()
    {
        return view('auth.forgetPassword');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);
        
        PasswordReset::create([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });
        return back()->with('success', 'We have e-mailed your password reset link!');
    }

    public function showResetPasswordForm($token) 
    { 
        return view('auth.forgetPasswordLink', ['token' => $token]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = PasswordReset::where([
                                'email' => $request->email, 
                                'token' => $request->token
                            ])->first();

        if(!$updatePassword){
            return back()->with('error', 'Invalid token!');
        }

        $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

        PasswordReset::where(['email'=> $request->email])->delete();
        return redirect('/login')->with('success', 'Your password has been changed!');
    }
}
