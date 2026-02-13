<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return Siswa::select('nis', 'namalengkap', 'kelas', 'jeniskelamin')->get();
    }

    public function headings(): array
    {
        return [
            'NIS',
            'NAMA LENGKAP',
            'KELAS',
            'GENDER',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style baris pertama (Header) jadi Bold dan background
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF37517E'], // Warna biru tema kamu
                ],
            ],
        ];
    }
}
