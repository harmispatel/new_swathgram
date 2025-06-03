<?php

namespace App\Http\Controllers\labTechnician;

use App\Exports\PatientReportExport;
use App\Models\Camp;
use App\Models\Device;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;


class PatientReportController extends Controller
{
    public function index(Request $request)
    {
        try {

            $query = Patient::with('camp', 'reports.testResults.test')->orderBy('id','desc');
            if ($request->filled('organization_type')) {
                $query->where('organization_id', $request->organization_type);
            }

            if ($request->filled('camp_id')) {
                $query->where('camp_id', $request->camp_id);
            }

            if ($request->filled('gender')) {
                $query->where('gender', $request->gender);
            }

            if ($request->filled('device_code')) {
                $query->where('device_code', $request->gender);
            }

       
            if ($request->filled('test_id')) {
                $query->whereHas('reports.testResults', function ($q) use ($request) {
                    $q->where('test_id', $request->test_id);
                });
            }

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->whereHas('reports', function ($q) use ($request) {
                    $q->whereBetween('created_at', [
                        $request->start_date . ' 00:00:00',
                        $request->end_date . ' 23:59:59',
                    ]);
                });
            }

            if ($request->filled('device_id')) {
                $campIds = Device::where('id', $request->device_id)->pluck('camp_id');
                $query->whereIn('camp_id', $campIds);
            }

            $patients = $query->get();
            $organizations = Organization::orderBy('id','desc')->get();
            $camps = Camp::orderBy('id','desc')->get();
            $devices = Device::where('status','active')->orderBy('id','desc')->get();
            $tests = Test::where('is_active',1)->orderBy('id','desc')->get();

            if($request->file_type == "excel"){
              return $this->exportData($patients,$request->file_type);
            }

            if($request->file_type == "zip"){
             
                return $this->DownloadZipData($patients,$request->file_type);
            }
        
            return view('lab_technician.patient_report.index',compact('patients','organizations','camps','devices','tests'));

        } catch (\Throwable $th) {
               dd($th);
            }
    }

    //excel
    public function exportData($patients,$fileType)
    {
        try {
            if ($patients->isEmpty()) {
                return redirect()->back()->with('error', 'No patient records found.');
            }
            if ($fileType === 'excel') {
             
                return Excel::download(new PatientReportExport($patients), 'consolidated_report.xlsx');
            }
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    //zip
    public function DownloadZipData($patients, $fileType)
    {
        try {
            
            $zipFolderPath = public_path('zip_files');
            $zipFileName = 'patient_report_' . now()->format('Ymd_His') . '.zip';
            $zipFullPath = $zipFolderPath . DIRECTORY_SEPARATOR . $zipFileName;

            if (!file_exists($zipFolderPath)) {
                mkdir($zipFolderPath, 0755, true);
            }

            // Create dummy file content
            $demoFileName = 'demo.txt';
            $demoFilePath = $zipFolderPath . DIRECTORY_SEPARATOR . $demoFileName;
            file_put_contents($demoFilePath, "This is a demo file inside the ZIP.\nGenerated on " . now());

            // Create ZIP archive
            $zip = new ZipArchive;
            if ($zip->open($zipFullPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                $zip->addFile($demoFilePath, $demoFileName);
                $zip->close();
            } else {
                return redirect()->back()->with('error', 'Could not create ZIP file.');
            }
            unlink($demoFilePath);
            return response()->download($zipFullPath)->deleteFileAfterSend(true);

        } catch (\Throwable $th) {
            dd($th);
        }
    }


    // public function sendWhatsAppWithPDF()
    // {
    //     $twilioSid = env('TWILIO_ACCOUNT_SID');
    //     $twilioToken = env('TWILIO_AUTH_TOKEN');
    //     $twilioFrom = env('TWILIO_WHATSAPP_FROM'); // 'whatsapp:+14155238886'

    //     $twilio = new Client($twilioSid, $twilioToken);

    //     $to = 'whatsapp:+919999999999'; // Replace with recipient WhatsApp number
    //     $mediaUrl = asset('pdfs/invoice.pdf'); // PDF file hosted publicly

    //     try {
    //         $twilio->messages->create(
    //             $to,
    //             [
    //                 'from' => $twilioFrom,
    //                 'body' => 'Here is your PDF file.',
    //                 'mediaUrl' => [$mediaUrl],
    //             ]
    //         );

    //         return response()->json(['message' => 'PDF sent via WhatsApp!']);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()]);
    //     }
    // }

    // public function sendMultiplePDFsOnWhatsApp()
    // {
    //     $twilio = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
    //     $from = env('TWILIO_WHATSAPP_FROM'); // 'whatsapp:+14155238886'
    //     $to = 'whatsapp:+919999999999'; // Replace with receiver

    //     // Publicly accessible URLs to the PDFs
    //     $pdfUrls = [
    //         asset('pdfs/report1.pdf'),
    //         asset('pdfs/report2.pdf'),
    //         asset('pdfs/report3.pdf'),
    //     ];

    //     try {
    //         foreach ($pdfUrls as $url) {
    //             $twilio->messages->create($to, [
    //                 'from' => $from,
    //                 'body' => 'Here is one of your PDF files.',
    //                 'mediaUrl' => [$url],
    //             ]);
    //         }

    //         return response()->json(['message' => 'All PDF files sent via WhatsApp!']);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()]);
    //     }
    // }
}
