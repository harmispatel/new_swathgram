<?php

namespace App\Http\Controllers;

use App\Exports\PatientReportExport;
use App\Models\Patient;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    // public function exportData(Request $request)
    // {
    //     try {
    //         $fileType = $request->file_type;

    //         $patients = Patient::with(['camp', 'reports.testResults.test'])
    //             ->orderBy('id', 'desc')
    //             ->get();

    //         if ($patients->isEmpty()) {
    //             return redirect()->back()->with('error', 'No patient records found.');
    //         }
    //         if ($fileType === 'excel') {
    //             return Excel::download(new PatientReportExport($patients), 'consolidated_report.xlsx');
    //         }
    //     } catch (\Throwable $th) {
    //         dd($th);
    //         return redirect()->back()->with('error', 'Something went wrong!');
    //     }
    // }
}
