<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:billing');
    }
    
    public function index(Request $request)
    {
        try {
            return view('super_admin.billing.index');
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
