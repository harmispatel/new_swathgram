<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbhaController extends Controller
{
    public function create()
    {
        try {
            return view('super_admin.adhar_card.abha');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }


    public function registerPatient()
    {
        try {
            return view('super_admin.adhar_card.register_patient');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
