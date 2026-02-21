<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow; 

class SiswaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (!isset($row['nis']) || !isset($row['nama_lengkap'])) continue;

            $formattedName = ucwords(strtolower($row['nama_lengkap']));

            $user = User::updateOrCreate(
                ['username' => $row['nis']],
                [
                    'namalengkap' => $formattedName,
                    'password' => Hash::make('siswa123'),
                    'usertype' => 'siswa',
                    'status' => 'aktif',
                ]
            );
            Siswa::updateOrCreate(
                ['nis' => $row['nis']],
                [
                    'namalengkap' => $formattedName,
                    'kelas' => $row['kelas'],
                    'jeniskelamin' => $row['gender'], 
                    'id_user' => $user->id_user 
                ]
            );
        }
    }
}
