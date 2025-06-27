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
        return view('super_admin.dashboard', compact('user'));
    }
}
