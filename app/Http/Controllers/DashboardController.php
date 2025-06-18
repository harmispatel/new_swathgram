<?php

namespace App\Http\Controllers;

use App\Models\LabTechnician;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
     
        $user = Auth::user();
        
        if ($user && $user->role == 1) {
            return view('super_admin.dashboard', compact('user'));
        }elseif($user && $user->role == 5){
            return view('lab_technician.dashboard', compact('user'));
        }elseif($user && $user->role == 2){
            return view('admin.dashboard', compact('user'));
        }elseif($user && $user->role == 3){
            return view('pathologist.dashboard', compact('user'));
        }elseif($user && $user->role == 6){
            return view('manager.dashboard', compact('user'));
        }
    }
    
}
