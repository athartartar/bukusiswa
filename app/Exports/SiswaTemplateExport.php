<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaTemplateExport implements WithHeadings, WithStyles, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'NIS',
            'NAMA_LENGKAP',
            'KELAS',
            'JENIS_KELAMIN (L/P)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF37517E'],
                ],
            ],
        ];
    }
}