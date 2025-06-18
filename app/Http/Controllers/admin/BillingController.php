<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;



class BillingController extends Controller
{
    public function index(Request $request)
    {
        try {
            return view('admin.billing.index');
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
