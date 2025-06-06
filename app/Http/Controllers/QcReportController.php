<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\GenericQualityControl;
use App\Models\Organization;
use App\Models\Test;
use Illuminate\Http\Request;

class QcReportController extends Controller
{
    public function index(Request $request)
    {
        $query = GenericQualityControl::with('test')->orderBy('qc_id','desc');
        if ($request->filled('organization_type')) {
            $query->where('organization_id', $request->organization_type);
        }

        if ($request->filled('test_id')) {
            $query->whereHas('reports.testResults', function ($q) use ($request) {
                $q->where('test_id', $request->test_id);
            });
        }

        if ($request->filled('device_id')) {
            $deviceIds = Device::where('id', $request->device_id)->pluck('camp_id');
            $query->whereIn('camp_id', $deviceIds);
        }

        $qc_reports = $query->get();
        $organizations = Organization::orderBy('id','desc')->get();
        $devices = Device::where('status','active')->orderBy('id','desc')->get();
        $tests = Test::where('is_active',1)->orderBy('id','desc')->get();

        return view('super_admin.qc_report.index',compact('qc_reports','organizations','devices','tests'));
    }
}
