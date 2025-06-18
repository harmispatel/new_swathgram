<?php

namespace App\Http\Controllers\manager;

use App\Models\Camp;
use App\Models\Device;
use App\Models\Organization;
use App\Models\TestResult;
use Illuminate\Http\Request;

class SatelliteController extends Controller
{

    public function index()
    {
        $devices = Device::with('organizations')->orderBy('id','desc')->get();
        $organizations = $devices->pluck('organizations')
                        ->unique('id')
                        ->values();
        return view('manager.satellite_data.index', compact('organizations'));
    }

    public function show($id)
    {
        $organization = Organization::find(decrypt($id));
        $devices = Device::where('organization_id', decrypt($id))->get();
        return view('manager.satellite_data.show',compact('devices','organization'));
    }

    // public function index()
    // {
    //     $organizations = Organization::with('reports.testResults')->orderBy('id','desc')->get();
    //     foreach ($organizations as $organization) {
    //         $totalTests = 0;
    //         $totalQC = 0;

    //         foreach ($organization->reports as $report) {
    //             $totalTests += $report->testResults->count();

    //             // If QC is a boolean or status on testResults, count like:
    //             // $totalQC += $report->testResults->where('qc_status', true)->count();
    //             // Replace 'qc_status' with your actual column name for QC.
    //         }

    //         // Add counts as attributes so you can access easily in blade
    //         $organization->total_tests = $totalTests;
    //         $organization->total_qc = $totalQC;
    //     }

    //     return view('super_admin.satellite_data.index', compact('organizations'));
    // }

    // public function show($id)
    // {
    //     $organization = Organization::with('reports.testResults','devices')->find(decrypt($id));
    //   //  $devices = Device::where('organization_id', $organization->id)->first();
    //     $testResults = TestResult::whereHas('report', function ($query) use ($organization) {
    //         $query->where('organization_id', $organization->id);
    //     })->get();

    //     $camps = Camp::all();
    //     $devices = Device::all();

    //     return view('super_admin.satellite_data.show',compact('organization','testResults','camps','devices'));
    // }

    public function TestMapShow()
    {
        return view('manager.satellite_data.test_map');
    }
}
