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
        if ($user && $user->role === 'super_admin') {
            return view('super_admin.dashboard', compact('user'));
        }

        $lab_technician = LabTechnician::where('user_id',$user->id)->first();
        if ($lab_technician) {
            return view('lab_technician.dashboard', compact('lab_technician'));
        }
    }
}
