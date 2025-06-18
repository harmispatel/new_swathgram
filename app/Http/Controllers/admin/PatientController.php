<?php

namespace App\Http\Controllers\admin;

use App\Models\Camp;
use App\Models\Organization;
use App\Models\Package;
use App\Models\PackageTest;
use App\Models\Patient;
use App\Models\Report;
use App\Models\Test;
use App\Models\TestProfile;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query()->orderBy('id', 'desc');
        if ($request->filled('organization_type')) {
            $query->where('organization_id', $request->organization_type);
        }

        if ($request->filled('camp_id')) {
            $query->where('camp_id', $request->camp_id);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        $patients = $query->get();
        $organizations = Organization::orderBy('id', 'desc')->get();
        $camps = Camp::orderBy('id', 'desc')->get();

        return view('admin.patient.index', compact('patients', 'organizations', 'camps'));
    }

    public function delete(Request $request)
    {
        try {
            $patient = Patient::find(decrypt($request->id));
            $patient->delete();

            return response()->json([
                'success' => 1,
                'message' => "Patient Delete successfully",
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Internal Server Error!",
            ]);
        }
    }

}
