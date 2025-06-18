<?php

namespace App\Http\Controllers\manager;

use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        try {
            return view('manager.billing.index');
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
