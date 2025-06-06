<?php

namespace App\Http\Controllers;

use App\Exports\PatientReportExport;
use App\Models\Camp;
use App\Models\Device;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\Report;
use App\Models\Test;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;


class RevenueController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Report::with('patient','organization','testResults')->orderBy('id','desc');
            if ($request->filled('organization_type')) {
                $query->where('organization_id', $request->organization_type);
            }
       
            if ($request->filled('test_id')) {
                $query->whereHas('testResults', function ($q) use ($request) {
                    $q->where('test_id', $request->test_id);
                });
            }

           if ($request->filled('start_datetime') && $request->filled('end_datetime')) {
                $start = Carbon::parse($request->start_datetime)->startOfMinute();
                $end = Carbon::parse($request->end_datetime)->endOfMinute();

                $query->whereBetween('created_at', [$start, $end]);
            }

            $reports = $query->get();
            $organizations = Organization::orderBy('id','desc')->get();
            $tests = Test::where('is_active',1)->orderBy('id','desc')->get();

            // if($request->file_type == "excel"){
            //   return $this->exportData($reports,$request->file_type);
            // }

            // if($request->file_type == "zip"){
             
            //     return $this->DownloadZipData($reports,$request->file_type);
            // }

            // Group by organization_id and calculate data
            $groupedReports = $reports->groupBy('organization_id')->map(function ($orgReports) {
                $organization = $orgReports->first()->organization;

                $totalTestCount = $orgReports->sum(fn($r) => $r->testResults->count());
                $totalTestValue = $orgReports->sum(fn($r) => $r->testResults->sum('value'));

                $ourRevenue = 0;
                if ($organization) {
                    if ($organization->revenue_type === 'amount') {
                        $ourRevenue = $totalTestValue - $organization->revenue_share;
                    } elseif ($organization->revenue_type === 'percentage') {
                        $ourRevenue = $totalTestValue - ($totalTestValue * $organization->revenue_share / 100);
                    }
                }

                return [
                    'organization' => $organization,
                    'test_count' => $totalTestCount,
                    'test_value' => $totalTestValue,
                    'our_revenue' => $ourRevenue,
                    'report_ids' => $orgReports->pluck('id')->toArray(), // optional
                    'date' => $orgReports->first()->created_at ?? now(),
                ];
            });

            $totalOurRevenue = $groupedReports->sum('our_revenue');
        
            return view('super_admin.revenue.index',compact('reports','totalOurRevenue','groupedReports','organizations','tests'));

        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
