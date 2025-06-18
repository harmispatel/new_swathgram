<?php

namespace App\Http\Controllers\pathologist;

use App\Models\Device;
use App\Models\GenericQualityControl;
use App\Models\LabTechnician;
use App\Models\Organization;
use App\Models\Test;
use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;

class QcReportController extends Controller
{
    public function index(Request $request)
    {
        $query = GenericQualityControl::with('test')->orderBy('qc_id','desc');
        if ($request->filled('organization_type')) {
            $orgId = $request->organization_type;
            $validLabIds = LabTechnician::where('organization_id', $orgId)
                                            ->pluck('id');

            $query->whereIn('Lab_id', $validLabIds);
        }

        if ($request->filled('test_id')) {
            $query->where('test_id', $request->test_id);
        }

        // if ($request->filled('device_id')) {
        //     $deviceIds = Device::where('id', $request->device_id)->pluck('camp_id');
        //     $query->whereIn('camp_id', $deviceIds);
        // }

        $qc_reports = $query->get();
        $organizations = Organization::orderBy('id','desc')->get();
        $devices = Device::where('status','active')->orderBy('id','desc')->get();
        $tests = Test::where('is_active',1)->orderBy('id','desc')->get();

        return view('pathologist.qc_report.index',compact('qc_reports','organizations','devices','tests'));
    }
}
