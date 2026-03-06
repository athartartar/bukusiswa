<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kode_kelas' => 'required|unique:kelas,kode_kelas,' . $request->id . ',id_kelas',
            'status' => 'required',
        ]);

        // Simpan atau Update data
        $kelas = Kelas::updateOrCreate(
            ['id_kelas' => $request->id],
            [
                'kode_kelas' => strtoupper($request->kode_kelas),
                'status' => $request->status,
            ]
        );

        // KITA UBAH RETURN-NYA DI SINI
        // Kembalikan juga data $kelas yang baru disimpan agar bisa dibaca oleh Alpine.js
        return response()->json([
            'success' => 'Data Kelas berhasil disimpan!',
            'data' => $kelas
        ]);
    }

    public function destroy($id)
    {
        Kelas::destroy($id);

        return response()->json([
            'success' => 'Data Kelas berhasil dihapus!'
        ]);
    }
}
