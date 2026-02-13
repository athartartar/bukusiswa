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

                // 1. Simpan/Update Siswa
                Siswa::updateOrCreate(
                    ['id_siswa' => $request->id],
                    [
                        'nis' => $request->nis,
                        'namalengkap' => $formattedName,
                        'kelas' => $request->class,
                        'jeniskelamin' => $request->gender
                    ]
                );

                // 2. Simpan/Update User (Sync)
                // Kita gunakan NIS sebagai kunci pencarian di Username
                User::updateOrCreate(
                    ['username' => $request->nis], // Cari berdasarkan username (NIS)
                    [
                        'namalengkap' => $formattedName,
                        'password' => Hash::make('siswa123'), // Default password
                        'usertype' => 'siswa',
                        'status' => 'aktif',
                        // Jika ada field lain di tabel users yang wajib (not null), tambahkan di sini
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
                // Ambil data siswa dulu untuk dapat NIS-nya
                $siswa = Siswa::find($id);

                if ($siswa) {
                    // Nonaktifkan User berdasarkan NIS
                    $user = User::where('username', $siswa->nis)->first();
                    if ($user) {
                        $user->update(['status' => 'nonaktif']);
                    }

                    // Hapus data siswa
                    $siswa->delete();
                }
            });

            return response()->json(['success' => 'Data dihapus dan akun dinonaktifkan!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus data.'], 500);
        }
    }

    // Fungsi Baru: Export
    public function export()
    {
        return Excel::download(new SiswaExport, 'data_siswa.xlsx');
    }
    // 1. Download Template Kosong
    public function downloadTemplate()
    {
        return Excel::download(new SiswaTemplateExport, 'template_siswa.xlsx');
    }

    // 2. Preview Data (Hanya membaca Excel dan dikirim balik sebagai JSON)
    public function previewImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            // Membaca file ke array
            $data = Excel::toArray([], $request->file('file'));

            // Mengambil sheet pertama
            $rows = $data[0] ?? [];

            // Hapus header (baris pertama) jika perlu, atau gunakan WithHeadingRow di import
            // Di sini kita asumsikan baris 1 adalah header, jadi kita ambil data mulai baris 2
            // Namun agar rapih, kita mapping ulang

            $formattedData = [];
            foreach (array_slice($rows, 1) as $row) {
                // Pastikan baris tidak kosong
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

    // 3. Simpan Data Batch (Menerima JSON dari hasil preview yang disetujui)
    public function storeBatch(Request $request)
    {
        $data = $request->input('data');

        if (empty($data)) {
            return response()->json(['error' => 'Tidak ada data untuk disimpan.'], 400);
        }

        try {
            DB::transaction(function () use ($data) {
                foreach ($data as $row) {
                    // Validasi sederhana per baris (opsional)
                    if (empty($row['nis']) || empty($row['namalengkap'])) continue;

                    $formattedName = ucwords(strtolower($row['namalengkap']));

                    // 1. Simpan Siswa
                    Siswa::updateOrCreate(
                        ['nis' => $row['nis']],
                        [
                            'namalengkap' => $formattedName,
                            'kelas' => $row['kelas'],
                            'jeniskelamin' => $row['jeniskelamin']
                        ]
                    );

                    // 2. Simpan User
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
            });

            return response()->json(['success' => 'Berhasil mengimpor ' . count($data) . ' data siswa!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menyimpan: ' . $e->getMessage()], 500);
        }
    }
    // Fungsi Baru: Import
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
