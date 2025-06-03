<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PatientReportExport implements FromCollection, WithHeadings
{
    protected $patients;
    public function __construct($patients)
    {
        $this->patients = $patients;
    }

    public function collection()
    {
        $exportData = collect();

        foreach ($this->patients as $patient) {
            $firstRow = true;

            $totalAmount = 0;
            foreach ($patient->reports as $report) {
                foreach ($report->testResults as $testResult) {
                    $totalAmount += $testResult->value ?? 0;
                }
            }

            foreach ($patient->reports as $report) {
                foreach ($report->testResults as $result) {
                    $row = [
                        'Org Name'       => $firstRow ? ($patient->organizations->organization_name ?? '') : '',
                        'Camp Name'      => $firstRow ? ($patient->camp->camp_name ?? '') : '',
                        'Patient Id'     => $firstRow ? $patient->patient_code : '',
                        'Patient Name'   => $firstRow ? $patient->username : '',
                        'Contact'        => $firstRow ? $patient->mobile_number : '',
                        'Age'            => $firstRow ? $patient->age : '',
                        'Gender'         => $firstRow ? $patient->gender : '',
                        'MRN Number'     => $firstRow ? ($report->id ?? '') : '',
                        'Test'           => $result->test->test_name ?? '',
                        'Result'         => $result->value ?? '',
                        'Normal Range'   => $result->test->normal_range ?? '',
                        'Status'         => '',
                        'Amount'         => $firstRow ? $totalAmount : '',
                        'Created'        => optional($report->created_at)->format('d/m/Y H:i'),
                    ];

                    $exportData->push($row);
                    $firstRow = false;
                }
            }
        }

        return $exportData;
    }

    public function headings(): array
    {
        return [
            'Org Name',
            'Camp Name',
            'Patient Id',
            'Patient Name',
            'Contact',
            'Age',
            'Gender',
            'MRN Number',
            'Test',
            'Result',
            'Normal Range',
            'Status',
            'Amount',
            'Created',
        ];
    }
}