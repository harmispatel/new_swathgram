<?php

namespace App\Http\Controllers;

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

        if (Auth::guard('lab_technician')->check()) {
            $user = Auth::guard('lab_technician')->user();
            return view('lab_technician.dashboard', compact('user'));
        }
    }
}
