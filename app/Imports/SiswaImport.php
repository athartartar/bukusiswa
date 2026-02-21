<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // Asumsi Excel ada headernya

class SiswaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Pastikan data di excel valid
            if (!isset($row['nis']) || !isset($row['nama_lengkap'])) continue;

            $formattedName = ucwords(strtolower($row['nama_lengkap']));

            // 1. Create/Update Siswa
            Siswa::updateOrCreate(
                ['nis' => $row['nis']], // Cek based on NIS
                [
                    'namalengkap' => $formattedName,
                    'kelas' => $row['kelas'],
                    'jeniskelamin' => $row['gender'] // Pastikan di excel L/P
                ]
            );

            // 2. Create/Update User
            User::updateOrCreate(
                ['username' => $row['nis']],
                [
                    'namalengkap' => $formattedName,
                    'password' => Hash::make('siswa123'),
                    'usertype' => 'siswa',
                    'status' => 'aktif',
                ]
            );
        }
    }
}
