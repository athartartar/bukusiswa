<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User; // Pastikan User model di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
use App\Exports\SiswaTemplateExport;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswas,nis,' . $request->id . ',id_siswa',
            'name' => 'required',
            'class' => 'required',
            'gender' => 'required',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $formattedName = ucwords(strtolower($request->name));

                $user = User::updateOrCreate(
                    ['username' => $request->nis], 
                    [
                        'namalengkap' => $formattedName,
                        'password' => Hash::make('siswa123'), 
                        'usertype' => 'siswa',
                        'status' => 'aktif',
                    ]
                );

                Siswa::updateOrCreate(
                    ['id_siswa' => $request->id],
                    [
                        'nis' => $request->nis,
                        'namalengkap' => $formattedName,
                        'kelas' => $request->class,
                        'jeniskelamin' => $request->gender,
                        'id_user' => $user->id_user
                    ]
                );
            });

            return response()->json(['success' => 'Data siswa dan akun berhasil disimpan!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $siswa = Siswa::where('id_siswa', $id)->first();

                if (!$siswa) {
                    throw new \Exception('Data siswa tidak ditemukan di database.');
                }

                $user = User::where('username', $siswa->nis)->first();
                if ($user) {
                    $user->update(['status' => 'nonaktif']);
                }

                $siswa->delete();
            });

            return response()->json(['success' => 'Data dihapus dan akun dinonaktifkan!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus: ' . $e->getMessage()], 500);
        }
    }

    public function export()
    {
        return Excel::download(new SiswaExport, 'data_siswa.xlsx');
    }
    public function downloadTemplate()
    {
        return Excel::download(new SiswaTemplateExport, 'template_siswa.xlsx');
    }

    public function previewImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            $data = Excel::toArray([], $request->file('file'));

            $rows = $data[0] ?? [];
            $formattedData = [];
            foreach (array_slice($rows, 1) as $row) {
                if (empty($row[0]) && empty($row[1])) continue;

                $formattedData[] = [
                    'nis' => $row[0],
                    'namalengkap' => $row[1],
                    'kelas' => $row[2],
                    'jeniskelamin' => $row[3],
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $formattedData,
                'count' => count($formattedData)
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal membaca file: ' . $e->getMessage()], 500);
        }
    }

    public function storeBatch(Request $request)
    {
        $data = $request->input('data');

        if (empty($data)) {
            return response()->json(['error' => 'Tidak ada data untuk disimpan.'], 400);
        }

        try {
            DB::transaction(function () use ($data) {
                foreach ($data as $row) {
                    if (empty($row['nis']) || empty($row['namalengkap'])) continue;

                    $formattedName = ucwords(strtolower($row['namalengkap']));

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
                            'jeniskelamin' => $row['jeniskelamin'],
                            'id_user' => $user->id_user // <--- Tambahkan baris ini
                        ]
                    );
                }
            });

            return response()->json(['success' => 'Berhasil mengimpor ' . count($data) . ' data siswa!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menyimpan: ' . $e->getMessage()], 500);
        }
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new SiswaImport, $request->file('file'));
            return response()->json(['success' => 'Data berhasil diimpor!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal impor: ' . $e->getMessage()], 500);
        }
    }
}
