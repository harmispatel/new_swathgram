<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RevenueExport implements FromCollection, WithHeadings
{
    protected $groupedReports;

    public function __construct($groupedReports)
    {
        $this->groupedReports = collect($groupedReports)->values();
    }

    public function collection()
    {
        $data = $this->groupedReports->map(function ($group) {
            return [
                'Organization' => $group['organization']->organization_name ?? '-',
                'No. of Test' => $group['test_count'],
                'No. of QC' => '',
                'Amount' => $group['test_value'],
                'Our Revenue' => $group['our_revenue'],
                'Date' => \Carbon\Carbon::parse($group['date'])->format('d-m-Y'),
            ];
        });

        // ➕ Insert blank row
        $blankRow = [
            'Organization' => '',
            'No. of Test' => '',
            'No. of QC' => '',
            'Amount' => '',
            'Our Revenue' => '',
            'Date' => '',
        ];

        // ✅ Total Revenue Row
        $totalRevenue = $this->groupedReports->sum('our_revenue');
        $totalRow = [
            'Organization' => '',
            'No. of Test' => '',
            'No. of QC' => '',
            'Amount' => '',
            'Our Revenue' => $totalRevenue,
            'Date' => 'Total Revenue',
        ];

        // Combine: data + blank row + total row
        return $data
            ->push($blankRow)
            ->push($totalRow);
    }

    public function headings(): array
    {
        return [
            'Organization',
            'No. of Test',
            'No. of QC',
            'Amount',
            'Our Revenue',
            'Date',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Bold the heading row (row 1)
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
